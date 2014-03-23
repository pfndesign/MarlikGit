<?php
/**
*
* @package mainfile														
* @version $Id: mainfile.php 11:12 AM 5/10/2011 $Aneeshtan						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

//===========================================
// PHP  Transaction
//===========================================

if(!defined('END_TRANSACTION')) {
	define('END_TRANSACTION', 2);
}

// Get php version
$phpver = phpversion();


//===========================================
//global stripos checks
//===========================================


// convert superglobals if php is lower then 4.1.0
if ($phpver < '4.1.0') {
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_FILES = $HTTP_POST_FILES;
	$_ENV = $HTTP_ENV_VARS;
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$_REQUEST = $_POST;
	} elseif($_SERVER['REQUEST_METHOD'] == "GET") {
		$_REQUEST = $_GET;
	}
	if(isset($HTTP_COOKIE_VARS)) {
		$_COOKIE = $HTTP_COOKIE_VARS;
	}
	if(isset($HTTP_SESSION_VARS)) {
		$_SESSION = $HTTP_SESSION_VARS;
	}
	
	if (!ini_get('register_globals')) {
	@import_request_variables("GPC", "");
	}
	
}
// override old superglobals if php is higher then 4.1.0
if($phpver >= '4.1.0') {
	$HTTP_GET_VARS = $_GET;
	$HTTP_POST_VARS = $_POST;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_POST_FILES = $_FILES;
	$HTTP_ENV_VARS = $_ENV;
	$PHP_SELF = $_SERVER['PHP_SELF'];
	if(isset($_SESSION)) {
		$HTTP_SESSION_VARS = $_SESSION;
	}
	if(isset($_COOKIE)) {
		$HTTP_COOKIE_VARS= $_COOKIE;
	}
	//Import Request Variables: 
	extract($_REQUEST, EXTR_PREFIX_SAME|EXTR_REFS, 'nkln_');

	if (!ini_get('register_globals')) {
	//@import_request_variables("GPC", ""); There is no need of this in new version of PHP 5.2+ 
	}
}

// After doing those superglobals we can now use one
// and check if this file isnt being accessed directly
if (stristr(htmlentities($_SERVER['PHP_SELF']), "mainfile.php")) {
	die("Access Denied<br><b>".$_SERVER['PHP_SELF']."</b>");
}
if (!function_exists("floatval")) {
	function floatval($inputval) {
		return (float)$inputval;
	}
}


if(!function_exists('stripos')) {
	function stripos_clone($haystack, $needle, $offset=0) {
		$return = strpos(strtoupper($haystack), strtoupper($needle), $offset);
		if ($return === false) {
			return false;
		} else {
			return true;
		}
	}
} else {
	// But when this is PHP5, we use the original function
	function stripos_clone($haystack, $needle, $offset=0) {
		$return = stripos($haystack, $needle, $offset=0);
		if ($return === false) {
			return false;
		} else {
			return true;
		}
	}
}

//===========================================
//Compression Functions
//===========================================
define("ENABLE_GZIP",1); // change this into 0 to turn the GZIP off.
function playWithHtml($OutputHtml){
	return preg_replace("/\s+/"," ",$OutputHtml);
}
// Include this function on your pages
function print_gzipped_page() {
	global $HTTP_ACCEPT_ENCODING;
	if(ENABLE_GZIP==1){
		if( headers_sent() ){
			$encoding = false;
		}elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
			$encoding = 'x-gzip';
		}elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
			$encoding = 'gzip';
		}else{
			$encoding = false;
		}

		if( $encoding ){
			$contents = ob_get_contents();
			ob_end_clean();
			header('Content-Encoding: '.$encoding);
			print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
			$size = strlen($contents);
			$contents = gzcompress($contents, 9);
			$contents = substr($contents, 0, $size);
			print($contents);
			exit();
		}else{
			ob_end_flush();
			exit();
		}
	}
}
// At the beginning of each page call these two functions
if(ENABLE_GZIP==0){
	ob_start(array('ob_gzhandler',9));
	ob_implicit_flush(0);
}
//===========================================
//Define CONSTANTS
//===========================================
//Absolute PHP-Nuke directory
define('PHOENIX_BASE_DIR', dirname(__FILE__) . '/');
// Absolute Phoenix Directory And Includes
define('PHOENIX_INCLUDE_DIR', PHOENIX_BASE_DIR.'includes/');

define("IN_USV",true);
define('BASE_PATH', dirname(__FILE__) . '/');
define('INCLUDES_PATH', 'includes/');
define("INCLUDES_UCP", "modules/Your_Account/includes/");
define('INCLUDES_ACP',	INCLUDES_PATH. 'acp/');

define('IMAGES_PATH',   BASE_PATH . 'images/');
define('THEMES_PATH',   BASE_PATH . 'themes/');
define('MODULES_PATH', 	'modules/');
define('ADMIN_PATH',	BASE_PATH . 'admin/');
define('DB_PATH',	 	BASE_PATH . 'db/');
define('JAVASCRIPT_PATH',	 	INCLUDES_PATH. 'javascript/');
define('SCRIPT_PATH',	 	 JAVASCRIPT_PATH. 'jquery/dist/');
define('SCRIPT_PLUGINS_PATH',JAVASCRIPT_PATH. 'jquery/plugins/');
define('SCRIPT_SRC_PATH',JAVASCRIPT_PATH. 'jquery/src/');
define('MODS_PATH',INCLUDES_PATH. 'mods/');
define('LANGUAGE_PATH',			BASE_PATH . 'language/');
define('ADMIN_LANGUAGE_PATH',	BASE_PATH . 'admin/language/');
define('IMAGES_ICON',	IMAGES_PATH. 'icon/');

if(defined('FORUM_ADMIN')) {
	define('INCLUDE_PATH', '../../../');
} elseif(defined('INSIDE_MOD')) {
	define('INCLUDE_PATH', '../../');
} else {
	define('INCLUDE_PATH', './');
}

//===========================================
//Includes
//===========================================

require_once(BASE_PATH."config.php");
require_once(INCLUDES_PATH."sql_layer.php");
require_once(DB_PATH."db.php");


//===========================================
//CUSTOM FUNCTIONS
//===========================================
if (file_exists(INCLUDES_PATH."custom_files/custom_mainfile.php")) {
	include_once(INCLUDES_PATH."custom_files/custom_mainfile.php");
}
//===========================================
//Error reporting
//===========================================
// to be set in config.php
if($display_errors) {
	if (function_exists('ini_set')) {
		@ini_set('display_errors', 1);
	}
} else {
	if (function_exists('ini_set')) {
		@ini_set('display_errors', 0);
	}
}
error_reporting(E_ALL^E_NOTICE);

//===========================================
//SETTING TIME
//===========================================
// Set default timezone in PHP 5.
if ($phpver >= '5.0.0') {
if ( function_exists( 'date_default_timezone_set' ) ){
	date_default_timezone_set( 'Asia/Tehran' );
}
}else {
	if(!ini_get('safe_mode') ){
		putenv('TZ=Asia/Tehran');
	}
}
//===========================================
// text filters
//===========================================
require_once(INCLUDES_PATH."inc_htmlclean.php");

//===========================================
//CONSTANTS 
//===========================================
require_once(INCLUDES_PATH . 'constants.php');

//===========================================
//Guardian SYSTEM DEV : 0 querries :  ?  kb memory load
//===========================================
define('PHP_FIREWALL_ACTIVATION',true);
//require_once(INCLUDES_PATH."inc_guardian.php");

//===========================================
//  ADMIN && USER MAIN INTRODUCTION
//===========================================
function is_admin($admin) {
	static $adminSave;

	if (!$admin) { return 0; }
	if (isset($adminSave)) return $adminSave;
	if (!is_array($admin)) {
		$admin = base64_decode($admin);
		$admin = addslashes($admin);
		$admin = explode(':', $admin);
	}
	$aid = $admin[0];
	$pwd = $admin[1];
	$aid = substr(addslashes($aid), 0, 25);
	if (!empty($aid) && !empty($pwd)) {
		global $prefix, $db;
		$sql = "SELECT pwd FROM ".$prefix."_authors WHERE aid='$aid'";
		$result = $db->sql_query($sql);
		$pass = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if ($pass[0] == $pwd && !empty($pass[0])) {
			return $adminSave = 1;
		}
	}
	return $adminSave = 0;
}
function get_author($aid) {
	global $prefix, $db;
	static $users;
	if (isset($users[$aid]) AND is_array($users[$aid])) {
		$row = $users[$aid];
	} else {
		$sql = "SELECT url, email FROM ".$prefix."_authors WHERE aid='$aid'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$users[$aid] = $row;
		$db->sql_freeresult($result);
	}
	$aidurl = check_html($row['url'], "nohtml");
	$aidmail = check_html($row['email'], "nohtml");
	if (isset($aidurl) && $aidurl != "http://") {
		$aid = "<a href=\"".$aidurl."\">$aid</a>";
	} elseif (isset($aidmail)) {
		$aid = "<a href=\"mailto:".$aidmail."\">$aid</a>";
	} else {
		$aid = $aid;
	}
	return $aid;
}
function cookiedecode($user) {
	global $cookie, $db, $user_prefix;
	static $pass;
	if(!is_array($user)) {
		$user = base64_decode($user);
		$user = addslashes($user);
		$cookie = explode(":", $user);
	} else {
		$cookie = $user;
	}
	if (!isset($pass) AND isset($cookie[1])) {
		$sql = "SELECT user_password FROM ".$user_prefix."_users WHERE username='$cookie[1]'";
		$result = $db->sql_query($sql);
		list($pass) = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	}
	if (isset($cookie[2]) AND ($cookie[2] == $pass) AND (!empty($pass))) { return $cookie; }
}
function getusrinfo($user) {
	global $user_prefix, $db, $userinfo, $cookie;
	if (!$user OR empty($user)) {
		return NULL;
	}
	cookiedecode($user);
	$user = $cookie;
	if (isset($userrow) AND is_array($userrow)) {
		if ($userrow['username'] == $user[1] && $userrow['user_password'] == $user[2]) {
			return $userrow;
		}
	}
	$sql = "SELECT * FROM ".$user_prefix."_users WHERE username='$user[1]' AND user_password='$user[2]'";
	$result = $db->sql_query($sql);
	if ($db->sql_numrows($result) == 1) {
		static $userrow;
		$userrow = $db->sql_fetchrow($result);
		return $userinfo = $userrow;
	}
	$db->sql_freeresult($result);
	unset($userinfo);
}

//===========================================
//  CORE FUNCTIONS DIRECTORY
//===========================================
require_once(INCLUDES_PATH."inc_functions.php");
//===========================================
// DATE TIME Functions
//===========================================
require_once(INCLUDES_PATH."inc_JalaliDate.php");


if (defined('FORUM_ADMIN')) {
	include_once("../../../modules/Your_Account/includes/mainfileend.php");
} elseif (defined('INSIDE_MOD')) {
	include_once("../../modules/Your_Account/includes/mainfileend.php");
} else {
	include_once("modules/Your_Account/includes/mainfileend.php");
}

//===========================================
// nextGen Functions
//===========================================

if (!defined("ADMIN_FILE")) {
	require_once(INCLUDES_PATH."inc_nextGenTap.php");
}

//===========================================
// Theme Engine
//===========================================
if (!defined("ADMIN_FILE") AND !defined('FORUM_ADMIN')) {

	$ThemeSel = get_theme();
	define("_DEAULT_THEME_",$ThemeSel);
	define("THEME_FILE","themes/"._DEAULT_THEME_."/theme.php");
	define("THEME_ENGINE",INCLUDES_PATH."inc_template.php");

	// THEME CLASS FILE
	require_once(INCLUDES_PATH."template.class.php");
	/*** create a new instance ***/
	$te_page = new USV_Template;

	// Set the cache properties
	if ($CacheSystem == 1) {

		/*** turn cache on or off ***/
		$te_page->setCaching(true);

		/*** set the cache directory ***/
		$te_page->setCacheDir("cache");

		/*** set the cache lifetime in seconds ***/
		$te_page->setCacheLifetime($lifetime);

		/*** clear the cache ***/
		// $te_page->clearCache();
	}
}
//===========================================
// TAGGING SYSTEM
//===========================================
if (defined("TAGS_INC")){
	require_once(INCLUDES_PATH."inc_tags.php");
}
//===========================================
// LOGGING SYSTEM
//===========================================
if (LOG_INC) {
	require_once(INCLUDES_PATH."inc_logging.php");
	$log = new Logging();
}
//===========================================
// IP BAN SYSTEM : DEV :  1 query
//===========================================
require_once(INCLUDES_PATH."ipban.php");

//===========================================
// EMAIL SYSTEM :  DEV : high memory load
//===========================================
if (MAIL_CLASS==1) {
	if (file_exists(INCLUDES_PATH."inc_messenger.php")) {
		require_once(INCLUDES_PATH."inc_messenger.php");
	}
}
//===========================================
// Session SYSTEM DEV : 3 queries
//===========================================
$sstart = benchGetTime();
require_once(INCLUDES_PATH."inc_session.php");
$NK_session = new mr_session();
$NK_session->mr_session_begin();
$send = benchGetTime();
if (BENCHMARK==true) {
	echo benchmark_overall($sstart,$send,'SESSION');
}
//===========================================
// END OF CORE
//===========================================
?>
