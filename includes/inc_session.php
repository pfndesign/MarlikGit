<?php
/**
*
* @package session CLASS														
* @version $Id: inc_session.php  2:38 AM 12/18/2010  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com	& Inspired By PHPBB3 Session Class										
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (stristr(htmlentities($_SERVER['PHP_SELF']), "inc_session.php")) {
	die("Access Denied<br><b>".$_SERVER['PHP_SELF']."</b>");
}
global $prefix;
//--- Defining Constants ----
define('NK_SESSION_TABLE',''.$prefix.'_session');
define('NK_USERS_TABLE',''.$prefix.'_users');
define('EXPIRE_TIME',''.(time()-7200).'');


/**
* Base Nukelearn Session class
*
* This is the overarching class which contains Session handling functions
*
* @package Nukelearn
*/

class mr_session
{

	/**
* Required VARS For Sessions 
*
**/

	var $page = array();
	var $data = array();
	var $browser = '';
	var $session_admin = 0;
	var $user_id = '';
	var $host = '';			//Current HOST name  --
	var $session_id = '';	//Current Session ID --
	var $ip = ''; 			//Current IP Address --
	var $ctime = 0;			// Current Time 	 --
	var $session_last_visit = 0;			// Current Time 	 --
	var $ip_check = 1;		// IF set to 1 means Checking IP in session table and eliminating repeated ips 	 --

	/**
* Necessary Functions For Sessions 
*
**/
	/**
	* Extract current session page
	*
	* @param string $root_path current root path (phpbb_root_path)
	*/
	function extract_current_page($root_path)
	{
		global $nukeurl;
		$page_array = array();

		// First of all, get the request uri...
		$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
		$args = (!empty($_SERVER['QUERY_STRING'])) ? explode('&', $_SERVER['QUERY_STRING']) : explode('&', getenv('QUERY_STRING'));

		// If we are unable to get the script name we use REQUEST_URI as a failover and note it within the page array for easier support...
		if (!$script_name)
		{
			$script_name = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
			$script_name = (($pos = strpos($script_name, '?')) !== false) ? substr($script_name, 0, $pos) : $script_name;
			$page_array['failover'] = 1;
		}

		// Replace backslashes and doubled slashes (could happen on some proxy setups)
		$script_name = str_replace(array('\\', '//'), '/', $script_name);

		// Now, remove the sid and let us get a clean query string...
		$use_args = array();

		// Since some browser do not encode correctly we need to do this with some "special" characters...
		// " -> %22, ' => %27, < -> %3C, > -> %3E
		$find = array('"', "'", '<', '>');
		$replace = array('%22', '%27', '%3C', '%3E');

		foreach ($args as $key => $argument)
		{
			if (strpos($argument, 'sid=') === 0)
			{
				continue;
			}

			$use_args[] = str_replace($find, $replace, $argument);
		}
		unset($args);

		// The following examples given are for an request uri of {path to the phpbb directory}/adm/index.php?i=10&b=2

		// The current query string
		$query_string = trim(implode('&', $use_args));

		// basenamed page name (for example: index.php)
		$page_name = (substr($script_name, -1, 1) == '/') ? '' : basename($script_name);
		$page_name = urlencode(htmlspecialchars($page_name));

		// current directory within the phpBB root (for example: adm)
		$root_dirs = explode('/', str_replace('\\', '/', $nukeurl));
		$page_dirs = explode('/', str_replace('\\', '/', $nukeurl));
		$intersection = array_intersect_assoc($root_dirs, $page_dirs);

		$root_dirs = array_diff_assoc($root_dirs, $intersection);
		$page_dirs = array_diff_assoc($page_dirs, $intersection);

		$page_dir = str_repeat('../', sizeof($root_dirs)) . implode('/', $page_dirs);

		if ($page_dir && substr($page_dir, -1, 1) == '/')
		{
			$page_dir = substr($page_dir, 0, -1);
		}

		// Current page from phpBB root (for example: adm/index.php?i=10&b=2)
		$page = (($page_dir) ? $page_dir . '/' : '') . $page_name . (($query_string) ? "?$query_string" : '');

		// The script path from the webroot to the current directory (for example: /phpBB3/adm/) : always prefixed with / and ends in /
		$script_path = trim(str_replace('\\', '/', dirname($script_name)));

		// The script path from the webroot to the phpBB root (for example: /phpBB3/)
		$script_dirs = explode('/', $script_path);
		array_splice($script_dirs, -sizeof($page_dirs));
		$root_script_path = implode('/', $script_dirs) . (sizeof($root_dirs) ? '/' . implode('/', $root_dirs) : '');

		// We are on the base level (phpBB root == webroot), lets adjust the variables a bit...
		if (!$root_script_path)
		{
			$root_script_path = ($page_dir) ? str_replace($page_dir, '', $script_path) : $script_path;
		}

		$script_path .= (substr($script_path, -1, 1) == '/') ? '' : '/';
		$root_script_path .= (substr($root_script_path, -1, 1) == '/') ? '' : '/';

		$page_array += array(
		'page_name'			=> $page_name,
		'page_dir'			=> $page_dir,

		'query_string'		=> $query_string,
		'script_path'		=> str_replace(' ', '%20', htmlspecialchars($script_path)),
		'root_script_path'	=> str_replace(' ', '%20', htmlspecialchars($root_script_path)),

		'page'				=> $page,
		'forum'				=> (isset($_REQUEST['f']) && $_REQUEST['f'] > 0) ? (int) $_REQUEST['f'] : 0,
		);

		return $page_array;
	}
	/**
	* Get valid hostname/port. HTTP_HOST is used, SERVER_NAME if HTTP_HOST not present.
	*/
	function extract_current_hostname()
	{
		global $config;

		// Get hostname
		$host = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : ((!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : getenv('SERVER_NAME'));

		// Should be a string and lowered
		$host = (string) strtolower($host);

		// If host is equal the cookie domain or the server name (if config is set), then we assume it is valid
		if ((isset($config['cookie_domain']) && $host === $config['cookie_domain']) || (isset($config['server_name']) && $host === $config['server_name']))
		{
			return $host;
		}

		// Is the host actually a IP? If so, we use the IP... (IPv4)
		if (long2ip(ip2long($host)) === $host)
		{
			return $host;
		}

		// Now return the hostname (this also removes any port definition). The http:// is prepended to construct a valid URL, hosts never have a scheme assigned
		$host = @parse_url('http://' . $host);
		$host = (!empty($host['host'])) ? $host['host'] : '';

		// Remove any portions not removed by parse_url (#)
		$host = str_replace('#', '', $host);

		// If, by any means, the host is now empty, we will use a "best approach" way to guess one
		if (empty($host))
		{
			if (!empty($config['server_name']))
			{
				$host = $config['server_name'];
			}
			else if (!empty($config['cookie_domain']))
			{
				$host = (strpos($config['cookie_domain'], '.') === 0) ? substr($config['cookie_domain'], 1) : $config['cookie_domain'];
			}
			else
			{
				// Set to OS hostname or localhost
				$host = (function_exists('php_uname')) ? php_uname('n') : 'localhost';
			}
		}

		// It may be still no valid host, but for sure only a hostname (we may further expand on the cookie domain... if set)
		return $host;
	}

	function unique_id($extra = 'c')
	{
		static $dss_seeded = false;

		$val = microtime();
		$val = md5($val);

		if ($dss_seeded !== true && ($val < time() - rand(1,10)))
		{
			$dss_seeded = true;
		}

		return substr($val, 4, 16);
	}

	/**
	* Start session management
	*
	
/**
* Base Session Functions
*
**/

	function mr_session_begin(){
		global $db,$ip_check,$cookie,$nukeurl,$admin;

		$userid = $cookie[0];
		$this->ctime				= time();
		//$this->ip 					= (getRealIpAddr()) ? getRealIpAddr() : $_SERVER['REMOTE_ADDR'];
		$this->ip = (!empty($_SERVER['REMOTE_ADDR'])) ? htmlspecialchars($_SERVER['REMOTE_ADDR']) : getRealIpAddr();

		if ($ip_check==1) {
		$condition = "OR s.session_ip='".$this->ip."'";
		}
		
		$sql = "SELECT u.user_id,s.*
				FROM ".NK_SESSION_TABLE." s,".NK_USERS_TABLE." u
				WHERE s.session_user_id = '".$userid."'
				OR	s.session_id = '".$_COOKIE['user']."' 
				".$condition." 
				LIMIT 1";
				
		$result = $db->sql_query($sql);
				
		$this->data = $db->sql_fetchrow($result);

		$this->mr_clear_sessions();
		
		// Give us some basic information
		$this->browser				= (!empty($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars((string) $_SERVER['HTTP_USER_AGENT']) : '';
		//$this->page					= $this->extract_current_page($nukeurl);
		//$this->page['page'] 		= str_replace (".././", "", $this->page['page']);

		if (empty($this->data['session_id'])) {
			$this->session_id	 		= (!empty($_COOKIE["user"])) ? $_COOKIE["user"] : md5($this->unique_id());
		}else {
			$this->session_id 			= $this->data['session_id'];
		}
		$this->session_admin 		= (is_admin($admin)) ? "1" : "0";
		$this->user_id 		 		= (!empty($userid)) ? "$userid" : "0";
		$this->session_last_visit	= (!empty($this->data['session_start'])) ? $this->data['session_start'] : $this->ctime;

		if (empty($this->data['session_id'])){
			$this->mr_session_create();
		}else {
			$this->mr_session_update($this->data['session_id']);
		}

		$db->sql_freeresult($result);

	}
	function mr_session_check(){
		global $ip_check;
		if ($ip_check == 1) {
			if ($this->data['session_ip'] == $this->ip) {
				if ($this->session_admin == 1) {
					$this->mr_kill_admin($this->user_id);
				}else {
					$this->mr_kill_user($this->user_id);
				}
				return 0;
			}else {
				return 1;
			}
		}
		return 1;
	}
	function mr_session_create(){
		global $db;
		//die("creating in process");
		$result = $db->sql_query(
		"INSERT INTO `".NK_SESSION_TABLE."`		(`session_id`,`session_user_id`,`session_last_visit`,`session_start`,`session_time`,`session_ip`,`session_browser`,`session_page`,`session_admin`)
		VALUES
		('".$this->session_id."', '".$this->user_id."', '".$this->ctime."', '".$this->ctime."', '".$this->ctime."', '".$this->ip."', '".$this->browser."',
		 '".$this->page['page']."', '".$this->session_admin."')") or die("Create New Session Error: ".mysql_error());		

		$db->sql_freeresult($result);

	}
	function mr_session_update($sid){
		global $db,$ip_check;

		//die("updating in process");
		$sid = sql_quote($sid);
		//!$this->mr_session_check()
		if (!empty($sid)) {		

		if ($ip_check==1) {
		$condition = "OR session_ip='".$this->ip."'";
		}
			
		$result = $db->sql_query("UPDATE ".NK_SESSION_TABLE." SET
		`session_user_id`='".$this->user_id."',
		`session_last_visit` ='".$this->ctime."',
		`session_start` ='".$this->ctime."',
		`session_time`='".$this->ctime."',
		`session_ip`='".$this->ip."', 
		`session_browser`='".$this->browser."', 
		`session_page`='".$this->page['page']."',
		`session_admin`='".$this->session_admin."' 
		 WHERE session_id='".$sid."'  OR `session_user_id`='".$this->user_id."' ") or die("Update error:".mysql_error());
		$db->sql_freeresult($result);
		
		
		//---- IF USER EXISTS SO WE NEED TO UPDATE HIS OWN ROW IN USERS' TABLE
		if (!empty($this->user_id)) {
		$result = $db->sql_query("UPDATE ".__USER_TABLE." SET
		`user_lastvisit`='".$this->ctime."',
		`last_ip`='".$this->ip."', 
		`user_session_page`='".$this->page['page']."'
		 WHERE `user_id`='".$this->user_id."' ");
		$db->sql_freeresult($result);
		}
		
		/*
		if (!$result) {
		show_error("<br>"._SESSION_ID." : $sid<br>"._SESSION_PROBLEM_UPDATE." :<br>".mysql_error()."");
		}
		*/

		
		}else {
			$this->mr_session_create();
		}
	}
	function mr_session_kill($uid){
		global $db;
		$uid = sql_quote($uid);
		$sql = "DELETE FROM  `".NK_SESSION_TABLE."` WHERE `session_user_id`='".$uid."'";
		$result = $db->sql_query($sql)or die(mysql_error());
		$db->sql_freeresult($result);
		//$db->sql_query("OPTIMIZE TABLE ".$prefix."_session");
	}
	function mr_cookie_kill(){
		/*--- Removing all cookies which blong to this domain ---
		if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
		$parts = explode('=', $cookie);
		$name = trim($parts[0]);
		setcookie($name, '', time()-1000);
		setcookie($name, '', time()-1000, '/');
		}
		*/
		setcookie("user", "", time()-1000);
		setcookie("user", '', time()-1000, '/');

	}
	function mr_kill_user($uid){
		$this->mr_session_kill($uid);
		$this->mr_cookie_kill();
	}
	function mr_kill_admin($uid){
		$this->mr_session_kill($uid);
		setcookie("admin", null, time()+$this->seconds, "/", $this->domain, 0);
		setcookie("admin","",time()-31536000); //-1year
	}
	function mr_clear_sessions(){
		global $db;
		$db->sql_query("DELETE FROM ".NK_SESSION_TABLE." WHERE session_time < '".EXPIRE_TIME."'");
	}
	/**
* Base Public Functions
*
**/	

	function count_online($guest = true , $time = 120){
		global $db;
		$time = sql_quote(intval($time));
		$guest = sql_quote($guest);

		$visitors = ($guest = true) ? 'session_user_id = 0' : 'session_user_id !=0';

		list($numOnline) = $db->sql_numrows($db->sql_query("SELECT session_user_id FROM ".NK_SESSION_TABLE." WHERE  session_time  > '".( time() - ($time * 60) )."' AND $visitors"));

		return intval($numOnline);

	}

}
?>