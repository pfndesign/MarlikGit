<?php

/**
 *
 * @package userinfo														
 * @version $Id: 02009-12-12 15:35:19Z Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com	
 *  Iran Nuke Portal                        (info@irannuke.net) 										
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike	
 *
 */
if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

$module_name = basename(dirname(__FILE__));

require_once("mainfile.php");
require_once(INCLUDES_UCP."constants.php");
include_once(INCLUDES_UCP."functions.php");
if (!isset($ya_config)) $ya_config = ya_get_configs();
$ya_config = ya_get_configs();
get_lang($module_name);
$userpage = 1;
define('INDEX_FILE', true);
include("modules/$module_name/navbar.php");
include(INCLUDES_UCP."cookiecheck.php");
cookiedecode($user);

if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
global $pagetitle;
$pagetitle = _Viewing_profile_;//====== PAGE TITLE =====================

addCSSToHead(INCLUDES_UCP."style/ucp.css",'file');// Main CSS file 
define("blocks_show",true);// Hide Side Blocks
function salt_password($password, $salt)
{
	return md5(md5($salt).$password);
}

switch($op) {

	default:
		mmain($user);
	break;

	case "updatelivebroadcasting":
		live_broadcasting();
	break;

	case "memberlist":
		include("modules/$module_name/public/memberlist.php");
	break;

	case "activate":
		include("modules/$module_name/public/activate.php");
	break;
	
	case "broadcast":
		if ($broadcast_msg == 1) {
			include("modules/$module_name/public/broadcast.php");
		} else {
			disabled();
		}
		break;
	case "live_broadcast":
		if ($broadcast_msg == 1) {
			include("modules/$module_name/public/live_broadcast.php");
		} else {
			disabled();
		}
	break;

	case "delete":
		if ($ya_config['allowuserdelete'] == 1) {
			include("modules/$module_name/public/delete.php");
		} else {
			disabled();
		}
	break;

	case "deleteconfirm":
		if ($ya_config['allowuserdelete'] == 1) {
			include("modules/$module_name/public/deleteconfirm.php");
		} else {
			disabled();
		}
	break;

	case "editcomm":
		include("modules/$module_name/public/editcomm.php");
		break;

	case "edithome":
		include("modules/$module_name/public/edithome.php");
	break;

	case "edittheme":
	break;

	case "changemail":
		include("modules/$module_name/public/changemail.php");
		changemail();
	break;


	case "chgtheme":
		if ($ya_config['allowusertheme']==0) {
			include("modules/$module_name/public/chngtheme.php");
		} else {
			disabled();
		}
		break;

	case "edituser":
		include("modules/$module_name/public/edituser.php");
	break;


	case "login":

		if (extension_loaded("gd") AND ($gfx_chk == 2 OR $gfx_chk == 5 OR $gfx_chk == 7) and !check_captcha()) {
			$wrong_code = true;
			mmain(null);
			exit;
		}

		$login_username = sql_quote($_REQUEST['username']);
		$login_password = $_REQUEST['user_password'];
		
		if (isset ($login_username)) {
			$login_username = substr($login_username, 0, 25);
		}
		if (isset($login_password)) {
			$login_password = substr($login_password, 0, 40);
		}

		
		
		if (empty($login_username) AND empty($login_password)) {
			Header("Location: modules.php?name=$module_name&stop=1");
			break;
		}
		$result  = $db->sql_query("SELECT * FROM ".__USER_TABLE." WHERE LOWER(username)='".strtolower($login_username)."'limit 1");
		$setinfo = $db->sql_fetchrow($result);

		if (($ya_config['tos'] == intval(1)) AND ($_POST['tos_yes'] == intval(1))) {
			$db->sql_query("UPDATE ".__USER_TABLE." SET agreedtos='1' WHERE LOWER(username)='".strtolower($login_username)."'");
		}

		$forward = $_REQUEST['redirect'];
		//if (preg_match("/privmsg/", $forward)) { $pm_login = "active"; }


		if (empty($setinfo[0])) {
			Header("Location: modules.php?name=$module_name&stop=2");
			exit;
		} 
		elseif ($setinfo['user_id'] > 1  AND !empty($setinfo['user_password']) AND $setinfo['user_active'] >0 AND $setinfo['user_level'] >0) {

						

			$dbpass	= $setinfo['user_password'];		
	
			$non_crypt_pass = $login_password;
			$non_crypt_dbpass = $dbpass;

			$old_crypt_pass = crypt ( $login_password, substr ( $dbpass, 0, 2 ) );
			$new_pass = md5 ( $login_password );
			if (($dbpass == $non_crypt_pass) or ($dbpass == $old_crypt_pass)) {
				$db->sql_query ( "UPDATE " . $user_prefix . "_users SET user_password='$new_pass'	WHERE username='$username'" );
				$result = $db->sql_query ( "SELECT user_password FROM " . $user_prefix . "_users	WHERE username='$username'" );
				unset($dbpass);
				list ( $dbpass ) = $db->sql_fetchrow ( $result );
				$db->sql_freeresult ( $result );
			}
						
				$login_password = md5(trim($login_password));
				if ($login_password != $dbpass) {
					$result = $db->sql_query("SELECT U.username,MU.username,MU.salt,MU.loginkey FROM ".__USER_TABLE." AS U LEFT JOIN mybb_users AS MU ON MU.username=U.username  WHERE LOWER(U.username)='".strtolower($login_username)."'limit 1");
					$salt = $db->sql_fetchrow($result);
						 $db->sql_freeresult($result);
							$mybb_login_password = salt_password($login_password, $salt[2]);						
								if ($mybb_login_password != $dbpass) {
									$login_password = md5($login_password);
										if ($login_password != $dbpass) {
											Header("Location: modules.php?name=$module_name&stop=3");exit;
										}								
								}
						}

			
			// menelaos: show a member the current TOS if he has not agreed yet
			if (($ya_config['tos'] == intval(1)) AND ($ya_config['tosall'] == intval(1)) AND ($setinfo[agreedtos] != intval(1))) {
				if($_POST['tos_yes'] != intval(1)) {
					include("modules/$module_name/public/ya_tos.php");
					exit;
				}
			}

			yacookie($setinfo['user_id'], $setinfo['username'], $setinfo['user_password'] , $setinfo['storynum'], $setinfo['umode'], $setinfo['uorder'], $setinfo['thold'], $setinfo['noscore'], $setinfo['ublockon'], $setinfo['theme'], $setinfo['commentmax']);
			

			if (!empty($forward)) {
				echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL=$forward\">";exit;
			}else {
				echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL=modules.php?name=Your_Account&op=userinfo&username=".$setinfo['username']."\">";exit;
			}

		} elseif (!empty($setinfo) AND ($setinfo['user_level'] < 1 OR $setinfo['user_active'] < 1)) {
			include("header.php");
			Show_CNBYA_menu();
			OpenTable();
			if ($setinfo['user_level'] == 0) {
				echo "<br><center><font class=\"title\"><b>"._ACCSUSPENDED."</b></font></center><br>\n";
			} elseif ($setinfo['user_level'] == -1) {
				echo "<br><center><font class=\"title\"><b>"._ACCDELETED."</b></font></center><br>\n";
			} else {
				echo "<br><center><font class=\"title\"><b>"._SORRYNOUSERINFO."</b></font></center><br>\n";
			}
			CloseTable();
			$db->sql_freeresult($result);
			include("footer.php");
		} else {
			$db->sql_freeresult($result);
			Header("Location: modules.php?name=$module_name&stop=5");exit;
		}
		break;
		//Add karma System
	case "change_karma":
		change_karma($user_id, $karma);
		break;
		//End Karma System
	case "logout":
		cookiedecode($user);
		$r_uid = $cookie[0];
		$r_username = $cookie[1];
		//correct the problem of path change
		if (trim($ya_config[cookiepath]) != '') setcookie("user","expired",time()-604800,"$ya_config[cookiepath]");
		global $NK_session;
		$NK_session->mr_kill_user($r_uid);
		include("header.php");
		if ($redirect != "") {
			echo "<META HTTP-EQUIV=\"refresh\" content=\"2;URL=modules.php?name=$redirect\">";
		} else {
			echo "<META HTTP-EQUIV=\"refresh\" content=\"2;URL=index.php\">";
		}
		title(_YOUARELOGGEDOUT);
		include("footer.php");
		break;

	case "mailpasswd":
		include("modules/$module_name/public/mailpass.php");
		break;

	case "my_headlines":
		include("modules/$module_name/public/headlines.php");
		break;

	case "new_user":
		if (is_user($user)) {
			mmain($user);
		} else {
			if ($ya_config['allowuserreg']==0) {
				if ($ya_config['coppa'] == intval(1)) {
					if($_POST['coppa_yes']!= intval(1)) {
						include("modules/$module_name/public/ya_coppa.php");
						exit;
					}
				}
				if ($ya_config['tos'] == intval(1)) {
					if($_POST['tos_yes'] != intval(1)) {
						include("modules/$module_name/public/ya_tos.php");
						exit;
					}
				}
				if ($ya_config['coppa'] !== intval(1) OR $ya_config['coppa'] == intval(1) AND $_POST['coppa_yes'] = intval(1)){
					if ($ya_config['tos'] !== intval(1) OR $ya_config['tos'] == intval(1) AND $_POST['tos_yes']=intval(1)){
						if ($ya_config['requireadmin'] == 1) {
							include("modules/$module_name/public/new_user1.php");
						} elseif ($ya_config['requireadmin'] == 0 AND $ya_config['useactivate'] == 0) {
							include("modules/$module_name/public/new_user2.php");
						} elseif ($ya_config['requireadmin'] == 0 AND $ya_config['useactivate'] == 1) {
							include("modules/$module_name/public/new_user3.php");
						}
					}
				}
			}else {
				disabled();
			}
		}
		break;

	case "new_confirm":
		if (is_user($user)) {
			mmain($user);
		} else {
			if ($ya_config['allowuserreg']==0) {
				if ($ya_config['requireadmin'] == 1) {
					include("modules/$module_name/public/new_confirm1.php");
				} elseif ($ya_config['requireadmin'] == 0 AND $ya_config['useactivate'] == 0) {
					include("modules/$module_name/public/new_confirm2.php");
				} elseif ($ya_config['requireadmin'] == 0 AND $ya_config['useactivate'] == 1) {
					include("modules/$module_name/public/new_confirm3.php");
				}
			} else {
				disabled();
			}
		}
		break;

	case "new_finish":
		if (is_user($user)) {
			mmain($user);
		} else {
			if ($ya_config['allowuserreg']==0) {
				if ($ya_config['requireadmin'] == 1) {
					include("modules/$module_name/public/new_finish1.php");
				} elseif ($ya_config['requireadmin'] == 0 AND $ya_config['useactivate'] == 0) {
					include("modules/$module_name/public/new_finish2.php");
				} elseif ($ya_config['requireadmin'] == 0 AND $ya_config['useactivate'] == 1) {
					include("modules/$module_name/public/new_finish3.php");
				}
			} else {
				disabled();
			}
		}
		break;

	case "pass_lost":
		include("modules/$module_name/public/passlost.php");
		break;

	case "saveactivate":
		include("modules/$module_name/public/saveactivate.php");
		break;

	case "savecomm":
		if (is_user($user)) {
			include("modules/$module_name/public/savecomm.php");
		} else {
			notuser();
		}
		break;

	case "savehome":
		if (is_user($user)) {
			include("modules/$module_name/public/savehome.php");
		} else {
			notuser();
		}
		break;

	case "savetheme":
		if (is_user($user)) {
			if ($ya_config['allowusertheme']==0) {
				include("modules/$module_name/public/savetheme.php");
			} else {
				disabled();
			}
		} else {
			notuser();
		}
		break;

	case "saveuser":
		if (is_user($user)) {
			include("modules/$module_name/public/saveuser.php");
		} else {
			notuser();
		}
		break;

	case "userinfo":
		include("modules/$module_name/public/userinfo.php");
		break;

	case "ShowCookiesRedirect":
		ShowCookiesRedirect();
		break;

	case "ShowCookies":
		ShowCookies();
		break;

	case "DeleteCookies":
		DeleteCookies();
		break;


	case "show_my_blog":
		include("modules/$module_name/public/broadcast.php");
		show_my_blog();
		break;

	case "blog_del":
		include("modules/$module_name/public/broadcast.php");
		blog_del($bid);
		break;

	case "blog_edit":
		include("modules/$module_name/public/broadcast.php");
		blog_edit();
		break;

	case "blog_post":
		include("modules/$module_name/public/broadcast.php");
		blog_post();
		break;

	case "blog_reply":
		include("modules/$module_name/public/broadcast.php");
		blog_reply();
		break;
	case "show_more_comments":
		include("modules/$module_name/public/broadcast.php");
		show_more_comments();
		break;

	case "YAB_Setting":
		include("modules/$module_name/public/broadcast.php");
		YAB_Setting();
		break;

	case "YBSaveSetting":
		include("modules/$module_name/public/broadcast.php");
		YBSaveSetting();
		break;

	case "YB_Password":
		include("modules/$module_name/public/broadcast.php");
		YB_Password();
		break;
	case "YB_Password_CHK":
		include("modules/$module_name/public/broadcast.php");
		YB_Password_CHK();
		break;
	case "flush_blog":
		include("modules/$module_name/public/broadcast.php");
		flush_blog();
		break;
	case "show_post":
		include("modules/$module_name/public/broadcast.php");
		show_post($bid);
		break;
	case "edit_my_post":
		include("modules/$module_name/public/broadcast.php");
		edit_my_post();
		break;

	case "share_it":
		include("modules/$module_name/public/broadcast.php");
		share_it($bid,$title);
		break;

	case "VoteBlog":
		include("modules/$module_name/public/votes.php");
		break;

	case "avatarCroping":
		include("modules/$module_name/public/avatarCroping.php");
		break;

	case "uploadThumbnail":
		include("modules/$module_name/public/avatarCroping.php");
		uploadThumbnail();
		break;

	case "deleteThumbnail":
		include("modules/$module_name/public/avatarCroping.php");
		deleteThumbnail();
		break;

	case "make_PDF":
		include("modules/$module_name/public/pdf.php");
		break;
}

?>