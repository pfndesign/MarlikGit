<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	
if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}

global $admin_file;
$module_name = "Your_Account";
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) {
    die ("Access Denied");
}
get_lang("$module_name");  
//if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}
//

switch($op) {

    case "mod_users":
    case "addUser":
    case "addUserConf":
    case "approveUser":
    case "approveUserConf":
    case "activateUser":
    case "activateUserConf":
    case "autoSuspend":
    case "credits":
    case "CookieConfig":
    case "CookieConfigSave":
    case "deleteUser":
    case "deleteUserConf":
    case "denyUser":
    case "denyUserConf":
    case "detailsTemp":
    case "detailsUser":
    case "findTemp":
    case "findUser":
    case "listnormal":
    case "listpending":
    case "listresults":
    case "modifyTemp":
    case "modifyTempConf":
    case "modifyUser":
    case "modifyUserConf":
    case "promoteUser":
    case "promoteUserConf":
    case "removeUser":
    case "removeUserConf":
    case "resendMail":
    case "resendMailConf":
    case "restoreUser":
    case "restoreUserConf":
    case "searchUser":
    case "suspendUser":
    case "suspendUserConf":
    case "UsersConfig":
    case "UsersConfigSave":
    case "addField":
    case "saveaddField":
    case "delField":
    case "delFieldConf":
	case "tosMain": /* Edit TOS Starts*/
	case "tosEdit":
	case "tosNew":
	case "tosPreview":
	case "YAutoSuggest":
	case "Yregpanel":
	case "fl_quick_delete":
	case "save_field_change":
	case "YA_multi_task":

    include("modules/$module_name/admin/index.php");
    break;

}

?>