<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) {
    die ("Access Denied");
}
$module_name = "Your_Account";

adminmenu("".$admin_file.".php?op=mod_users", ""._EDITUSERS."", "users.png"); 

?>