<?php
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) { die ("Access Denied"); }
adminmenu("".$admin_file.".php?op=BannersAdmin", ""._BANNERS."", "banners.png");

?>