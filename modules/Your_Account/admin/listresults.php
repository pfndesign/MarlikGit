<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ": "._USERADMIN." - "._SEARCHUSERS;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN.": "._SEARCHUSERS);
    amain();
    echo "<br>\n";
    asearch();
    echo "<br>\n";
    OpenTable();
    $query = str_replace("\"","",$query);
    $query = str_replace("\'","",$query);
    if ($find == "findUser") { $usertable = $user_prefix."_users"; } else { $usertable = $user_prefix."_users_temp"; }
    if ($match == "equal") { $sign = "='$query'"; } else { $sign = "LIKE '%".$query."%'"; }
    if (!isset($min)) $min=0;
    if (!isset($max)) $max=$min+$ya_config['perpage'];
    $totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM $usertable WHERE $what $sign"));
    echo "<table align='center' cellpadding='2' cellspacing='2' bgcolor='$textcolor1' border='0'>\n";
    echo "<tr bgcolor='$bgcolor2'>\n<td><b>"._USERID."</b></td>\n";
    echo "<td><b>"._USERNAME."</b></td>\n";
    echo "<td align='center'><b>"._UREALNAME."</b></td>\n";
    echo "<td align='center'><b>"._EMAIL."</b></td>\n";
    echo "<td align='center'><b>"._REGDATE."</b></td>\n";
    echo "<td align='center'><b>"._FUNCTIONS."</b></td>\n</tr>\n";
    $result = $db->sql_query("SELECT * FROM $usertable WHERE $what $sign ORDER BY username LIMIT $min,".$ya_config['perpage']."");
    while($chnginfo = $db->sql_fetchrow($result)) {
        echo "<tr bgcolor='$bgcolor1'><form action='".ADMIN_OP."mod_users' method='post'>\n";
        echo "<input type='hidden' name='query' value='$query'>\n";
        echo "<input type='hidden' name='find' value='$find'>\n";
        echo "<input type='hidden' name='what' value='$what'>\n";
        echo "<input type='hidden' name='match' value='$match'>\n";
        echo "<input type='hidden' name='min' value='$min'>\n";
        echo "<input type='hidden' name='xop' value='$op'>\n";
        echo "<input type='hidden' name='chng_uid' value='".$chnginfo['user_id']."'>\n";
		echo "<input type='hidden' name='act_uid' value='".$chnginfo['user_id']."'>\n";
        echo "<td>".$chnginfo['user_id']."</td>\n";
        echo "<td>".$chnginfo['username']."</td>\n";
        echo "<td align='center'>".$chnginfo['realname']."</td>\n";
        echo "<td align='center'>".$chnginfo['user_email']."</td>\n";
		$date_temp = explode(" ", $chnginfo['user_regdate']);
        $date_temp[1] = substr($date_temp[1], 0, 2);
        $date_temp[0] = month_number($date_temp[0], 2);
        $row['user_regdate'] = $date_temp[2] . "-" . $date_temp[0] . "-" . $date_temp[1];
        $regdateu = hejridate($row['user_regdate'], 1, 4);
        echo "<td align='center'>$regdateu</td>\n";
        echo "<td align='center'><select name='op'>\n";
        if ($find == "tempUser") {
            echo "<option value='detailsTemp'>"._DETUSER."</option>\n";
            echo "<option value='modifyTemp'>"._MODIFY."</option>\n";
            echo "<option value='resendMail'>"._RESEND."</option>\n";
            echo "<option value='approveUser'>"._YA_APPROVE."</option>\n";
  	        echo "<option value='activateUser'>"._YA_ACTIVATE."</option>\n";
            echo "<option value='denyUser'>"._DENY."</option>\n";
        } else {
            echo "<option value='detailsUser'>"._DETUSER."</option>\n";
            echo "<option value='modifyUser'>"._MODIFY."</option>\n";
            // suspended
            if ($chnginfo['user_level'] == 0) { echo "<option value='restoreUser'>"._RESTORE."</option>\n"; }
            // deactivated
            if ($chnginfo['user_level'] == -1) { echo "<option value='removeUser'>"._REMOVE."</option>\n"; }
            // active
            if ($chnginfo['user_level'] > 0 AND $radminsuper == 1) { echo "<option value='promoteUser'>"._PROMOTE."</option>\n"; }
            if ($chnginfo['user_level'] == 1) { echo "<option value='suspendUser'>"._SUSPEND."</option>\n"; }
            if ($chnginfo['user_level'] > -1) { echo "<option value='deleteUser'>"._YA_DEACTIVATE."</option>\n"; }
        }
        echo "</select><input type='submit' value='"._OK."'></td>\n";
        echo "</form></tr>\n";
    }
    echo "</table>\n";
    echo "<br>\n";
    yapagenums($op, $totalselected, $ya_config['perpage'], $max, $find, $what, $match, $query);
    CloseTable();
    include("footer.php");

}

?>