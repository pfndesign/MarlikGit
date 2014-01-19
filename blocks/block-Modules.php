<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2005 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $prefix, $db, $admin, $language, $currentlang;

$content = "";

// Get theme
$ThemeSel = get_theme();
if (file_exists("themes/$ThemeSel/module.php")) {
	include("themes/".$ThemeSel."/module.php");
	if (is_active($default_module) AND file_exists("modules/$default_module/index.php")) {
		$def_module = $default_module;
	} else {
		$def_module = "";
	}
}

// Get main module
$sql = "SELECT main_module FROM ".$prefix."_main";
$query = $db->sql_query($sql);
list($main_module) = $db->sql_fetchrow($query);

/* Now we make the Modules block with the correspondent links */
$content .= "<strong><big>&middot;</big></strong> <a href=\"index.php\">"._HOME."</a><br>";
$sql = "SELECT title, custom_title, view FROM ".$prefix."_modules WHERE active='1' AND inmenu='1' ORDER BY custom_title ASC";
$result = $db->sql_query($sql);

while (list($title, $custom_title, $view) = $db->sql_fetchrow($result)) {
	$m_title = $title;
	$m_view = $view;
	if(file_exists("modules/$m_title/index.php")) {
		if (!empty($custom_title) && $custom_title != $m_title && $language === $currentlang) {
			$m_title2 = $custom_title;
		} else {
			if (!empty($custom_title)) {
				$m_title2 = (defined("_".$m_title."LANG"))? (constant("_".$m_title."LANG")) : $custom_title;
			} else {
				$m_title2 = (defined("_".$m_title."LANG"))? (constant("_".$m_title."LANG")) : ($m_title2 = str_replace("_", " ", $m_title));
			}
		}
		if ($m_title != $main_module) {
			if (file_exists("modules/$m_title/index.php") && ($m_view == 2 OR $m_view != 2)) {
				$content .= "<strong><big>&middot;</big></strong> <a href=\"modules.php?name=".$m_title."\">$m_title2</a><br>";
			}
		}
	}
}

/* If you're Admin you and only you can see Inactive modules and test it */
/* If you copied a new module is the /modules/ directory, it will be added to the database */
if (is_admin($admin)) {
	$content .= "<br><center><strong>"._INVISIBLEMODULES."</strong><br>";
	$content .= "<span class=\"tiny\">"._ACTIVEBUTNOTSEE."</span></center><br>";
	$sql = "SELECT title, custom_title FROM ".$prefix."_modules WHERE active='1' AND inmenu='0' ORDER BY title ASC";
	$result = $db->sql_query($sql);
	$dummy = 1;
	while (list($title, $custom_title) = $db->sql_fetchrow($result)) {
		$mn_title = $title;
		$mn_title2 = str_replace("_", " ", $mn_title);
		if (!empty($custom_title)) {
			$mn_title2 = $custom_title;
		}
		if (!empty($mn_title2) && file_exists("modules/$mn_title/index.php")) {
			$content .= "<strong><big>&middot;</big></strong> <a href=\"modules.php?name=".$mn_title."\">$mn_title2</a><br>";
			$dummy = 0;
		}
	}
	if ($dummy) {
		$content .= "<strong><big>&middot;</big></strong> <i>"._NONE."</i><br>";
	}
	$content .= "<br><center><strong>"._NOACTIVEMODULES."</strong><br>";
	$content .= "<span class=\"tiny\">"._FORADMINTESTS."</span></center><br>";
	$sql = "SELECT title, custom_title FROM ".$prefix."_modules WHERE active='0' ORDER BY title ASC";
	$result = $db->sql_query($sql);
	$dummy = 1;
	while (list($title, $custom_title) = $db->sql_fetchrow($result)) {
		$mn_title = $title;
		$mn_title2 = str_replace("_", " ", $mn_title);
		if (!empty($custom_title)) {
			$mn_title2 = $custom_title;
		}
		if (!empty($mn_title2) && file_exists("modules/$mn_title/index.php")) {
			$content .= "<strong><big>&middot;</big></strong> <a href=\"modules.php?name=".$mn_title."\">$mn_title2</a><br>";
			$dummy = 0;
		}
	}
	if ($dummy) {
		$content .= "<strong><big>&middot;</big></strong> <i>"._NONE."</i><br>";
	}
}

?>