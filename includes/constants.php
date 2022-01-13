<?php

/**
 *
 * @package constants														
 * @version $Id: constants.php RC-7 11:49 AM 1/2/2010 Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */

if (!defined('IN_USV')) {
	exit;
}

if (stristr(htmlentities($_SERVER['PHP_SELF']), "constants.php")) {
	die("Access Denied<br><b>" . $_SERVER['PHP_SELF'] . "</b>");
}

//===========================================
//Defined Constants
//===========================================

define('VALIDATED',			'<img src="images/powered/vl.png">');
define('UNVALIDATED',		'<img src="images/powered/uvl.png">');
define('USV_VERSION', 'Tigris 1.1.6 3/24/2014');


/************************************************************************/
/* Use navigation(tm)
 * 0  = Do not display navigation top menu
 * 1  = Display navigation top menu for admins only
 * 2  = Display navigation top menu for all visitors
 ************************************************************************/
$usenukeNAV = 2;
$showAdminMenu = true; // Use "false" to hide the Super User (upper) portion of the ACP when navigation(tm) is in use

//===========================================
//TABLE Defined Path
//===========================================

global $admin_file, $db;
define("ADMIN_OP",					"" . $admin_file . ".php?op=");
define("ADMIN_PHP",					"" . $admin_file . ".php");

define("ZEBRA_TABLE", "" . $prefix . "_bb3zebra");
define("USERS_TABLE", "" . $prefix . "_bb3users");
define("PM_TO_TABLE", "" . $prefix . "_bb3privmsgs_to");
define("PM_TABLE", "" . $prefix . "_bb3privmsgs");

define("THANKS_TABLE",				"" . $prefix . "_bb3thanks");


//===========================================
//MarlikCMS TABLES :
//===========================================
//--Nuke Tables ---
define("STORY_TABLE",				"" . $prefix . "_stories");
define("STORY_CAT_TABLE",			"" . $prefix . "_stories_cat");
define("COMMENTS_TABLE",			"" . $prefix . "_comments_moderated");
define("DOWNLOAD_TABLE",			"" . $prefix . "_nsngd_downloads");
define("SUBMIT_DOWNLOAD_TABLE",		"" . $prefix . "_nsngd_new");
define("DOWNLOAD_CAT_TABLE",		"" . $prefix . "_nsngd_categories");
define("BLOG_TABLE",				"" . $prefix . "_blogs");
define("TAGS_TABLE",				"" . $prefix . "_tags");
define('USV_CONFIGS_TABLE',			$prefix . '_config');
define("USV_TOPICS_TABLE",			"" . $prefix . "_topics");
define("__USER_TABLE",				"" . $prefix . "_users");
define("_TOPICS_TABLE",				"" . $prefix . "_topics");
define("__SESSION_TABLE",			"" . $prefix . "_session");
define("__CONFIG_TABLE",			"" . $prefix . "_config");
define("__IPT_TABLE",				"" . $prefix . "_iptracking");
define("__COUNTER_TABLE",			"" . $prefix . "_counter");
define("__GROUP_TABLE",			"" . $prefix . "_groups");

/*
if (!defined("AUTH_TABLE")) {define('AUTH_TABLE',			$prefix . '_authors');};
if (!defined("BANNED_TABLE")) {define('BANNED_TABLE',			$prefix . '_banned_ip');};
if (!defined("BANNER_TABLE")) {define('BANNER_TABLE',			$prefix . '_banner');};
if (!defined("BLOCKS_TABLE")) {define('BLOCKS_TABLE',			$prefix . '_blocks');};
if (!defined("CNBYA_CONFIG_TABLE")) {define('CNBYA_CONFIG_TABLE',			$prefix . '_cnbya_config');};
if (!defined("CONFIGS_TABLE")) {define('CONFIGS_TABLE',			$prefix . '_config');};
define('GROUP_TABLE',			$prefix . '_groups');
define('GROUPS_POINTS_TABLE',	$prefix . '_groups_points');
define('MODULES_TABLE',			$prefix . '_modules');
define('STORIES_TABLE',			$prefix . '_stories');
define('STORIES_CAT_TABLE',		$prefix . '_stories_cat');
define('TAGS_TABLE',			$prefix . '_tags');
define('TOPICS_TABLE',			$prefix . '_topics');
define('USER_TABLE',			$prefix . '_users');
*/
//Forums config:
define("FORUMS_AVATAR_DIR", "forums/");
define("SITE_AVATAR_DIR", "modules/Your_Account/images/");
define("FORUMS_RANK_DIR", "forums/");
define("USER_IMG_DIR", "modules/Your_Account/images/");

//===========================================
// CONFIG TABLE COLUMNS
//===========================================
define('NUKE_FILE', true);

$sitesettings = Dotenv\Dotenv::createArrayBacked(__DIR__ . "/../", '.setting')->load();
$sitename = stripslashes(check_html($sitesettings['sitename'], "nohtml"));
$nukeurl = check_html($sitesettings['nukeurl'], "nohtml");
$site_logo = check_html($sitesettings['site_logo'], "nohtml");
$slogan = stripslashes(check_html($sitesettings['slogan'], "nohtml"));
$startdate = check_html($sitesettings['startdate'], "nohtml");
$adminmail = check_html($sitesettings['adminmail'], "nohtml");
$anonpost = intval($sitesettings['anonpost']);
$Default_Theme = check_html($sitesettings['Default_Theme'], "nohtml");
$foot1 = stripslashes(check_html($sitesettings['foot1'], ""));
$foot2 = stripslashes(check_html($sitesettings['foot2'], ""));
$foot3 = stripslashes(check_html($sitesettings['foot3'], ""));
$commentlimit = intval($sitesettings['commentlimit']);
$anonymous = check_html($sitesettings['anonymous'], "nohtml");
$minpass = intval($sitesettings['minpass']);
$pollcomm = intval($sitesettings['pollcomm']);
$articlecomm = intval($sitesettings['articlecomm']);
$broadcast_msg = intval($sitesettings['broadcast_msg']);
$my_headlines = intval($sitesettings['my_headlines']);
$top = intval($sitesettings['top']);
$storyhome = intval($sitesettings['storyhome']);
$user_news = intval($sitesettings['user_news']);
$oldnum = intval($sitesettings['oldnum']);
$ultramode = intval($sitesettings['ultramode']);
$loading = intval($sitesettings['loading']);
$nextg = intval($sitesettings['nextg']);
$banners = intval($sitesettings['banners']);
$backend_title = stripslashes(check_html($sitesettings['backend_title'], "nohtml"));
$backend_language = check_html($sitesettings['backend_language'], "nohtml");
$language = check_html($sitesettings['language'], "nohtml");
$locale = check_html($sitesettings['locale'], "nohtml");
$multilingual = intval($sitesettings['multilingual']);
$useflags = intval($sitesettings['useflags']);
$notify = intval($sitesettings['notify']);
$notify_email = check_html($sitesettings['notify_email'], "nohtml");
$notify_subject = stripslashes(check_html($sitesettings['notify_subject'], "nohtml"));
$notify_message = stripslashes(check_html($sitesettings['notify_message'], "nohtml"));
$notify_from = check_html($sitesettings['notify_from'], "nohtml");
$moderate = intval($sitesettings['moderate']);
$admingraphic = intval($sitesettings['admingraphic']);
$httpref = intval($sitesettings['httpref']);
$httprefmax = intval($sitesettings['httprefmax']);
$CensorMode = intval($sitesettings['CensorMode']);
$CensorReplace = check_html($sitesettings['CensorReplace'], "nohtml");
$copyright = check_html($sitesettings['copyright'], "");
$Version_Num = floatval($sitesettings['USV_Version']);
$USV_Version = $sitesettings['USV_Version'];
$support = stripslashes(check_html($sitesettings['support'], ""));
$domain = str_replace("http://", "", $nukeurl);
$nuke_editor = intval($sitesettings['nuke_editor']);
$CacheSystem = intval($sitesettings['cache_system']);
$lifetime = intval($sitesettings['cache_lifetime']);
$gfx_chk = (int) $sitesettings['gfx_chk'];
$use_question = $sitesettings['use_question'];
$codesize = (int) $sitesettings['codesize'];
$cache_system = (int) $sitesettings['cache_system'];
$clifetime = (int) $sitesettings['cache_lifetime'];
$nuke_editor = (int) $sitesettings['nuke_editor'];
$sec_pass = check_html($sitesettings['sec_pass'], "nohtml");
$trackip = $sitesettings['tracking'];
$site_switch = (int)$sitesettings['disable_switch'];
$disable_reason = check_html($sitesettings['disable_reason'], "nohtml");
$disable_to_date = $sitesettings['disable_to_date'];
$disable_from_date  = $sitesettings['disable_from_date'];
//===========================================
// OTHER CONSTANTS
//===========================================
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$get_memory =  (function_exists('memory_get_usage')) ? memory_get_usage() : 0;
$start_time = $mtime;
$pagetitle = "";

if (isset($_COOKIE['admin'])) $admin = $_COOKIE['admin'];
if (isset($_COOKIE['admin'])) $user = $_COOKIE['user'];


//===========================================
// Language 
//===========================================
global $multilingual, $language, $db;
// if an user ask us for a language to be his own default lang: 
if (($multilingual == 1) and isset($newlang) and !stristr($newlang, ".")) {
	$newlang = strip_tags($newlang);
	if (file_exists(CORE_INCLUSION . "language/lang-" . $newlang . ".php")) {
		setcookie("lang", '', time() - 31536000, '' . USV_DOMAIN . '');
		setcookie("lang", $newlang, time() + 31536000, '' . USV_DOMAIN . '');
		$currentlang = $newlang;
	} else {
		setcookie("lang", '', time() - 31536000);
		setcookie("lang", $language, time() + 31536000, '' . USV_DOMAIN . '');
		$currentlang = $language;
	}
	//redirect
	header("location: " . base64_decode($_GET['page']) . "");
	exit();
}
//If cookie is empty then set one plz :
if (empty($_COOKIE['lang'])) {
	setcookie("lang", $language, time() + 31536000, '' . USV_DOMAIN . '');
	$currentlang = $language;
} else {
	$currentlang = $_COOKIE['lang'];
}

// Include main language file
include_once(CORE_INCLUSION . "language/lang-" . $currentlang . ".php");

// now what about custom language files : plz do d same for em :
if (file_exists(CORE_INCLUSION . "includes/custom_files/lang-" . $currentlang . ".php")) {
	include_once(CORE_INCLUSION . "includes/custom_files/lang-" . $currentlang . ".php");
}


//===========================================
// Guardian
//===========================================

// Site Switch Check
if ($site_switch == 1 and !stristr($_SERVER['PHP_SELF'], "" . $admin_file . ".php") and !is_admin($_COOKIE['admin']) and time() < strtotime($disable_to_date)) {

	$disable_from_dateDB = strtotime($disable_from_date);
	$disable_from_date =  array(
		date("Y", $disable_from_dateDB),
		date("d", $disable_from_dateDB),
		date("m", $disable_from_dateDB),
		date("g", $disable_from_dateDB),
		date("i", $disable_from_dateDB),
		date("s", $disable_from_dateDB)
	);
	$disable_from_date_full = $disable_from_date;

	$disable_to_dateDB = strtotime($disable_to_date);
	$disable_to_date =  array(
		date("Y", $disable_to_dateDB),
		date("d", $disable_to_dateDB),
		date("m", $disable_to_dateDB),
		date("g", $disable_to_dateDB),
		date("i", $disable_to_dateDB),
		date("s", $disable_to_dateDB)
	);
	$disable_to_date_full = $disable_to_date;

	$vars_close_in = array(
		"[start]",
		"[end]",
		"[sitename]",
		"[email]"
	);
	$vars_close_out = array(
		"$disable_from_date_full",
		"" . $disable_to_date . "",
		"$sitename",
		"$adminmail"
	);

	$content_2_close = '<!-- 

@MarlikCMS Portal 

@version : 1.1.5 BE

Copyright (C) 2009-2011 by Marlik Group

http://www.MarlikCMS.com

-->

';
	if (!preg_match('/<head>/i', $disable_reason)) {
		$content_2_close .= '<html>
<head>
<title> سایت موقتا بسته است &nbsp; </title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="robots" content="noindex, nofollow">
</head>
<body>';
	}
	$content_2_close .= '' . str_ireplace($vars_close_in, $vars_close_out, $disable_reason) . '
<br>
</body>
</html>
';
	die($content_2_close);
}
