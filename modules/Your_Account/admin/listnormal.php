<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}



if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ": "._USERADMIN." - "._YA_USERS;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN.": "._YA_USERS);
    amain();
    echo "<br>\n";
    OpenTable();
    if (!isset($min)) $min=0;
    if (!isset($max)) $max=$min+$ya_config['perpage'];
    if ($query == "") 	{ $where = "WHERE user_id > '1'"; }
    if ($query == "a")	{ $where = "WHERE user_id > '1'"; }
    if ($query == "-1")	{ $where = "WHERE user_level = '-1' AND user_id > '1'"; }
    if ($query == "0")	{ $where = "WHERE user_level = '0'	  AND user_id > '1'"; }
    if ($query == "1")	{ $where = "WHERE user_level > '0'	  AND user_id > '1'"; }
    $totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users $where"));
    echo "<table align='center' cellpadding='2' cellspacing='2' bgcolor='$textcolor1' border='0'>\n";
    echo "<tr bgcolor='$bgcolor2'>\n<td><b>"._USERNAME." ("._USERID.")</b></td>\n";
    echo "<td align='center'><b>"._UREALNAME."</b></td>\n";
    echo "<td align='center'><b>"._EMAIL."</b></td>\n";
    echo "<td align='center'><b>"._REGDATE."</b></td>\n";
    echo "<td align='center'><b>"._FUNCTIONS."</b></td>\n</tr>\n";
    $result = $db->sql_query("SELECT * FROM ".$user_prefix."_users $where ORDER BY username LIMIT $min,".$ya_config['perpage']."");
    while($chnginfo = $db->sql_fetchrow($result)) {
        echo "<tr bgcolor='$bgcolor1'><form method='post' action='".ADMIN_OP."mod_users'>\n";
        echo "<input type='hidden' name='query' value='$query'>\n";
        echo "<input type='hidden' name='min' value='$min'>\n";
        echo "<input type='hidden' name='xop' value='$op'>\n";
        echo "<input type='hidden' name='chng_uid' value='".$chnginfo['user_id']."'>\n";
        echo "<td>".$chnginfo['username']." (".$chnginfo['user_id'].")</td>\n";
        echo "<td align='center'>".$chnginfo['name']."</td>\n";
        echo "<td align='center'>".$chnginfo['user_email']."</td>\n";
		$date_temp = explode(" ", $chnginfo['user_regdate']);
        $date_temp[1] = substr($date_temp[1], 0, 2);
        $date_temp[0] = month_number($date_temp[0], 2);
        $row['user_regdate'] = $date_temp[2] . "-" . $date_temp[0] . "-" . $date_temp[1];
        $regdateu = hejridate($row['user_regdate'], 1, 4);
        echo "<td align='center'>$regdateu</td>\n";
        echo "<td align='center'><select name='op'>\n";
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
        echo "</select><input type='submit' value='"._OK."'></td>\n";
        echo "</form></tr>\n";
    }
    echo "</table>\n";
    echo "<br>\n";
    yapagenums($op, $totalselected, $ya_config['perpage'], $max, "", "", "", $query);
    CloseTable();
    include("footer.php");

}

?>