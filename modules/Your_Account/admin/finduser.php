<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ": "._USERADMIN." - "._FINDUSER;
    include("header.php");
    GraphicAdmin();
    title(""._USERADMIN." - "._FINDUSER);
    amain();
    echo "<br>\n";
    if (isset($xusername) AND $xusername != "") {
        $sql = "SELECT * FROM ".$user_prefix."_users WHERE username='$xusername'";
    } elseif (isset($xuser_id) AND $xuser_id != "") {
        $sql = "SELECT * FROM ".$user_prefix."_users WHERE user_id='$xuser_id'";
    } elseif (isset($xuser_email) AND $xuser_email != "") {
        $sql = "SELECT * FROM ".$user_prefix."_users WHERE user_email='$xuser_email'";
    }
    if($db->sql_numrows($db->sql_query($sql)) > 0) {
        $chnginfo = $db->sql_fetchrow($db->sql_query($sql));
        OpenTable();
        echo "<center><table border='0'>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._USERID.":</td><td><b>".$chnginfo['user_id']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._NICKNAME.":</td><td><b>".$chnginfo['username']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._NAME.":</td><td><b>".$chnginfo['name']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._URL.":</td><td><b><a href='".$chnginfo['user_website']."' target='_blank'>".$chnginfo['user_website']."</a></b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._EMAIL.":</td><td><b><a href='mailto:".$chnginfo['user_email']."'>".$chnginfo['user_email']."</a></b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._FAKEEMAIL.":</td><td><b>".$chnginfo['femail']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._ICQ.":</td><td><b>".$chnginfo['user_icq']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._AIM.":</td><td><b>".$chnginfo['user_aim']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._YIM.":</td><td><b>".$chnginfo['user_yim']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._MSNM.":</td><td><b>".$chnginfo['user_msnm']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._LOCATION.":</td><td><b>".$chnginfo['user_from']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._OCCUPATION.":</td><td><b>".$chnginfo['user_occ']."</b></td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2'>"._INTERESTS.":</td><td><b>".$chnginfo['user_interests']."</b></td></tr>\n";
        if ($chnginfo['user_viewemail'] ==1) { $cuv = _YES; } else { $cuv = _NO; }
        echo "<tr><td bgcolor='$bgcolor2'> "._SHOWMAIL.":</td><td><b>$cuv</b></td></tr>\n";
        if ($chnginfo['newsletter'] == 1) { $cnl = _YES; } else { $cnl = _NO; }
        echo "<tr><td bgcolor='$bgcolor2'>"._NEWSLETTER.":</td><td><b>$cnl</b></td></tr>\n";
        $chnginfo[user_sig] = str_replace("\r\n", "<br>", $chnginfo[user_sig]);
        echo "<tr><td bgcolor='$bgcolor2' valign='top'>"._SIGNATURE.":</td><td><b>".$chnginfo['user_sig']."</b></td></tr>\n";
        echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
        echo "<input type='hidden' name='op' value='modifyUser'>\n";
        echo "<input type='hidden' name='chng_uid' value='".$chnginfo['user_id']."'>\n";
        echo "<tr><td align='center' colspan='2'><input type='submit' value='"._MODIFY."'></td></tr>\n";
        echo "</form>\n";
        echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
        echo "<tr><td align='center' colspan='2'><input type='submit' value='"._RETURN."'></td></tr>\n";
        echo "</form>\n";
        echo "</table></center>\n";
        CloseTable();
    } else {
        OpenTable();
        echo "<center><b>"._USERNOEXIST."</b></center>\n";
        CloseTable();
    }
    include("footer.php");

}

?>