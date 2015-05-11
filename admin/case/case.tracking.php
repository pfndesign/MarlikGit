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
    case "PagesViewed":
    case "tracking":
    case "ban_this_ip":
    case "suspend_this_user":
    case "save_suspended":
    case "save_banned":
    case "IPTrack":
    case "ipban_delete":
    case "unsuspend_user":
    case "moreinfo":
    case "trigger_status":
    case "delete_history":
   	
    require_once("admin/modules/tracking.php");
    break;

    
}

?>