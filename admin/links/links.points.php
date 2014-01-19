<?php
/***************************************************/
/*	Accounting System for phpNuke(INP)	   */
/*             Designed by Hamed Momeni		   */
/***************************************************/

global $admin_file,$admin;
if(!isset($admin_file)) { $admin_file = 'admin'; }
if(!defined('ADMIN_FILE')) { die('Illegal Access Detected!!'); }
if (is_superadmin($admin)) {
    adminmenu($admin_file.'.php?op=Points', _POINTS_MAN , 'points.png');
}

?>
