<?php
/**
*
* @package Tracking System														
* @version $Id: 10:31 AM 3/11/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if ( !defined('ADMIN_FILE') ){die("Illegal File Access");}


switch($op) {
    case "templates":
    case "theme_edit":
    case "save_file_edit":
    case "themes_set_def":
    case "remove_file":
    case "themes_set_def":
    case "read_online_temps":
    case "themes_view_online":
    case "themes_download":
   	
    require_once("admin/modules/templates.php");
    break;

    
}

?>