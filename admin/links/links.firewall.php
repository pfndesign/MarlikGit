<?php
if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}
global $admin_file;
if ($radminsuper==1) {
    adminmenu("".$admin_file.".php?op=firewall", ""._FIREWALL."", "firewall.png");
}

?>