<?php

/**
*
* @package	MarlikCMS Tigris														
* @version $Id:  modules.php RC-7 4:09 PM 1/16/2010 $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com		
* @copyright (c) http://phpnuke.org - 2002, (c) Francisco Burzi									
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('MODULE_FILE', true);
require_once("mainfile.php");
global $db;
$name = mysqli_real_escape_string($db->db_connection,$_REQUEST['name']);

//===========================================
//Extra Mods
//===========================================
switch($app) {
	case 'mod':
    echo show_mod($name);
	die();
		
}
//===========================================
//MODULES'MAINTANECE
//===========================================
if (!empty($name)) {
  $name = addslashes(trim($name));
  $modstring = strtolower($_SERVER['QUERY_STRING']);
  if (stripos_clone($name, "..") OR ((stripos_clone($modstring,"&file=nickpage") || stripos_clone($modstring,"&user=")))) header("Location: index.php");
  global $db,$prefix,$user;

  $result = $db->sql_query("SELECT custom_title,active, view FROM ".$prefix."_modules WHERE title='".addslashes($name)."'");
  list($custom_title,$mod_active,$view) = $db->sql_fetchrow($result);
  $mod_active = intval($mod_active);
  $view = intval($view);
  if (($mod_active == 1) OR ($mod_active == 0 AND isset($admin) AND is_admin($admin))) {
    if (!isset($mop) OR $mop != $_REQUEST['mop']) $mop="modload";
    if (!isset($file) OR $file != $_REQUEST['file']) $file="index";
    if (stripos_clone($file,"..") OR stripos_clone($mop,"..")) die("You are so cool...");
    $ThemeSel = get_theme();
    if (file_exists("themes/$ThemeSel/modules/$name/".$file.".php")) {
      $modpath = "themes/$ThemeSel/";
    } else {
      $modpath = "";
    }
    if ($view == 0) {
      $modpath .= "modules/$name/".$file.".php";
      if (file_exists($modpath)) {
        include($modpath);
      } else {
      	show_error(_FILE_NOT_EXISTS);
      }
    } elseif ($view == 1 AND (is_user($user) OR is_group($user, $name)) OR is_admin($admin)) {
      $modpath .= "modules/$name/".$file.".php";
      if (file_exists($modpath)) {
        include($modpath);
      }else {
      	show_error(_FILE_NOT_EXISTS);
      }
    } elseif ($view == 1 AND !is_user($user) AND !is_admin($admin)) {
      $pagetitle = "- ".$custom_title;
      include("header.php");
      title($sitename.": "._ACCESSDENIED);
      OpenTable();
      echo "<center><strong>"._RESTRICTEDAREA."</strong><br><br>"._MODULEUSERS;
      $result2 = $db->sql_query("SELECT mod_group FROM ".$prefix."_modules WHERE title='".addslashes($name)."'");
      list($mod_group) = $db->sql_fetchrow($result2);
      if ($mod_group != 0) {
        $result3 = $db->sql_query("SELECT name FROM ".$prefix."_groups WHERE id='".intval($mod_group)."'");
        $row3 = $db->sql_fetchrow($result3);
        echo _ADDITIONALYGRP.": <b>".$row3['name']."</b><br><br>";
      }
      echo _GOBACK;
      CloseTable();
      include("footer.php");
    } elseif ($view == 2 AND is_admin($admin)) {
      $modpath .= "modules/$name/".$file.".php";
      if (file_exists($modpath)) {
        include($modpath);
      } else {
      	show_error(_FILE_NOT_EXISTS);
      }
    } elseif ($view == 2 AND !is_admin($admin)) {
      $pagetitle = "- ".$custom_title;
      include("header.php");
      title($sitename.": "._ACCESSDENIED);
      OpenTable();
      echo "<center><b>"._RESTRICTEDAREA."</b><br><br>"._MODULESADMINS.""._GOBACK;
      CloseTable();
      include("footer.php");
    } elseif ($view == 3 AND paid()) {
      $modpath .= "modules/$name/".$file.".php";
      if (file_exists($modpath)) {
        include($modpath);
      } else {
      	show_error(_FILE_NOT_EXISTS);
      }
    } else {
      $pagetitle = "- ".$custom_title."";
      include("header.php");
      title($sitename.": "._ACCESSDENIED."");
      OpenTable();
      echo "<center><strong>"._RESTRICTEDAREA."</strong><br><br>"._MODULESSUBSCRIBER;
      if (!empty($subscription_url)) echo "<br>"._SUBHERE;
      echo "<br><br>"._GOBACK;
      CloseTable();
      include("footer.php");
    }
  } else {
    include("header.php");
    OpenTable();
    echo "<center>"._MODULENOTACTIVE."<br><br>"._GOBACK."</center>";
    CloseTable();
    include("footer.php");
  }
}
else {
  header("Location: index.php");
  exit;
}
?>