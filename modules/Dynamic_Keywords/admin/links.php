<?php
/************************************************/
/* Written by: Jonathan Estrella				*/
/* http://slaytanic.sf.net						*/
/* Copyright (c) 2006-2008 Jonathan Estrella	*/
/************************************************/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}


global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) { die ("Access Denied"); }
adminmenu("".$admin_file.".php?op=MetaConfig", ""._DK."", "keywords.png");
?>