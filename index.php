<?php
/**
*
* @package INDEX														
* @version $Id: index.php RC-7 4:09 PM 1/16/2010 $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once("mainfile.php");


global $prefix,$ThemeSel,$db,$user,$admin_file;

//===========================================
//Advertisment
//===========================================
if (isset($op) AND ($op == "ad_click") AND isset($bid)) {
	$bid = intval(sql_quote($bid));
	$sql = "SELECT clickurl FROM ".$prefix."_banner WHERE bid='$bid'";
	$result = $db->sql_query($sql);
	list($clickurl) = $db->sql_fetchrow($result);
	$clickurl = check_html($clickurl, "nohtml");
	$db->sql_query("UPDATE ".$prefix."_banner SET clicks=clicks+1 WHERE bid='$bid'");
	if (is_user($user)) {
		update_points(21);
	}
	$db->sql_freeresult($result);
	Header("Location: ".addslashes($clickurl));
	die();
}


$modpath = '';
define('MODULE_FILE', true);
$_SERVER['PHP_SELF'] = "modules.php";
list($name)= $db->sql_fetchrow($db->sql_query("SELECT main_module from ".$prefix."_main"));
define('HOME_FILE', true);

if (isset($url) AND is_admin($admin)) {
	$url = sql_quote($url);
	echo "<meta http-equiv=\"refresh\" content=\"0; url=$url\">";
	die();
}

if (!isset($mop)) { $mop="modload"; }
if (!isset($mod_file)) { $mod_file="index"; }
$name = sql_quote(trim($name));
if (isset($file)) { $file = sql_quote(trim($file)); }
$mod_file = sql_quote(trim($mod_file));
$mop = sql_quote(trim($mop));
if (stripos_clone($name,"..") || (isset($file) && stripos_clone($file,"..")) || stripos_clone($mod_file,"..") || stripos_clone($mop,"..")) {
	die("You are so cool...");
} else {
	if (file_exists("themes/$ThemeSel/module.php")) {
		include("themes/$ThemeSel/module.php");
		if (is_active("$default_module") AND file_exists("modules/$default_module/".$mod_file.".php")) {
			$name = $default_module;
		}
	}
	if (file_exists("themes/$ThemeSel/modules/$name/".$mod_file.".php")) {
		$modpath = "themes/$ThemeSel/";
	}
	$modpath .= "modules/$name/".$mod_file.".php";
	if (file_exists($modpath)) {
		include($modpath);
	} else {
		define('INDEX_FILE', true);
		include("header.php");
		OpenTable();
		if (is_admin($admin)) {
			echo "<center><font class=\"\"><b>"._HOMEPROBLEM."</b></font><br><br>[ <a href=\"".$admin_file.".php?op=modules\">"._ADDAHOME."</a> ]</center>";
		} else {
			echo "<center>"._HOMEPROBLEMUSER."</center>";
		}
		CloseTable();
		include("footer.php");
	}
}

?>