<?php
/**
*
* @package Admin INDEX														
* @version  admin.php $Id: beta6 $ 2:12 AM 12/25/2009	$Aneeshtan					
* @copyright (c)Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


define('ADMIN_FILE', true);
require_once("mainfile.php");

//===========================================
//Check if Admin Page Has A Second Password
//===========================================
global $sec_pass;
if (!empty($sec_pass))
{
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
//if (!isset($_SERVER['PHP_AUTH_USER']) || md5($_SERVER['PHP_AUTH_USER'])!==$name || md5($_SERVER['PHP_AUTH_PW'])!==$pass)
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW']<>$sec_pass)
{
header('www-Authenticate: Basic realm=');
header('HTTP/1.0 401 Unauthorized<br><br>OH WOW , Hacking Attempt or What ?!');
}
}
//===========================================
//Check if the site is installed
//===========================================
if (!file_exists("config.php")) {
if (file_exists("install.php")) {
header("Location: install.php");
} else {
show_error("<div id='bd'  class=\"error\"><p class=\"error\"><img src='images/icon/exclamation.png' title='Attention' alt='Attention'><b>Attention:</b> The configuration file is missing and a new installation cannot be started because the install file cannot be located</p><div>");
}
} else if (file_exists("install/install.php")) {
show_error("<table style='padding: 2px; border: 1px solid #999; background-color: #EEE; font-family: Verdana; font-size: 10px;' align='center'><tr><td><b>Attention:</b> Delete the installation folder and files!</td></tr></table>");
}

//===========================================
//Security Checks
//===========================================
//global $nukeurl;
//if (!stripos_clone($_SERVER['HTTP_HOST'], $nukeurl)) {
//  die("Access denied");
//}


		if (isset ($aid))
		{
		 if (!empty ($aid) AND (!isset ($admin) OR empty ($admin)) AND $op != 'login')
		 {
		  unset ($aid);
		  unset ($admin);
		  die("Access Denied");
		 }
		}
		
$checkurl = $_SERVER['REQUEST_URI'];
if((stripos_clone($checkurl,'AddAuthor')) OR (stripos_clone($checkurl,'VXBkYXRlQXV0aG9y')) OR (stripos_clone($checkurl,'QWRkQXV0aG9y')) OR (stripos_clone($checkurl,'UpdateAuthor')) OR (stripos_clone($checkurl, "?admin")) OR (stripos_clone($checkurl, "&admin"))) {
die("Illegal Operation");
}
		
get_lang("admin");

//===========================================
//Includes
//===========================================

require_once (INCLUDES_ACP . 'acp_dashboard.php');
require_once (INCLUDES_ACP . 'old_nuke.php');

//===========================================
//Case Structure
//===========================================
if ($admintest)
		{
		 switch ($op)
		 {
		  case "about_us" :
		   about_us();
		   break;
		  case "nukelearn_RSS" :
		   nukelearn_RSS();
		   break;
		  case "deleteNotice" :
		   deleteNotice($id);
		   break;
		  case "GraphicAdmin" :
		   GraphicAdmin();
		   break;
		  case "GraphicAdminM" :
		   GraphicAdminM();
		   break;
		  case "adminMain" :
		   adminMain();
		   break;
		  case "ADMIN_PANE" :
		   ADMIN_PANE();
		   break;
		  case "ADMIN_USER_SETTING" :
		   ADMIN_USER_SETTING();
		   break;
		  case "GraphicModules" :
		   GraphicModules();
		   break;
		  case "ADMIN_INFO" :
		   ADMIN_INFO();
		   break;
		  case "ADMIN_PANE_FAQ" :
		   ADMIN_PANE_FAQ();
		   break;
		  case "logout" :
		   logout();
		   break;
		  case "login";
		  unset ($op);
		  default :
		   if (!is_admin($admin))
		   {
		    login();
		   }
		   $casedir = dir("admin/case");
		   while ($func = $casedir->read())
		   {
		    if (substr($func, 0, 5) == "case.")
		    {
		     include ($casedir->path . "/" . $func);
		    }
		   }
		   closedir($casedir->handle);
		   $result = $db->sql_query("SELECT title FROM " . $prefix .
		                           "_modules ORDER BY title ASC");
		   while (list($mod_title) = $db->sql_fetchrow($result))
		   {
		    if (file_exists("modules/$mod_title/admin/index.php") AND file_exists(
		       "modules/$mod_title/admin/links.php") AND file_exists(
		       "modules/$mod_title/admin/case.php"))
		    {
		     include ("modules/$mod_title/admin/case.php");
		    }
		   }
		   break;
		 }
		}
		else
		{
		 switch ($op)
		 {
		  default :
		   	if (!is_admin($admin))
		   {
		    login();
		   }
		   break;
		 }
		}
?>