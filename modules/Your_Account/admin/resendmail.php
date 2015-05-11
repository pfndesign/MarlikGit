<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	


if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}



if (($radminsuper==1) OR ($radminuser==1)) {

    list($uname) = $db->sql_fetchrow($db->sql_query("SELECT username FROM ".$user_prefix."_users_temp WHERE user_id='$chng_uid'"));
    $pagetitle = ": "._USERADMIN." - "._RESENDMAIL;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN." - "._RESENDMAIL);
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='xop' value='$xop'>\n"; }
    echo "<input type='hidden' name='op' value='resendMailConf'>\n";
    echo "<input type='hidden' name='rsn_uid' value='$chng_uid'>\n";
    echo "<tr><td align=center>"._SURE2RESEND." <b>$uname<i>($chng_uid)</i></b>?</td></tr>\n";
    echo "<tr><td align=center><input type='submit' value='"._RESENDMAIL."'></td><tr>\n";
    echo "</form>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center'><input type='submit' value='"._CANCEL."'></td></tr>\n";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
    include("footer.php");

}

?>