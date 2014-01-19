<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    list($email, $level) = $db->sql_fetchrow($db->sql_query("SELECT user_email, user_level FROM ".$user_prefix."_users WHERE user_id='$rem_uid'"));
    if ($level > -1 AND $ya_config['servermail'] == 0) {
        $message = _SORRYTO." $sitename "._HASREMOVE;
        $subject = _ACCTREMOVE;
        $from  = "From: $adminmail\r\n";
        $from .= "Reply-To: $adminmail\r\n";
        $from .= "Return-Path: $adminmail\r\n";
        mail($email, $subject, $message, $from);
    }
    $db->sql_query("DELETE FROM ".$user_prefix."_users WHERE user_id='$rem_uid'");
	
	$db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value WHERE uid='$rem_uid'");
    $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value_temp WHERE uid='$rem_uid'");
	$db->sql_query("OPTIMIZE TABLE ".$user_prefix."_cnbya_value");
	$db->sql_query("OPTIMIZE TABLE ".$user_prefix."_cnbya_value_temp");
	
    $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users");
    $pagetitle = ": "._USERADMIN." - "._ACCTREMOVE;
    include("header.php");
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center'><b>"._ACCTREMOVE."</b></td></tr>\n";
    echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
    include("footer.php");

}

?>