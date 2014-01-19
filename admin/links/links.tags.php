<?php

/**
*
* @package tags System														
* @version $Id: 10:31 AM 3/11/2010 James $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

global $admin_file,$admin;
if(!isset($admin_file)) { $admin_file = 'admin'; }
if(!defined('ADMIN_FILE')) { die('Illegal Access Detected!!'); }
if (is_superadmin($admin)) {
    adminmenu($admin_file.'.php?op=Tags', _TAGS_SYSTEM , 'tags.png');
}

?>
