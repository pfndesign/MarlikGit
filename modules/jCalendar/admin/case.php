<?php
global $admin_file;
if(!defined('ADMIN_FILE')) {
    Header("Location: ../../".$admin_file.".php");
    die();
}
$module_name = "jCalendar";
get_lang($module_name);

switch ($op) {

    case "jCalendar":
    include("modules/$module_name/admin/index.php");
    break;

}
?>