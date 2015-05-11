<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}



if (($radminsuper==1) OR ($radminuser==1)) {

    list($username, $email, $check_num) = $db->sql_fetchrow($db->sql_query("SELECT username, user_email, check_num FROM ".$user_prefix."_users_temp WHERE user_id='$apr_uid'"));
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
		$message = FarsiMail($message);
        mail($email, $subject, $message, "From: \"$adminmail\" <$adminmail>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nContent-transfer-encoding: 8bit");
    }
    $db->sql_query("UPDATE ".$user_prefix."_users_temp SET time='$time' WHERE user_id='$apr_uid'");
    $pagetitle = ": "._USERADMIN." - "._YA_APPROVED." . $username";
    include("header.php");
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center'><b>"._YA_APPROVED." $username ($email)</b></td></tr>\n";
    echo "<tr><td align='center'><b>"._YA_SENDMAIL."</b></td></tr>\n";
    echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
    include("footer.php");

}

?>