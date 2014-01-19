<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* mTutorials Copyright (c) 2005 David Karn, All rights reserved        */
/* http://www.webdever.net/                                             */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { show_error("Access Denied"); }

if (!defined('ADMIN_FILE')) {show_error("Access Denied");}

$module_name = basename(substr(__FILE__, 0, -15));
include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");
switch($op) {
	case 'mSconfig':
	case 'mSsubmitconfig':
	case "mSearch":
	case "mSmodules":
	case "mSaddmod":
	case "mSdisablemod":
		include("modules/$module_name/admin/index.php");
		break;
}

?>