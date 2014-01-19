<?php
/**
*
* @package HEADER														
* @version $Id: header.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (stristr(htmlentities($_SERVER['PHP_SELF']), "header.php")) {
	show_error(HACKING_ATTEMPT."<br><b>header.php</b>");
}

define('NUKE_HEADER', true);
require_once("mainfile.php");
// mybb_bridge
if(file_exists('includes/inc_mybb.php')){
include_once('includes/inc_mybb.php');
}
//===================================================
//GOOGLE TAP FEATURE
//===================================================
if (!defined("ADMIN_FILE")) {nextGenTap(1,0,0); }

function head() {
global $db,
$ab_config,
$slogan,
$sitename,
$banners,
$nukeurl,
$Version_Num,
$artpage, $topic,
$hlpfile,
$user,
$userinfo,
$hr,
$theme,
$cookie,
$adminpage,
$userpage,
$pagetitle,
$loading,
$nukeNAV,
$currentlang,
$name;

if (!defined("ADMIN_FILE") AND !defined('FORUM_ADMIN')) {
	// load main theme file theme.php
	if (file_exists(THEME_FILE)) {include_once(THEME_FILE);}
	// lets start our theme engine.!
	require_once(THEME_ENGINE);
}


	// Initialize CSS and JS arrays
	$headCSS = array();
	$headJS  = array();  // added inside HEAD tags
	$bodyJS  = array(); // added at bottom of page, before </BODY>
	$baseUrl = rtrim((string)dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';

if (function_exists("custom_head")) {
	custom_head();
}else{
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php echo "\n";?>
<!-- 
@Nukelearn Portal 
@version : 1.1.5 BE
Copyright (C) 2009-2011 by Nukelearn Group
http://www.nukelearn.com
-->
<?php
echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n";
echo "<head>\n";
echo "<base href=\"http://". $_SERVER['HTTP_HOST'].$baseUrl."\" />\n";

//===========================================
//TITLE STRINGS
//===========================================
if($name == "phpBB3") {
	$smart_title= "";
}
/*elseif (preg_match("/News/",$_SERVER['REQUEST_URI']) AND preg_match("/article/",$_SERVER['REQUEST_URI'])) {
$smart_title= "<title>$pagetitle &nbsp;</title>\n" ;
}
*/else {
$smart_title= "<title>$pagetitle @ $sitename</title>\n" ;
}
echo $smart_title;
//===========================================
//META STRINGS
//===========================================
include("includes/meta.php");
if (file_exists("themes/" . _DEAULT_THEME_ . "/images/favicon.ico")) {
	echo "<link REL=\"shortcut icon\" HREF=\"themes/" . _DEAULT_THEME_ . "/images/favicon.ico\" TYPE=\"image/x-icon\" />\n";
}else {
	echo "<link REL=\"shortcut icon\" HREF=\"favicon.ico\" TYPE=\"image/x-icon\" />\n";
}
//===================================================
//RSS syndication
//===================================================

echo "<link rel='alternate' type='application/rss+xml' title='"._RSS_LASTCOMMENTS."' href='rss.php?mod=Comment' />\n";
echo "<link rel='alternate' type='application/rss+xml' title='"._RSS_NEWS."' href='rss.php?mod=News' />\n";

//===================================================
//CSS
//===================================================
 
if (!defined("ADMIN_FILE")) {
	
	if ($currentlang == "persian") {
	$def_style = 'themes/' . _DEAULT_THEME_ . '/style/style.css';
	}
	else
	{
	$def_style = 'themes/' . _DEAULT_THEME_ . '/style/style-ltr.css';
		if (!file_exists($def_style)) {
			$def_style = 'themes/' . _DEAULT_THEME_ . '/style/style.css';
		}
	}
		
	if (file_exists($def_style)) {addCSSToHead($def_style,'file');}
	
	$engine_style = 'themes/' . _DEAULT_THEME_ . '/style/engine.css';
	if (file_exists($engine_style)) {
		addCSSToHead($engine_style,'file');
	}else {
		addCSSToHead(INCLUDES_ACP.'style/css/engine.css','file');
	}
}

//& Define MODULE_CSS where u want to add a css file to header , just name it .
//& e.g. : define ("MODULE_CSS","gallery.css");
if (defined('MODULE_CSS')) {
	$modCssFile = 'themes/' . _DEAULT_THEME_ . '/style/' . MODULE_CSS;
	if (file_exists($modCssFile)) {
		addCSSToHead($modCssFile, 'file');
	}
}

if (function_exists("admin_head")) {
	admin_head();
}

if (file_exists("includes/custom_files/custom_head.php")) {
	include_once("includes/custom_files/custom_head.php");
}

//===================================================
//JS
//===================================================

include(INCLUDES_PATH."javascript.php");
writeHEAD();
echo "\n\n\n</head>\n<body>\n";
writeBODYJS();

if (file_exists("includes/custom_files/custom_header.php")) {
	include_once("includes/custom_files/custom_header.php");
}
//===================================================
//SENTINEL
//===================================================
if($ab_config['site_switch'] == 1 && is_admin($_COOKIE['admin'])) {

	if (time() > strtotime($ab_config['disable_to_date'])) {
		echo '<div id="StaticDiv">
		<a href="'.ADMIN_OP.'Configure"><img src="images/Guardian/inactive.png" alt="'._SITE_CLOSED.'" title="'._SITE_CLOSED.'">
		<b>'._SITE_CLOSE_TIME_EXPIRED.'</b></a>
		</div>';
	}else {
		echo '<div id="StaticDiv">
		<a href="'.ADMIN_OP.'Configure"><img src="images/Guardian/inactive.png" alt="'._SITE_CLOSED.'" title="'._SITE_CLOSED.'" border="0">
		<b>'._SITE_CLOSED.'</b></a>
		</div>';
		}
	}
}
		if (!defined("ADMIN_FILE")) {
			themeheader();
		}else {
			adminheader(); // Where we sat Admin panel  apart from other sections
		}
			
}


//===================================================
//WESITE HEAD BEGINS
//===================================================
$start = benchGetTime();
head();
$end = benchGetTime();
if (BENCHMARK==true) {
	echo benchmark_overall($start,$end,'HEADER');
}

//===================================================
//center blocks
//===================================================

if(defined('HOME_FILE')) {
	message_box();
	blocks("Center");
}

?>