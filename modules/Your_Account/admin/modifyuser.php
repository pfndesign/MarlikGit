<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

$pagetitle = ": "._USERADMIN." - "._USERUPDATE;
include("header.php");
    GraphicAdmin();
title(_USERADMIN." - "._USERUPDATE);
amain();
echo "<br>\n";
$result = $db->sql_query("select * from ".$user_prefix."_users where user_id='$chng_uid' or username='$chng_uid'");
if($db->sql_numrows($result) > 0) {
    $chnginfo = $db->sql_fetchrow($result);
	
	$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field");
	while ($sqlvalue = $db->sql_fetchrow($result)) {
	list($value) = $db->sql_fetchrow( $db->sql_query("SELECT value FROM ".$user_prefix."_cnbya_value WHERE fid ='$sqlvalue[fid]' AND uid = '$chnginfo[user_id]'"));
	$chnginfo[$sqlvalue[name]] = $value;
	}
	
    OpenTable();
    echo "<center><fieldset><legend>"._YA_EDIT_GENERAL." </legend>
    <table border='0'>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    echo "<tr><td>"._USERID.":</td><td><b>".$chnginfo['user_id']."</b></td></tr>\n";
    echo "<tr><td>"._NICKNAME.":</td><td><input type='text' dir='ltr' name='chng_uname' value='".$chnginfo['username']."' size='20'><br><b>"._YA_CHNGRISK."</b></td></tr>\n";
    echo "<tr><td>"._UREALNAME.":</td><td><input type='text' name='chng_name' value='".$chnginfo['name']."' size='45' maxlength='60' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(chng_name)></td></tr>\n";
    echo "<tr><td>"._EMAIL.":</td><td><input type='text' dir='ltr' name='chng_email' value='".$chnginfo['user_email']."' size='45' maxlength='60'> <font class='tiny'>"._REQUIRED."</font></td></tr>\n";
    echo "<tr><td>"._PASSWORD.":</td><td><input type='password' dir='ltr' name='chng_pass' size='12' maxlength='12'></td></tr>\n";
    echo "<tr><td>"._RETYPEPASSWD.":</td><td><input type='password' dir='ltr' name='chng_pass2' size='12' maxlength='12'> <font class='tiny'>"._FORCHANGES."</font></td></tr>\n";
    echo "</table></fieldset>\n";

    echo "<fieldset><legend>"._YA_EDIT_OTHERS."</legend><table border='0'>\n";    
    echo "<tr><td>"._URL.":</td><td><input type='text' dir='ltr' name='chng_url' value='".$chnginfo['user_website']."' size='45' maxlength='60'></td></tr>\n";
    echo "<tr><td>"._FAKEEMAIL.":</td><td><input type='text' dir='ltr' name='chng_femail' value='".$chnginfo['femail']."' size='45' maxlength='60'></td></tr>\n";
    
		$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need <> '0' ORDER BY pos");
	    while ($sqlvalue = $db->sql_fetchrow($result)) {
	      $t = $sqlvalue[fid];
		  $value2 = explode("::", $sqlvalue[value]);
		  if (substr($sqlvalue[name],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
		  if (count($value2) == 1) { 
		    echo "<tr><td>$name_exit</td><td><input type='text' name='nfield[$t]' value='".$chnginfo[$sqlvalue[name]]."' size='20' maxlength='$sqlvalue[size]'></td></tr>\n";
	      } else {
		    echo "<tr><td>$name_exit</td><td>";
			echo "<select name='nfield[$t]'>\n";
     	    for ($i = 0; $i<count($value2); $i++) {
			  if (trim($chnginfo[$sqlvalue[name]]) == trim($value2[$i])) $sel = "selected"; else $sel = "";
              echo "<option value=\"".trim($value2[$i])."\" $sel>$value2[$i]</option>\n";
		    }
			echo "</select>";
			echo "</td></tr>\n";
		  }
		}
		
	echo "<tr><td>"._ICQ.":</td><td><input type='text' dir='ltr' name='chng_user_icq' value='".$chnginfo['user_icq']."' size='20' maxlength='20'></td></tr>\n";
    echo "<tr><td>"._AIM.":</td><td><input type='text' dir='ltr' name='chng_user_aim' value='".$chnginfo['user_aim']."' size='20' maxlength='20'></td></tr>\n";
    echo "<tr><td>"._YIM.":</td><td><input type='text' dir='ltr' name='chng_user_yim' value='".$chnginfo['user_yim']."' size='20' maxlength='20'></td></tr>\n";
    echo "<tr><td>"._MSNM.":</td><td><input type='text' dir='ltr' name='chng_user_msnm' value='".$chnginfo['user_msnm']."' size='20' maxlength='20'></td></tr>\n";
    echo "<tr><td>"._LOCATION.":</td><td><input type='text' name='chng_user_from' value='".$chnginfo['user_from']."' size='25' maxlength='60' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(chng_user_from)></td></tr>\n";
    echo "<tr><td>"._OCCUPATION.":</td><td><input type='text' name='chng_user_occ' value='".$chnginfo['user_occ']."' size='25' maxlength='60' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(chng_user_occ)></td></tr>\n";
    echo "<tr><td>"._INTERESTS.":</td><td><input type='text' name='chng_user_interests' value='".$chnginfo['user_interests']."' size='25' maxlength='255' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(chng_user_interests)></td></tr>\n";
    if ($chnginfo['user_viewemail'] ==1) { $cuv = "checked"; } else { $cuv = ""; }
    echo "<tr><td>"._OPTION.":</td><td><input type='checkbox' name='chng_user_viewemail' value='1' $cuv> "._ALLOWUSERS."</td></tr>\n";
    if ($chnginfo['newsletter'] == 1) { $cnl = "checked"; } else { $cnl = ""; }
    echo "<tr><td>"._NEWSLETTER.":</td><td><input type='checkbox' name='chng_newsletter' value='1' $cnl> "._YES."</td></tr>\n";
 
    echo "<tr><td valign='top'>"._SIGNATURE.":</td><td><textarea name='chng_user_sig' rows='6' cols='45' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);>".$chnginfo['user_sig']."</textarea><br><IMG src=\"images/fa.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(chng_user_sig)></td></tr>\n";
    
    echo "<tr><td valign='top'>"._POINTS.":</td><td><input type='text' name='chang_user_points' value='".$chnginfo['points']."' ></td></tr>\n";
    
    echo "<input type='hidden' name='chng_avatar' value='".$chnginfo['user_avatar']."'>\n";
    echo "<input type='hidden' name='chng_uid' value='$chng_uid'>\n";
    echo "<input type='hidden' name='old_uname' value='".$chnginfo['username']."'>\n";
    echo "<input type='hidden' name='old_email' value='".$chnginfo['user_email']."'>\n";
    echo "<input type='hidden' name='op' value='modifyUserConf'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='xop' value='$xop'>\n"; }
    echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SAVECHANGES."'></td></tr>\n";
    echo "</form>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center' colspan='2'><input type='submit' value='"._CANCEL."'></td></tr>\n";
    echo "</form>\n";
    echo "</center>\n";
    echo "</table></fieldset>\n";
    CloseTable();
} else {
    OpenTable();
    echo "<center><b>"._USERNOEXIST."</b></center>\n";
    CloseTable();
}
include("footer.php");

}

?>