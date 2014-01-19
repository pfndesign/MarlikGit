<?php
/**
*
* @package Tracking System														
* @version $Id: 10:31 AM 3/11/2010 Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if ( !defined('ADMIN_FILE') ){die("Illegal File Access");}

global $admin_file,$admin;

if (is_superadmin($admin)) {
adminmenu("".$admin_file.".php?op=templates", _TEMP_ADMIN, "weblinks.png");
}

?>