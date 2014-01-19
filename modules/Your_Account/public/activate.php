<?php

/*********************************************************************************/
/* CNB Your Account: An Advanced User Management System for phpnuke     		*/
/* ============================================                         		*/
/*                                                                      		*/
/* Copyright (c) 2004 by Comunidade PHP Nuke Brasil                     		*/
/* http://dev.phpnuke.org.br & http://www.phpnuke.org.br                		*/
/*                                                                      		*/
/* Contact author: escudero@phpnuke.org.br                              		*/
/* International Support Forum: http://ravenphpscripts.com/forum76.html 		*/
/*                                                                      		*/
/* This program is free software. You can redistribute it and/or modify 		*/
/* it under the terms of the GNU General Public License as published by 		*/
/* the Free Software Foundation; either version 2 of the License.       		*/
/*                                                                      		*/
/*********************************************************************************/
/* CNB Your Account is the official successor of NSN Your Account by Bob Marion	*/
/*********************************************************************************/


if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

    if ($ya_config['expiring']!=0) {
        $past = time()-$ya_config['expiring'];
		$res = $db->sql_query("SELECT user_id FROM ".$user_prefix."_users_temp WHERE time < '$past'");
		while (list($uid) = $db->sql_fetchrow($res)) {
                  $uid = intval($uid);
		  $db->sql_query("DELETE FROM ".$user_prefix."_users_temp WHERE user_id = $uid");
		  $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value_temp WHERE uid = '$uid'");
		}
		
		$db->sql_query("OPTIMIZE TABLE ".$user_prefix."_cnbya_value_temp");
		$db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users_temp");
    
/**************************************************************************************************/
/* Mod Name     : Your_Account Mod to Send PM On User Register                                    */
/* Author       : Raven http://ravenphpscripts.com -- http://ravenwebhosting.com                  */
/* Version      : 1.0.0                                                                           */
/* Release Date : July 6, 2005                                                                    */
/* License      : GNU/GPL - Use it, modify it, but please respect the Credits                     */
/* Usage Notes  : Be sure that you have added the language text to the language file and that you */
/*                have modified it for your site.                                                 */
/**************************************************************************************************/
/* Other Credits:                                                                                 */
/*   -- Inspired by and Adapted from John B. Abela's © Forum Send PM On User Register Mod ©       */
/*      http://www.phpbb2mods.com                                                                 */
/*                                                                                                */
/*   -- Contributed by Chatserv 2005                                                              */
/*      Assign a group_id to new users to get rid of user and group permission errors in forums.  */
/*      http://www.nukefixes.com -- http://www.nukeresources.com                                  */
/**************************************************************************************************/
/*
		// BEGIN -- The following code is courtesy of Chatserv 2005 -- //
		$pmResult = $db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$row[username]'");
		$pmRow = $db->sql_fetchrow($pmResult);
		$guserid = intval($pmRow[user_id]);
		$db->sql_query("INSERT INTO ".$prefix."_bbgroups (group_name, group_description, group_single_user, group_moderator) VALUES ('', 'Personal User', '1', '0')");
		$group_id = $db->sql_nextid();
		$db->sql_query("INSERT INTO ".$prefix."_bbuser_group (user_id, group_id, user_pending) VALUES ('$guserid', '$group_id', '0')");
		// END -- The above code is courtesy of Chatserv 2005 -- //

		$pmResult = $db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='"._PRIVMSGS_FROM_USERNAME."'");
		$pmRow = $db->sql_fetchrow($pmResult);
		$privmsgs_from_userid = intval($pmRow[user_id]);

		$register_pm_subject  = _REGISTER_PM_SUBJECT;
		$register_pm          = _REGISTER_PM;
		$privmsgs_date        = date("U");

		$sql = "UPDATE ".$user_prefix."_users SET user_new_privmsg='1', user_last_privmsg='65534', user_unread_privmsg='1', user_popup_pm='1', user_notify='1', user_notify_pm='1' WHERE user_id='$guserid'";
		if (!$db->sql_query($sql)) {
			echo sprintf(_MYSQL_ERROR,'USERS').mysql_error();
			CloseTable();
			include('footer.php');
		}
		$sql = "INSERT INTO ".$user_prefix."_bb3privmsgs (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) VALUES ('0', '" . str_replace("\'", "''", addslashes(sprintf($register_pm_subject,$sitename))) . "', '$privmsgs_from_userid', '$guserid', '$privmsgs_date', '0', '1', '1', '0')";
		if (!$db->sql_query($sql)) {
			echo sprintf(_MYSQL_ERROR,'_BB3PRIVMSGS').mysql_error();
			CloseTable();
			include('footer.php');
		}
		$privmsgs_text = $register_pm_subject;
		$privmsg_sent_id = $db->sql_nextid();
		$sql = "INSERT INTO ".$user_prefix."_bbprivmsgs_text (privmsgs_text_id, privmsgs_text) VALUES ($privmsg_sent_id, '" . str_replace("\'", "''", addslashes(sprintf($register_pm,$username,$sitename,$sitename))) . "')";
		if (!$db->sql_query($sql)) {
			echo sprintf(_MYSQL_ERROR,'_BBPRIVMSGS_TEXT').mysql_error();
			CloseTable();
			include('footer.php');
		}
*/
/**************************************************************************************************/
/**************************************************************************************************/

    
    }
    $username  = trim(check_html($username, 'nohtml'));
    $check_num = trim(check_html($check_num, 'nohtml'));
    $result    = $db->sql_query("SELECT * FROM ".$user_prefix."_users_temp WHERE username='$username' AND check_num='$check_num'");
    if ($db->sql_numrows($result) == 1) {
        $row = $db->sql_fetchrow($result);
        $lv = time();
        include("header.php");
        title(_PERSONALINFO);
        OpenTable();
        echo "<table class='forumline' cellpadding=\"3\" cellspacing=\"3\" border=\"0\" width='100%'>\n";
        echo "<tr><td align=\"center\" bgcolor='$bgcolor2' colspan=\"2\"><b>"._FORACTIVATION."</b>:</td></tr>\n";
        echo "<form name=\"Register\" action=\"modules.php?name=$module_name\" method=\"post\">\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._USRNICKNAME.":</td><td bgcolor='$bgcolor1'>$row[username]</td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._UREALNAME.":<br>"._REQUIRED."</td><td bgcolor='$bgcolor1'>";
        echo "<input type=\"text\" name=\"realname\" value=\"$row[realname]\" size=\"50\" maxlength=\"60\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(realname)></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._UREALEMAIL.":</td>";
        echo "<td bgcolor='$bgcolor1'>$row[user_email]</td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._UFAKEMAIL.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" dir='ltr' name=\"femail\" value=\"\" size=\"50\" maxlength=\"255\"><br>"._EMAILPUBLIC."</td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YOURHOMEPAGE.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\"  dir='ltr' name=\"user_website\" value=\"\" size=\"50\" maxlength=\"255\"></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YICQ.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_icq\"  dir='ltr' value=\"\" size=\"30\" maxlength=\"100\"></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YAIM.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_aim\"  dir='ltr' value=\"\" size=\"30\" maxlength=\"100\"></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YYIM.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_yim\" value=\"\"  dir='ltr' size=\"30\" maxlength=\"100\"></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YMSNM.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_msnm\" value=\"\"  dir='ltr' size=\"30\" maxlength=\"100\"></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YLOCATION.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_from\" value=\"\" size=\"30\" maxlength=\"100\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(user_from)></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YOCCUPATION.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_occ\" value=\"\" size=\"30\" maxlength=\"100\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(user_occ)></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YINTERESTS.":<br>"._OPTIONAL."</td>";
        echo "<td bgcolor='$bgcolor1'><input type=\"text\" name=\"user_interests\" value=\"\" size=\"30\" maxlength=\"100\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(user_interests)></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._RECEIVENEWSLETTER.":</td><td bgcolor='$bgcolor1'><select name='newsletter'>";
        echo "<option value=\"1\">"._YES."</option><option value=\"0\" selected>"._NO."</option></select></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._ALWAYSSHOWEMAIL.":</td><td bgcolor='$bgcolor1'><select name='user_viewemail'>";
        echo "<option value=\"1\">"._YES."</option><option value=\"0\" selected>"._NO."</option></select></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._HIDEONLINE.":</td><td bgcolor='$bgcolor1'><select name='user_allow_viewonline'>";
        echo "<option value=\"0\">"._YES."</option><option value=\"1\" selected>"._NO."</option></select></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._FORUMSTIME."</td><td bgcolor='$bgcolor1'><select name='user_timezone'>";
        $utz = date("Z");
        $utz = round($utz/3600);
        for ($i=-12; $i<13; $i++) {
            if ($i == 0) {
                $dummy = "GMT";
            } else {
                if (!ereg("-", $i)) { $i = "+$i"; }
                $dummy = "GMT $i "._HOURS."";
            }
            if ($utz == $i) {
                echo "<option name=\"user_timezone\" value=\"$i\" selected>$dummy</option>";
            } else {
                echo "<option name=\"user_timezone\" value=\"$i\">$dummy</option>";
            }
        }
        echo "</select></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._FORUMSDATE.":<br>"._FORUMSDATEMSG."</td><td bgcolor='$bgcolor1'>";
        echo "<input type=\"text\" name=\"user_dateformat\" value=\"Y-m-d, H:i:s\" size='15' maxlength='14'></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._SIGNATURE.":<br>"._OPTIONAL."<br>"._NOHTML."</td>";
        echo "<td bgcolor='$bgcolor1'><textarea wrap=\"virtual\" cols=\"50\" rows=\"5\" name=\"user_sig\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);>$userinfo[user_sig]</textarea><br><IMG src=\"images/fa.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(user_sig)><br>"._255CHARMAX."</td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._EXTRAINFO.":<br>"._OPTIONAL."<br>"._NOHTML."</td>";
        echo "<td bgcolor='$bgcolor1'><textarea wrap=\"virtual\" cols=\"50\" rows=\"5\" name=\"bio\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);>$userinfo[bio]</textarea><br><IMG src=\"images/fa.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(bio)><br>"._CANKNOWABOUT."</td></tr>\n";
        echo "<input type=\"hidden\" name=\"ya_username\" value=\"$row[username]\">";
        echo "<input type=\"hidden\" name=\"check_num\" value=\"$check_num\">\n";
        echo "<input type=\"hidden\" name=\"ya_time\" value=\"$row[time]\">\n";
        echo "<input type=\"hidden\" name=\"op\" value=\"saveactivate\">";
        echo "<tr><td bgcolor='$bgcolor1' colspan='2' align='center'><input type=\"submit\" value=\""._SAVECHANGES."\"></td></tr>\n";
        echo "</form>\n";
        echo "</table>\n";
        CloseTable();
        include("footer.php");
        die();
    } else {
        include("header.php");
        title(""._ACTIVATIONERROR."");
        OpenTable();
        echo "<center>"._ACTERROR."</center>";
        CloseTable();
        include("footer.php");
        die();
    }

?>