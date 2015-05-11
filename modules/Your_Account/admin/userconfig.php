<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}

    $pagetitle = ": "._USERSCONFIG;
    include("header.php");
    GraphicAdmin();
    title(_USERSCONFIG);
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='' method='post'>\n";
    echo "<tr><td align='center' colspan='2'><b>"._YA_REGOPTIONS."</b></td></tr>\n";
    echo "<tr><td align='right'>"._ACTALLOWREG."</td>\n<td>";
    if ($ya_config['allowuserreg']==0) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xallowuserreg' value='0'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xallowuserreg' value='1'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._REQUIREADMIN."</td>\n<td>";
    if ($ya_config['requireadmin']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xrequireadmin' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xrequireadmin' value='0'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._ACTALLOWDELETE."</td>\n<td>";
    if ($ya_config['allowuserdelete']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xallowuserdelete' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xallowuserdelete' value='0'$ck2>"._NO."</td></tr>\n";

    echo "<tr><td align='right'>"._DOUBLECHECKEMAIL."</td>\n<td>";
    if ($ya_config['doublecheckemail']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xdoublecheckemail' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xdoublecheckemail' value='0'$ck2>"._NO." &nbsp;("._DOUBLECHECKEMAILNOTE.")</td></tr>\n";

    echo "<tr><td align='right'>"._ACTIVATECOPPA."</td>\n<td>";
    if ($ya_config['coppa']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xcoppa' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xcoppa' value='0'$ck2>"._NO." &nbsp;("._ACTIVATECOPPANOTE.")</td></tr>\n";
    echo "<tr><td align='right'>"._ACTIVATETOS."</td>\n<td>";
    if ($ya_config['tos']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xtos' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xtos' value='0'$ck2>"._NO."  &nbsp;("._ACTIVATETOSNOTE.")</td></tr>\n";
    echo "<tr><td align='right'>"._ACTIVATETOSALL."</td>\n<td>";
    if ($ya_config['tosall']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xtosall' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xtosall' value='0'$ck2>"._NO." &nbsp;("._ACTIVATETOSALLNOTE.")</td></tr>\n";

    echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";

    echo "<tr><td align='center' colspan='2'><b>"._YA_MAILOPTIONS."</b></td></tr>\n";
    echo "<tr><td align='right'>"._SERVERMAIL."</td>\n<td>";
    if ($ya_config['servermail']==0) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xservermail' value='0'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xservermail' value='1'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._ACTNOTIFYADD."<br>"._YA_SERVERMAILNOTE."</td>\n<td>";
    if ($ya_config['sendaddmail']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xsendaddmail' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xsendaddmail' value='0'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._ACTNOTIFYDELETE."<br>"._YA_SERVERMAILNOTE."</td>\n<td>";
    if ($ya_config['senddeletemail']==0) { $ck1 = ""; $ck2 = " checked"; } else { $ck1 = " checked"; $ck2 = ""; }
    echo "<input type='radio' name='xsenddeletemail' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xsenddeletemail' value='0'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._USEACTIVATE."<br>"._YA_SERVERMAILNOTE."</td>\n<td>";
    if ($ya_config['useactivate']==0) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xuseactivate' value='0'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xuseactivate' value='1'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._ACTALLOWMAIL."</td>\n<td>";
    if ($ya_config['allowmailchange']==0) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xallowmailchange' value='0'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xallowmailchange' value='1'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='right'>"._EMAILVALIDATE."<br>"._YA_SERVERMAILNOTE."</td>\n<td>";
    if ($ya_config['emailvalidate']==1) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xemailvalidate' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xemailvalidate' value='0'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
    echo "<tr><td align='center' colspan='2'><b>"._YA_GRAPOPTIONS."</b></td></tr>\n";
    echo "<tr><td align='right'>"._ACTALLOWTHEME."</td>\n<td>";
    if ($ya_config['allowusertheme']==0) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xallowusertheme' value='0'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xallowusertheme' value='1'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
    echo "<tr><td align='center' colspan='2'><b>"._YA_EXPOPTIONS."</b></td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._AUTOSUSPEND."</td><td><select name='xautosuspend'>\n";
    echo "<option value='0'";
    if ($ya_config['autosuspend'] == 0) { echo " selected"; }
    echo ">0 "._YA_NONEXPIRE."</option>\n";
    $i = 1;
    while ($i <= 52) {
        $k = $i * 604800;
        echo "<option value='$k'";
        if ($ya_config['autosuspend'] == $k) { echo " selected"; }
        echo">$i ";
        if ($i == 1) { echo _YA_WEEK; } else { echo _YA_WEEKS; }
        echo "</option>\n";
        $i++;
    }
    echo "</select><br>("._AUTOSUSNOTE.")</td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._YA_EXPIRING."</td><td><select name='xexpiring'>\n";
    echo "<option value='0'";
    if ($ya_config['expiring'] == 0) { echo " selected"; }
    echo ">0 "._YA_NONEXPIRE."</option>\n";
    $i = 1;
    while ($i <= 30) {
        $k = $i * 86400;
        echo "<option value='$k'";
        if ($ya_config['expiring'] == $k) { echo " selected"; }
        echo">$i ";
        if ($i == 1) { echo _YA_DAY; } else { echo _YA_DAYS; }
        echo "</option>\n";
        $i++;
    }
    echo "</select><br>("._YA_EXPIRINGNOTE.")</td></tr>\n";
    echo "<tr><td align='right'>"._AUTOSUSPENDMAIN."<br>("._YA_AUTOSUSPENDMAINNOTE.")</td>\n<td>";
    if ($ya_config['autosuspendmain']==1) { $ck1 = " checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " checked"; }
    echo "<input type='radio' name='xautosuspendmain' value='1'$ck1>"._YES." &nbsp;";
    echo "<input type='radio' name='xautosuspendmain' value='0'$ck2>"._NO."</td></tr>\n";
    echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";

    echo "<tr><td align='center' colspan='2'><b>"._YA_LMTOPTIONS."</b></td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._YA_PERPAGE."</td><td><select name='xperpage'>\n";
    $i = 1;
    while ($i <= 10) {
        $k = $i * 50;
        echo "<option value='$k'";
        if ($ya_config['perpage'] == $k) { echo " selected"; }
        echo">$k "._YA_USERS."</option>\n";
        $i++;
    }
    echo "</select><br>("._YA_PERPAGENOTE.")</td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._YA_BADNICK.":</td><td><textarea dir='ltr' name='xbad_nick' rows='5' cols='40'>".$ya_config['bad_nick']."</textarea><br>"._YA_1PERLINE."</td><td>\n";
    echo "<tr><td align='right' valign='top'>"._YA_BADMAIL.":</td><td><textarea dir='ltr' name='xbad_mail' rows='5' cols='40'>".$ya_config['bad_mail']."</textarea><br>"._YA_1PERLINE."</td><td>\n";
    echo "<tr><td align='right' valign='top'>"._YA_NICKMIN.":</td><td><select name='xnick_min'>\n";
    for ($i = 3; $i <= 24; $i++) {
        echo "<option value='$i'";
        if ($ya_config['nick_min'] == $i) { echo " selected"; }
        echo">$i "._YA_CHARS."</option>\n";
    }
    echo "</select></td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._YA_NICKMAX.":</td><td><select name='xnick_max'>\n";
    for ($i = 4; $i <= 25; $i++) {
        echo "<option value='$i'";
        if ($ya_config['nick_max'] == $i) { echo " selected"; }
        echo">$i "._YA_CHARS."</option>\n";
    }
    echo "</select></td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._YA_PASSMIN.":</td><td><select name='xpass_min'>\n";
    for ($i = 3; $i <= 24; $i++) {
        echo "<option value='$i'";
        if ($ya_config['pass_min'] == $i) { echo " selected"; }
        echo">$i "._YA_CHARS."</option>\n";
    }
    echo "</select></td></tr>\n";
    echo "<tr><td align='right' valign='top'>"._YA_PASSMAX.":</td><td><select name='xpass_max'>\n";
    for ($i = 4; $i <= 25; $i++) {
        echo "<option value='$i'";
        if ($ya_config['pass_max'] == $i) { echo " selected"; }
        echo">$i "._YA_CHARS."</option>\n";
    }
    echo "</select></td></tr>\n";
    
    echo "<tr><td align='right' valign='top'>گیشه خوراک های آماه کاربر:</td><td><textarea dir='ltr' name='xheadlines' rows='6' cols='70'>".$ya_config['headlines']."</textarea><br>"._YA_1PERLINE."</td><td>\n";
    
    echo "<input type='hidden' name='op' value='UsersConfigSave'>";
    echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
    echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SAVECHANGES."'></td></tr>";
    echo "</form></table></center>";
    CloseTable();
    include("footer.php");


?>