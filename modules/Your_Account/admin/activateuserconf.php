<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

list($uname, $realname, $email, $upass, $ureg) = $db->sql_fetchrow($db->sql_query("SELECT username, realname, user_email, user_password, user_regdate FROM ".$user_prefix."_users_temp WHERE user_id='$act_uid'"));

    if ($ya_config['servermail'] == 0) {
        $message = "<p align=\"center\">"._SORRYTO.": $sitename "._HASAPPROVE."</p>";
        $subject = _SORRYTO." $sitename "._HASAPPROVE;
        $from  = "From: $adminmail\r\n";
        $from .= "Reply-To: $adminmail\r\n";
	    $message = FarsiMail($message);
        mail($email, $subject, $message, "From: \"$yname\" <$ymail>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nContent-transfer-encoding: 8bit");
    }
    $db->sql_query("DELETE FROM ".$user_prefix."_users_temp WHERE user_id='$act_uid'");

    $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users_temp");
    list($newest_uid) = $db->sql_fetchrow($db->sql_query("SELECT max(user_id) AS newest_uid FROM ".$user_prefix."_users"));
    if ($newest_uid == "-1") { $new_uid = 1; } else { $new_uid = $newest_uid+1; }
	$db->sql_query("INSERT INTO ".$user_prefix."_users (user_id, name, username, user_email, user_regdate, user_password, user_level, user_active, user_avatar, user_avatar_type, user_from) VALUES ('$new_uid', '$realname', '$uname', '$email', '$ureg', '$upass', 1, 1, 'gallery/blank.gif', 3, '')");

	$res = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_value_temp WHERE uid = '$act_uid'");
	while ($sqlvalue = $db->sql_fetchrow($res)) {
		$db->sql_query("INSERT INTO ".$user_prefix."_cnbya_value (uid, fid, value) VALUES ('$new_uid', '$sqlvalue[fid]','$sqlvalue[value]')");
	}
    $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value_temp WHERE uid='$act_uid'");
    $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_cnbya_value_temp");

    $pagetitle = ": "._USERADMIN." - "._YA_ACTIVATED;
    include("header.php");
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center'><b>"._YA_ACTIVATED."</b></td></tr>\n";
    echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
    include("footer.php");

}

?>