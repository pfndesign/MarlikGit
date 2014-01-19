<?php

/**
*
* @package News Multi Tasks 														
* @version $Id: multi_tasks.php beta0.5   12/24/2009  5:51 PM  Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}


//===========================================
// MULTI AWAITING ACTIVATING
//===========================================

function approveUser(){
	global $db,$prefix,$user_prefix,$radminsuper,$radminuser,$ya_config;
	$id = $_POST['selecionar'];
	$ids = implode(',',$id);
	if ($id = null) {
		show_error(HACKING_ATTEMPT);
	}
	if (($radminsuper==1) OR ($radminuser==1)) {

		require_once("includes/inc_messenger.php");
		$email_message=new email_message_class;
		$result = $db->sql_query("SELECT username, realname, user_email, user_password, user_regdate FROM ".$prefix."_users_temp WHERE user_id IN ($ids)");
		while (list($uname, $realname, $email, $upass, $ureg) = $db->sql_fetchrow($result)) {


			$db->sql_query("INSERT INTO ".$user_prefix."_users (user_id, name, username, user_email, user_regdate, user_password, user_level, user_active, user_avatar, user_avatar_type, user_from) VALUES (NULL, '$realname', '$uname', '$email', '$ureg','$upass', 1, 1, 'gallery/blank.gif', 3, '')");

			$res = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_value_temp WHERE uid IN ($ids)");
			if ($res) {
				while ($sqlvalue = $db->sql_fetchrow($res)) {
					$db->sql_query("INSERT INTO ".$user_prefix."_cnbya_value (uid, fid, value) VALUES (NULL,'$sqlvalue[fid]','$sqlvalue[value]')");
				}
			}
			$db->sql_freeresult($res);
		}
		$db->sql_freeresult($result);

		$result = $db->sql_query("DELETE FROM ".$user_prefix."_users_temp WHERE user_id IN ($ids)");
		$result = $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users_temp");
		$db->sql_freeresult($result);

		if ($ya_config['servermail'] == 0) {

			$time	 = time();
			$finishlink	 = "$nukeurl/modules.php?name=$module_name&op=activate&username=$username&check_num=$check_num";
			$message	 = "<p align=\"center\">"._WELCOMETO.": $sitename!</p><br>\r\n\r\n";
			$message	.= "<p align=\"center\">"._YOUUSEDEMAIL." ($email) <br>"._TOREGISTER.": $sitename.</p>\r\n\r\n";
			$message	.= "<p align=\"center\"><li>"._TOFINISHUSER."</li></p>\r\n\r\n<p align=\"center\"><a href=\"$finishlink\">$finishlink</a><br><br></p>";
			$subject	 = _ACTIVATIONSUB;
			$from	 = "From: $adminmail\r\n";
			$from	.= "Reply-To: $adminmail\r\n";
			$from	.= "Return-Path: $adminmail\r\n";
			$message = $email_message->AddStyle($message);
			@mail($email, $subject, $message, "From: $adminmail\nContent-Type: text/html; charset=utf-8");
		}

		$pagetitle = ": "._USERADMIN." - "._YA_ACTIVATED;
		include("header.php");
		amain();
		echo "<br>\n";
		OpenTable();
		echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
		echo "<tr><td align='center'><b>"._YA_ACTIVATED."</b></td></tr>\n";
		echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
		echo "</form>\n";
		echo "</table></center>\n";
		CloseTable();
		include("footer.php");

	}else {
		show_error(HACKING_ATTEMPT);
	}
}
function activateUser(){
	global $db,$prefix,$user_prefix,$radminsuper,$radminuser,$ya_config;
	$id = $_POST['selecionar'];
	$ids = implode(',',$id);
	if ($id = null) {
		show_error(HACKING_ATTEMPT);
	}

	if (($radminsuper==1) OR ($radminuser==1)) {

		require_once("includes/inc_messenger.php");
		$email_message=new email_message_class;

		$result = $db->sql_query("SELECT username, realname, user_email, user_password, user_regdate FROM ".$prefix."_users_temp WHERE user_id IN ($ids)");
		while (list($uname, $realname, $email, $upass, $ureg) = $db->sql_fetchrow($result)) {


			$db->sql_query("INSERT INTO ".$user_prefix."_users (user_id, name, username, user_email, user_regdate, user_password, user_level, user_active,user_from) VALUES (NULL, '$realname', '$uname', '$email', '$ureg', '$upass', 1, 1,'')");

			$res = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_value_temp WHERE uid IN ($ids)");
			if ($res) {
				while ($sqlvalue = $db->sql_fetchrow($res)) {
					$db->sql_query("INSERT INTO ".$user_prefix."_users (user_id, name, username, user_email, user_regdate, user_password, user_level, user_active, user_avatar, user_avatar_type, user_from) VALUES (NULL, '$realname', '$uname', '$email', '$ureg','$upass', 1, 1, 'gallery/blank.gif', 3, '')");
				}
			}
			$db->sql_freeresult($res);
		}
		$db->sql_freeresult($result);

		$result = $db->sql_query("DELETE FROM ".$user_prefix."_users_temp WHERE user_id IN ($ids)");
		$result = $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users_temp");
		$db->sql_freeresult($result);

		if ($ya_config['servermail'] == 0) {


			$time	 = time();
			$message	 = "<p align=\"center\">"._WELCOMETO.": $sitename!</p><br>\r\n\r\n";
			$message	.= "<p align=\"center\">"._YA_ACTIVATED." ($email) <br>"._TOREGISTER.": $sitename.</p>\r\n\r\n";
			$subject	 = _YA_ACTIVATED.": $sitename!";
			$from	 = "From: $adminmail\r\n";
			$from	.= "Reply-To: $adminmail\r\n";
			$from	.= "Return-Path: $adminmail\r\n";
			$message = $email_message->AddStyle($message);
			@mail($email, $subject, $message, "From: $adminmail\nContent-Type: text/html; charset=utf-8");
		}

		$pagetitle = ": "._USERADMIN." - "._YA_ACTIVATED;
		include("header.php");
		amain();
		echo "<br>\n";
		OpenTable();
		echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
		echo "<tr><td align='center'><b>"._YA_ACTIVATED."</b></td></tr>\n";
		echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
		echo "</form>\n";
		echo "</table></center>\n";
		CloseTable();
		include("footer.php");

	}else {
		show_error(HACKING_ATTEMPT);
	}
}
function denyUser(){
	global $db,$user_prefix,$log;
	$id = $_POST['selecionar'];
	$ids = implode(',',$id);
	if ($id = null) {
		show_error(HACKING_ATTEMPT);
	}
	$result = $db->sql_query("DELETE FROM ".$user_prefix."_users_temp WHERE user_id IN ($ids)") OR die(mysql_error());
	$result = $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value_temp WHERE uid IN ($ids)")OR die(mysql_error());
	$result = $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users_temp");
	$result = $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_cnbya_value_temp");
	$db->sql_freeresult($result);
	header("Location:  ".ADMIN_PHP."?op=listpending");
}
function resendMail(){
	global $db,$user_prefix,$log;
	$id = $_POST['selecionar'];
	$ids = implode(',',$id);
	if ($id = null) {
		show_error(HACKING_ATTEMPT);
	}


	require_once("includes/inc_messenger.php");
	$email_message=new email_message_class;
	if (($radminsuper==1) OR ($radminuser==1)) {

		$result = $db->sql_query("SELECT username, user_email, check_num FROM ".$user_prefix."_users_temp WHERE user_id IN ($ids)");
		while(list($username, $email, $check_num) = $db->sql_fetchrow($result)) {

			if ($ya_config['servermail'] == 0) {
				$time = time();
				$finishlink = "$nukeurl/modules.php?name=$module_name&op=activate&username=$username&check_num=$check_num";
				$message = "<p align=\"center\">"._WELCOMETO." $sitename!</p>\r\n\r\n";
				$message .= "<p align=\"center\">"._YOUUSEDEMAIL." ($email)<br>"._TOREGISTER.": $sitename.</p>\r\n\r\n";
				$message .= "<p align=\"center\">"._TOFINISHUSER."\r\n\r\n<a href=\"$finishlink\">$finishlink</a></p>";
				$subject = _ACTIVATIONSUB;
				$from  = "From: $adminmail\r\n";
				$from .= "Reply-To: $adminmail\r\n";
				$from .= "Return-Path: $adminmail\r\n";
				$message = $email_message->AddStyle($message);
				@mail($email, $subject, $message, "From: $adminmail\nContent-Type: text/html; charset=utf-8");
			}
		}
		$db->sql_freeresult($result);

		$result = $db->sql_query("UPDATE ".$user_prefix."_users_temp SET time='$time' WHERE user_id IN ($ids)");
		$db->sql_freeresult($result);


		$pagetitle = ": "._USERADMIN." - "._RESENTMAIL;
		include("header.php");
		amain();
		echo "<br>\n";
		OpenTable();
		echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
		echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
		if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
		if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
		if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
		echo "<tr><td align='center'><b>"._RESENTMAIL."</b></td></tr>\n";
		echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
		echo "</form>\n";
		echo "</table></center>\n";
		CloseTable();
		include("footer.php");

	}

}

switch ($act) {

	case approveUser:
		approveUser();
		break;

	case activateUser:
		activateUser();
		break;

	case denyUser:
		denyUser();
		break;

	case resendMail:
		resendMail();
		break;

}
?>