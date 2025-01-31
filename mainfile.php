<?php

/**
 *
 * @package mainfile														
 * @version $Id: mainfile.php 11:12 AM 5/10/2011 $Aneeshtan						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */

define('BASE_PATH', dirname(__FILE__) . '/');

//===========================================
// composer
//===========================================
require __DIR__ . '/vendor/autoload.php';
//===========================================
// config
//===========================================
require BASE_PATH . 'includes/config.inc.php';
//===========================================
//Includes
//===========================================
require_once(BASE_PATH . "db/db.php");
//===========================================
//CONSTANTS 
//===========================================
require_once(BASE_PATH . 'includes/constants.php');
//===========================================
//global stripos checks
//===========================================

//Import Request Variables: 
extract($_REQUEST, EXTR_PREFIX_SAME | EXTR_REFS, 'nkln_');

// After doing those superglobals we can now use one
// and check if this file isnt being accessed directly
if (stristr(htmlentities($_SERVER['PHP_SELF']), "mainfile.php")) {
	die("Access Denied<br><b>" . $_SERVER['PHP_SELF'] . "</b>");
}

function stripos_clone($haystack, $needle, $offset = 0)
{
	$return = stripos($haystack, $needle, $offset = 0);
	if ($return === false) {
		return false;
	} else {
		return true;
	}
}


//===========================================
//Compression Functions
//===========================================
define("ENABLE_GZIP", 1); // change this into 0 to turn the GZIP off.

// Include this function on your pages
function print_gzipped_page()
{
	global $HTTP_ACCEPT_ENCODING;
	if (ENABLE_GZIP == 1) {
		if (headers_sent()) {
			$encoding = false;
		} elseif (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) {
			$encoding = 'x-gzip';
		} elseif (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false) {
			$encoding = 'gzip';
		} else {
			$encoding = false;
		}

		if ($encoding) {
			$contents = ob_get_contents();
			ob_end_clean();
			header('Content-Encoding: ' . $encoding);
			print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
			$size = strlen($contents);
			$contents = gzcompress($contents, 9);
			$contents = substr($contents, 0, $size);
			print($contents);
			exit();
		} else {
			ob_end_flush();
			exit();
		}
	}
}
// At the beginning of each page call these two functions
if (ENABLE_GZIP == 0) {
	ob_start(array('ob_gzhandler', 9));
	ob_implicit_flush(0);
}



//===========================================
//Error reporting
//===========================================
// to be set in config.php
if ($display_errors) {
	if (function_exists('ini_set')) {
		@ini_set('display_errors', 1);
	}
} else {
	if (function_exists('ini_set')) {
		@ini_set('display_errors', 0);
	}
}
error_reporting(E_ALL ^ E_NOTICE);

//===========================================
//SETTING TIME
//===========================================
if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set($_ENV['timezone']); //dynamic
}
//===========================================
// text filters
//===========================================
require_once(INCLUDES_PATH . "inc_htmlclean.php");
//===========================================
//  ADMIN && USER MAIN INTRODUCTION
//===========================================
function is_admin($admin)
{
	static $adminSave;

	if (!$admin) {
		return 0;
	}
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
		$sql = "SELECT pwd FROM " . $prefix . "_authors WHERE aid='$aid'";
		$result = $db->sql_query($sql);
		$pass = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if ($pass[0] == $pwd && !empty($pass[0])) {
			return $adminSave = 1;
		}
	}
	return $adminSave = 0;
}
function get_author($aid)
{
	global $prefix, $db;
	static $users;
	if (isset($users[$aid]) and is_array($users[$aid])) {
		$row = $users[$aid];
	} else {
		$sql = "SELECT url, email FROM " . $prefix . "_authors WHERE aid='$aid'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$users[$aid] = $row;
		$db->sql_freeresult($result);
	}
	$aidurl = check_html($row['url'], "nohtml");
	$aidmail = check_html($row['email'], "nohtml");
	if (isset($aidurl) && $aidurl != "http://") {
		$aid = "<a href=\"" . $aidurl . "\">$aid</a>";
	} elseif (isset($aidmail)) {
		$aid = "<a href=\"mailto:" . $aidmail . "\">$aid</a>";
	} else {
		$aid = $aid;
	}
	return $aid;
}
function cookiedecode($user)
{
	global $cookie, $db, $prefix;
	static $pass;
	if (!is_array($user)) {
		$user = base64_decode($user);
		$user = addslashes($user);
		$cookie = explode(":", $user);
	} else {
		$cookie = $user;
	}
	if (!isset($pass) and isset($cookie[1])) {
		$sql = "SELECT user_password FROM " . $prefix . "_users WHERE username='$cookie[1]'";
		$result = $db->sql_query($sql);
		list($pass) = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	}
	if (isset($cookie[2]) and ($cookie[2] == $pass) and (!empty($pass))) {
		return $cookie;
	}
}
function getusrinfo($user)
{
	global $prefix, $db, $userinfo, $cookie;
	if (!$user or empty($user)) {
		return NULL;
	}
	cookiedecode($user);
	$user = $cookie;
	if (isset($userrow) and is_array($userrow)) {
		if ($userrow['username'] == $user[1] && $userrow['user_password'] == $user[2]) {
			return $userrow;
		}
	}
	$sql = "SELECT * FROM " . $prefix . "_users WHERE username='$user[1]' AND user_password='$user[2]'";
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
require_once(INCLUDES_PATH . "inc_functions.php");
//===========================================
// DATE TIME Functions
//===========================================
require_once(INCLUDES_PATH . "inc_JalaliDate.php");


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
	require_once(INCLUDES_PATH . "inc_nextGenTap.php");
}

//===========================================
// Theme Engine
//===========================================
if (!defined("ADMIN_FILE") and !defined('FORUM_ADMIN')) {

	$ThemeSel = get_theme();
	define("_DEAULT_THEME_", $ThemeSel);
	define("THEME_FILE", "themes/" . _DEAULT_THEME_ . "/theme.php");
	define("THEME_ENGINE", INCLUDES_PATH . "inc_template.php");

	// THEME CLASS FILE
	require_once(INCLUDES_PATH . "template.class.php");
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
if (defined("TAGS_INC")) {
	require_once(INCLUDES_PATH . "inc_tags.php");
}
//===========================================
// LOGGING SYSTEM
//===========================================
if (LOG_INC) {
	require_once(INCLUDES_PATH . "inc_logging.php");
	$log = new Logging();
}
//===========================================
// IP BAN SYSTEM : DEV :  1 query
//===========================================
require_once(INCLUDES_PATH . "ipban.php");

//===========================================
// EMAIL SYSTEM :  DEV : high memory load
//===========================================
if (MAIL_CLASS == 1) {
	if (file_exists(INCLUDES_PATH . "inc_messenger.php")) {
		require_once(INCLUDES_PATH . "inc_messenger.php");
	}
}
//===========================================
// Session SYSTEM DEV : 3 queries
//===========================================
$sstart = benchGetTime();
require_once(INCLUDES_PATH . "inc_session.php");
$NK_session = new mr_session();
$NK_session->mr_session_begin();
$send = benchGetTime();
echo BENCHMARK;
if (BENCHMARK == true) {
	echo benchmark_overall($sstart, $send, 'SESSION');
}
//===========================================
// END OF CORE
//===========================================
