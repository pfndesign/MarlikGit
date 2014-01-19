<?php
if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	header("Location: ../../../index.php");
	die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

include_once("header.php");


global $db,$prefix,$adminmail,$notify_from,$notify_email,$sitename,$nukeurl,$ya_config;

	$user_regdate = date("M d, Y");
	$datekey = date("F j");
	$new_password = md5($user_password);
	$ya_username = ya_fixtext($ya_username);
	$ya_user_email = strtolower($ya_user_email);
	$realname = ya_fixtext($ya_realname);
	$femail = ya_fixtext($femail);
	$user_website = check_html($user_website);
	if (!preg_match("#http://#", $user_website) AND $user_website != "") { $user_website = "http://$user_website"; }
	$bio = str_replace("<br>", "\r\n", $bio);
	$bio = ya_fixtext($bio);
	$user_sig = str_replace("<br>", "\r\n", $user_sig);
	$user_sig = ya_fixtext($user_sig);
	$user_icq = ya_fixtext($user_icq);
	$user_aim = ya_fixtext($user_aim);
	$user_yim = ya_fixtext($user_yim);
	$user_msnm = ya_fixtext($user_msnm);
	$user_occ = ya_fixtext($user_occ);
	$user_from = ya_fixtext($user_from);
	$user_interests = ya_fixtext($user_interests);
	$user_dateformat = ya_fixtext($user_dateformat);
	$newsletter = intval($newsletter);
	$user_viewemail = intval($user_viewemail);
	$user_allow_viewonline = intval($user_allow_viewonline);
	$user_timezone = intval($user_timezone);
	$htmlmail = 1 ;

	$lv = time();
	$result = $db->sql_query("INSERT INTO ".$prefix."_users (`name`, `username`, `user_email`, `user_avatar`, `user_regdate`, `user_viewemail`, `user_password`, `user_lang`, `user_lastvisit`) 
	VALUES ('".sql_quote($realname)."', '".sql_quote($ya_username)."', '".sql_quote($ya_user_email)."', 'gallery/blank.gif', '".sql_quote($user_regdate)."', '0', '".sql_quote($new_password)."', '".sql_quote($language)."', '".sql_quote($lv)."')") or die("<div class='error'>خطا در بانک اطلاعاتی <br>".mysql_error()."</div>");
	$db->sql_freeresult($result);
	if ((count($nfield) > 0) AND ($result)) {
		foreach ($nfield as $key => $var) {
			$result = $db->sql_query("INSERT INTO ".$prefix."_cnbya_value (uid, fid, value) VALUES ('".sql_quote($new_uid)."', '".sql_quote($key)."','$nfield[$key]')");
			$db->sql_freeresult($result);
		}
	}

	

		$result = $db->sql_query("SELECT * FROM ".$prefix."_users WHERE `username`='".$ya_username."' AND `user_password`='".sql_quote($new_password)."' LIMIT 1");
		$fin=0; // Fluffy redirect to personal info
		if ($db->sql_numrows($result) > 0 ) {
			$userinfo = $db->sql_fetchrow($result);
			yacookie($userinfo[user_id],$userinfo[username],$userinfo[user_password],$userinfo[storynum],$userinfo[umode],$userinfo[uorder],$userinfo[thold],$userinfo[noscore],$userinfo[ublockon],$userinfo[theme],$userinfo[commentmax]);
			echo "<center><b>$userinfo[username]:</b> "._ACTMSG2."</center>";
			$fin=1; // Fluffy redirect to personal info
		} else {
			title(_USERREGLOGIN);
			OpenTable();
			echo "<div class='error'>"._SOMETHINGWRONG."</div>";
			CloseTable();
			die();
		}
		$db->sql_freeresult($result);
		
				
	define("MAIL_CLASS",1); // ENABLING EMAIL SYSTEM TO RUN EMAIL CLASS 
	if ($ya_config['servermail'] == 0) {
	///****************** SENDING USER A CONFIRMATION MESSAGE ******************
	$to_name="$ya_username";
	$to_address="$ya_user_email";
	$from_name= "$notify_from";
	$from_address= "$notify_email";
	$subject = "$sitename |  "._APPLICATIONSUB." : $ya_username ";
	$_message = "
	<p><b>" . _SUBJECT . ":</b> "._WELCOMETO." $sitename <a href=\"$nukeurl\">$nukeurl</a><br><b>"._APPLICATIONSUB."</b></p>
		<p><b>" . _UNICKNAME . ": </b><a href='$nukeurl/account-userinfo-$ya_username.html' target='_blank'>$ya_username</a></p>
        <p><b>" . _UREALNAME . ": </b>$ya_realname</p>
        <p><b>" . _YOUUSEDEMAIL . ":</b> $ya_user_email</p>
        <p><b>" . _UPASSWORD . ":</b> $user_password</p>
		<br>\n";

	HtmlMail($to_address,$to_name,$from_address,$from_name,$subject,$_message);
	}
	
	if ($ya_config['sendaddmail'] == 1 AND $ya_config['servermail'] == 0) {
			$_to_address="$notify_email";
			$_to_name="$notify_from";
			$_from_address= "$ya_user_email";
			$_from_name= "$ya_username";
			$_subject = "$sitename |  "._APPLICATIONSUB." : $ya_username ";
			$_message2 = "<p><b>" . _SUBJECT . ":</b> "._WELCOMETO." $sitename <a href=\"$nukeurl\">$nukeurl</a><br><b>"._APPLICATIONSUB."</b></p>
		<p><b>" . _UNICKNAME . ": </b><a href='$nukeurl/account-userinfo-$ya_username.html' target='_blank'>$ya_username</a></p>
        <p><b>" . _UREALNAME . ": </b>$ya_realname</p>
        <p><b>" . _YOUUSEDEMAIL . ":</b> $ya_user_email</p>
        <p><b>" . _YA_FROM . ":</b> ".getRealIpAddr()."</p>
		<br>\n";
		$_message2 = Mail_AddStyle($_message2);
		@mail($_to_address, $_subject, $_message2, "From: $_from_address\nContent-Type: text/html; charset=utf-8");
		}
		
		
	// Fluffy redirect to personal info
	if ($fin)
	{
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=modules.php?name=Your_Account&op=edituser">';    
	}
	// ---

include_once("footer.php");
?>