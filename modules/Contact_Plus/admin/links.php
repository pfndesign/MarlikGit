<?php
global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) { die ("Access Denied"); }
adminmenu("".$admin_file.".php?op=contact#Default", ""._NSContactPlus."", "contactplus.png");
?>