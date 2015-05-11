<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	


if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { show_error("Access Denied"); }

if (!defined('ADMIN_FILE')) {show_error("Access Denied");}

define('YA_ADMIN', true);
define('CNBYA', true);

global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) {
    die ("Access Denied");
}
$module_name = "Your_Account"; 
include_once("modules/$module_name/includes/functions.php"); 
require_once("modules/$module_name/includes/constants.php");
$ya_config	 = ya_get_configs();
$cnbyaversion = $ya_config['version'];
global $prefix,$admin, $db; 
if(is_admin($admin)) { 
    if(!is_array($admin)) { 
        $adm = base64_decode($admin); 
        $adm = explode(":", $adm); 
        $aname = "$adm[0]"; 
    } else { 
        $aname = "$admin[0]"; 
    } 
	list($radminsuper) = $db->sql_fetchrow($db->sql_query("select radminsuper from ".$prefix."_authors where aid='$aname'")); 
	$radminuser = 0; 
	if ($Version_Num >= 7.5)  {
		$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='Your_Account'")); 
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aname'")); 
		$admins = explode(",", $row['admins']); 
		for ($i=0; $i < sizeof($admins); $i++) { 
			if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") { 
				$radminuser = 1; 
			} 
		} 
	} else {
		list($radminuser) = $db->sql_fetchrow($db->sql_query("select radminuser from ".$prefix."_authors where aid='$aname'")); 
	}
} 
global $prefix, $db,$admin, $admin_file;
$module_name = basename(dirname(dirname(__FILE__)));
$aid = substr("$aid", 0,25);
if (is_admin_of($module_name,$admin)) {
	$radminuser = 1;
}

if ($radminsuper == 1 || $radminuser == 1) { 

    switch($op) { 

    case "mod_users":
        include("header.php");
		GraphicAdmin();
        include("modules/$module_name/admin/Showroom.php");
        include("footer.php");

    break;

    case "YAutoSuggest":
        include("modules/$module_name/admin/autosuggestion.php");
    break;

    case "Yregpanel":
        include("modules/$module_name/admin/registrationpanel.php");
    break;
    case "save_field_change":
        include_once("modules/$module_name/admin/functions.php");
        save_field_change();
    break;
    case "fl_quick_delete":
        include_once("modules/$module_name/admin/functions.php");
        fl_quick_delete();
    break;

    
    case "addUser":
        include("modules/$module_name/admin/adduser.php");
    break;

    case "addUserConf":
        include("modules/$module_name/admin/adduserconf.php");
    break;

    case "approveUser":
        include("modules/$module_name/admin/approveuser.php");
    break;

    case "approveUserConf":
        include("modules/$module_name/admin/approveuserconf.php");
    break;

    case "activateUser":
        include("modules/$module_name/admin/activateuser.php");
    break;

    case "activateUserConf":
        include("modules/$module_name/admin/activateuserconf.php");
    break;

    case "autoSuspend":
        include("modules/$module_name/admin/autosuspend.php");
    break;

    case "credits":
        include("modules/$module_name/admin/credits.php");
    break;

    case "CookieConfig":
        include("modules/$module_name/admin/menucookies.php");
    break;
	
    case "CookieConfigSave":
        include("modules/$module_name/admin/menucookiessave.php");
    break;
	
    case "deleteUser":
        include("modules/$module_name/admin/deleteuser.php");
    break;

    case "deleteUserConf":
        include("modules/$module_name/admin/deleteuserconf.php");
    break;

    case "denyUser":
        include("modules/$module_name/admin/denyuser.php");
    break;

    case "denyUserConf":
        include("modules/$module_name/admin/denyuserconf.php");
    break;

    case "detailsTemp":
        include("modules/$module_name/admin/detailstemp.php");
    break;

    case "detailsUser":
        include("modules/$module_name/admin/detailsuser.php");
    break;

    case "findTemp":
        include("modules/$module_name/admin/findtemp.php");
    break;

    case "findUser":
        include("modules/$module_name/admin/finduser.php");
    break;

    case "listnormal":
        include("modules/$module_name/admin/listnormal.php");
    break;

    case "listpending":
        include("modules/$module_name/admin/listpending.php");
    break;

    case "listresults":
        include("modules/$module_name/admin/listresults.php");
    break;

    case "modifyTemp":
        include("modules/$module_name/admin/modifytemp.php");
    break;

    case "modifyTempConf":
        include("modules/$module_name/admin/modifytempconf.php");
    break;

    case "modifyUser":
        include("modules/$module_name/admin/modifyuser.php");
    break;

    case "modifyUserConf":
        include("modules/$module_name/admin/modifyuserconf.php");
    break;

    case "promoteUser":
        include("modules/$module_name/admin/promoteuser.php");
    break;

    case "promoteUserConf":
        include("modules/$module_name/admin/promoteuserconf.php");
    break;

    case "removeUser":
        include("modules/$module_name/admin/removeuser.php");
    break;

    case "removeUserConf":
        include("modules/$module_name/admin/removeuserconf.php");
    break;

    case "resendMail":
        include("modules/$module_name/admin/resendmail.php");
    break;

    case "resendMailConf":
        include("modules/$module_name/admin/resendmailconf.php");
    break;

    case "restoreUser":
        include("modules/$module_name/admin/restoreuser.php");
    break;

    case "restoreUserConf":
        include("modules/$module_name/admin/restoreuserconf.php");
    break;

    case "searchUser":
        include("modules/$module_name/admin/searchuser.php");
    break;

    case "suspendUser":
        include("modules/$module_name/admin/suspenduser.php");
    break;

    case "suspendUserConf":
        include("modules/$module_name/admin/suspenduserconf.php");
    break;

    case "UsersConfig":
        include("modules/$module_name/admin/userconfig.php");
    break;

    case "UsersConfigSave":
        include("modules/$module_name/admin/userconfigsave.php");
    break;
    
    case "addField":
        include("modules/$module_name/admin/addfield.php");
    break;
    
    case "saveaddField":
        include("modules/$module_name/admin/saveaddfield.php");
    break;
    
    case "delField":
        include("modules/$module_name/admin/delfield.php");
    break;
	
    case "delFieldConf":
        include("modules/$module_name/admin/delfieldconf.php");
    break;
	
	case "tosMain": /* Edit TOS Starts*/
	include("modules/$module_name/admin/tosmain.php");
	break;
	
	case "tosEdit":
	include("modules/$module_name/admin/tosedit.php");
	break;
	
	case "tosNew":
	include("modules/$module_name/admin/tosnew.php");
	break;
	
	case "tosPreview":
		include("modules/$module_name/admin/tospreview.php");
		break; /*Edit TOS Ends*/

	case "YA_multi_task":
	include("modules/$module_name/admin/multi_tasks.php");
		break;
    } 

} else { 
    echo "Access Denied"; 
} 

?>