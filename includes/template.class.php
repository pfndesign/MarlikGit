<?php
/**
 *
 * @package Template Englin Class												
 * @version  template.class.php $Aneeshtan 12:11 PM 1/22/2010						
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "template.class.php" )) {
	show_error ( HACKING_ATTEMPT );
}
//define("templatefilename","main.html");

class USV_Template {

	var $templatefil;
	var $varnamelist;
	var $title;
	var $content;
	var $tpe_function;
	var $_variables = array();
	/**
 * The directory where the cache files will be saved.
 *
 * @access private
 * @var string
 */
	private $cache_dir = 'cache';


	public function addVar($name, $value)
	{
		$variables = &$this->_variables;
		$variables[$name] = $value;
	}

	public function displayContent() {
		
	
		$vararray = explode(",",trim($this->varnamelist));
		$templatearray = file($this->templatefile);
		$template = join("",$templatearray);
			

		
		foreach ($vararray as $varname) {
			$template = str_replace("[$varname]",$this->$varname,$template);
		}

		//lets check if we have lang tag in our template files.
		//1.1.5
		$dom = new DOMDocument();
		$dom->prevservWhiteSpace = false;
		if (!@$dom->loadHTMLFile($this->templatefile)) {
			_e("$this->templatefile <br>"._FILE_NOT_EXISTS."");
			return;
		}
		$lang = $dom->getElementsByTagName('lang');
		$langtot  = $lang->length;
		for ($i = 0; $i < $langtot; $i++) {
		$template = str_replace($lang->item($i)->nodeValue,langit($lang->item($i)->nodeValue),$template);
		}
		
			
		$template = preg_replace("/\[_(.*)\]/e", langit("_$1"), $template);


		
		
		print $template;
	}

	public function display($file, $id = false)
	{
		echo $this->fetch($file, $id);
	}

	private function fetch($file, $id = false)
	{
		if ($this->_caching == true && $this->isCached($file, $id)) {
			$output = $this->_getCache($file, $id);
		} else {
			$output = $this->_getOutput($file);

			if ($this->_caching == true) {
				$this->_addCache($output, $file, $id);
			}
		}

		return isset($output) ? $output : false;
	}

	public function _getOutput($file)
	{
		$vararray = explode(",",trim($this->varnamelist));
		$templatearray = file($this->templatefile);
		$template = join("",$templatearray);
		foreach ($vararray as $varname) {
			$template = str_replace("[$varname]",$this->$varname,$template);
		}
		$template = preg_replace("/\[_(.*)\]/e", langit("_$1"), $template);


		//lets check if we have lang tag in our template files.
		//1.1.5
		$dom = new DOMDocument();
		$dom->prevservWhiteSpace = false;
		if (!@$dom->loadHTMLFile($this->templatefile)) {
			_e("$this->templatefile <br>"._FILE_NOT_EXISTS."");
			return;
		}
		$lang = $dom->getElementsByTagName('lang');
		$langtot  = $lang->length;
		for ($i = 0; $i < $langtot; $i++) {
		$template = str_replace($lang->item($i)->nodeValue,langit($lang->item($i)->nodeValue),$template);
		}
		
		extract($this->_variables);
		$file = realpath($file);

		if (file_exists($file)) {
			ob_start();
			include($file);
			$output = $template;
  			ob_end_clean();
		} else {
			trigger_error("Failed opening the template file '$file'. The file doesn't exist.", E_USER_ERROR);
		}

		return !empty($output) ? $output : false;
	}

	public function setCacheDir($dir)
	{
		$dir = realpath($dir);

		if (is_dir($dir) && is_writable($dir)) {
			$this->_cacheDir = $dir;
		} else {
			trigger_error("The cache directory '$dir' either doesn't exist, or it cannot be written to by PHP", E_USER_WARNING);
			$this->_cacheDir = '';
			$this->_caching = false;
		}
	}

	function setCacheLifetime($seconds)
	{
		if (is_numeric($seconds)) {
			$this->_cacheLifetime = $seconds;
		}
	}

	public function setCaching($state)
	{
		if (is_bool($state)) {
			$this->_caching = $state;
		}
	}

	public function isCached($file, $id = false)
	{
		$id = $id ? md5($id . basename($file)) : md5(basename($file));
		$filename = $this->_cacheDir . '/' . $id . '/' . basename($file);

		if (is_file($filename)) {
			clearstatcache();

			if (filemtime($filename) > (time() - $this->_cacheLifetime)) {
				$isCached = true;
			}
		}

		return isset($isCached) ? true : false;
	}

	private function _addCache($content, $file, $id = false)
	{
		$id = $id ? $id.'-'. basename($file).md5($id) : md5(basename($file));
		$filename = $this->_cacheDir . '/' . $id . '/' . basename($file);
		$directory = $this->_cacheDir . '/' . $id;

		@mkdir($directory, 0775);

		if ($fp = fopen($filename, 'wb')) {
			fwrite($fp, $content);
			fclose($fp);
		}
	}

	private function _getCache($file, $id = false)
	{
		$id = $id ? md5($id . basename($file)) : md5(basename($file));
		$filename = $this->_cacheDir . '/' . $id . '/' . basename($file);

		if ($fp = fopen($filename, 'rb')) {
			$content = fread($fp, filesize($filename));
			fclose($fp);
		}

		return isset($content) ? $content : false;
	}

	public function clearCache(){
		$cacheDir = realpath($this->cache_dir);
		$this->delDir($cacheDir);
	}
	

	private function delDir($dir) {

		/*** perhaps a recursiveDirectoryIteratory here ***/
		$deleteDir = realpath($dir);

		if ($handle = opendir($deleteDir))
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file != '.' && $file != '..')
				{
					if (is_dir($deleteDir . '/' . $file))
					{
						$this->delDir($deleteDir . '/' . $file);
						if(is_writable($deleteDir . '/' . $file))
						{
							rmdir($deleteDir . '/' . $file);
						}
						else
						{
							throw new Exception("Unable to remove Directory");
						}
					}
					elseif(is_file($deleteDir . '/' . $file))
					{
						if(is_writable($deleteDir . '/' . $file))
						{
							unlink($deleteDir . '/' . $file);
						}
						else
						{
							throw new Exception("Unable to unlink $deleteDir".'/'."$file");
						}
					}
				}
			}
			closedir($handle);
		}
	}

	
}

?>