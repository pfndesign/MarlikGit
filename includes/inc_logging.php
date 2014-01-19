<?php
/**
*
* @package logging system Class														
* @version $Id: beta 0.6 11:02 AM 12/25/2009 Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
 * Logging class:
 * - contains lopen and lwrite methods
 * - lwrite will write message to the log file
 * - first call of the lwrite will open log file implicitly
 * - message is written with the following format: hh:mm:ss (script name) message
 */
class Logging{

	// define file pointer
	private $fp = null;
	// write message to the log file
	public function lwrite($file,$message){
		
		// define log file
		$log_file = INCLUDES_ACP.'log/' . $file . '.log';
		
		if(!empty($file) AND is_writable($log_file)){
	
			// if file pointer doesn't exist, then open log file
			if (!$this->fp) $this->lopen($log_file);
			// define script name
			// for PHP 5.2.0+  
			if ($phpver < '5.2.0') {
			$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
			}else {
			// for PHP before version 5.2.0
			$script_name = basename($_SERVER['PHP_SELF']);
			$script_name = substr($script_name, 0, -4); // php extension and dot are not needed
			}
	
			$time = date("d M Y - H:i:s");		// define current time
			$ip = GetHostByName(getRealIpAddr());		// define IP address
			
			$header ="---------[" . $time . "]-------[$script_name Section]--------[" . $ip . "]------\n";
		
			// write current time, script name and message to the log file
			fwrite($this->fp, "$header $message\n");
		}
		
	}
		
	// open log file
	private function lopen($log_file){

		// define the current date (it will be appended to the log file name)
		$today = date('Y-m-d');
		// open log file for writing only; place the file pointer at the end of the file
		// if the file does not exist, attempt to create it
		$this->fp = fopen($log_file , 'a') or exit("Can't open $log_file!");
	}
	
	function ldelete($file){
		if(!empty($file)){
		// define log file
		$log_file = INCLUDES_ACP.'log/' . $file . '.log';
		}else {
			show_error("Common , NO LOG FILE SPECIFIED");
		}
		unlink($log_file);
	}

}

?>