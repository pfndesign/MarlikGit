<?php
/********************************************************/
/* Site Admin Backup & Optimize Module for PHP-Nuke     */
/* Version 1.0.0         10-24-04                       */
/* By: Telli (telli@codezwiz.com)                       */
/* http://codezwiz.com/                                 */
/* Copyright � 2000-2004 by Codezwiz                    */
/* Adjusted fot Iran Nuke Portal / http://irannuke.com	*/
/* http://saqur.com - A. Zakeri / 12-01-2006			*/
/********************************************************/
function czd_get_lang($module) {
    global $currentlang, $language,$admin;
    if ($module == 'admin') {
		if (file_exists("language/CZDatabase/lang-$currentlang.php")) {
			include_once("language/CZDatabase/lang-$currentlang.php");
		} else {
			include_once("language/CZDatabase/lang-english.php");
		}
    }
}
czd_get_lang('admin');

if (is_superadmin($admin)) {
    adminmenu("".ADMIN_OP."database", ""._ADDON."", "backup.png");
}

?>