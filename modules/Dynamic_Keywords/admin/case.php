<?php
/************************************************/
/* Dynamic Keywords For PHP-Nuke 7.3 - 8.0		*/
/* Written by: Jonathan Estrella				*/
/* http://slaytanic.sf.net						*/
/* Copyright (c) 2006-2008 Jonathan Estrella	*/
/************************************************/

global $admin_file;
if (!stristr($_SERVER['PHP_SELF'], $admin_file.".php") && !stristr($_SERVER['SCRIPT_NAME'], $admin_file.".php")) { die ("Access Denied"); }

switch($op) {
	case "MetaConfig":
	case "ModuleMetaEdit":
	case "ModuleMetaSave":
	case "MainMetaEdit":
	include("modules/Dynamic_Keywords/admin/index.php");
	break;
}
?>