<?php
if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

    mt_srand ((double)microtime()*1000000);
    $maxran = 1000000;
    $random_num = mt_rand(0, $maxran);
    addCSSToHead(INCLUDES_UCP."style/registration.css",'file');
    
    include("header.php");
    title(_USERAPPLOGIN);
    OpenTable();
    echo "<table align='center' cellpadding='3' cellspacing='3' border='0'>\n";
    echo "<tr><td align='center' bgcolor='$bgcolor1' colspan='2'><b>"._REGNEWUSER."</b></td></tr>\n";
    echo "<form action='modules.php?name=$module_name' method='post'>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._NICKNAME.":<br>"._REQUIRED."</td><td bgcolor='$bgcolor1'><input type='text' dir='ltr' name='ya_username' size='15' maxlength='".$ya_config['nick_max']."'><br><font class='tiny'>("._YA_NICKLENGTH.")</font></td></tr>\n";
// menelaos: by request: added realname to the registration form
    echo "<tr><td bgcolor='$bgcolor2'>"._UREALNAME.":<br>"._REQUIRED."</td><td bgcolor='$bgcolor1'><input type='text' name='ya_realname' size='40' maxlength='60' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(ya_realname)><br><font class='tiny'>"._YA_REALNAMENOTE."</font></td></tr>\n";

    echo "<tr><td bgcolor='$bgcolor2'>"._EMAIL.":<br>"._REQUIRED."</td><td bgcolor='$bgcolor1'><input type='text' dir='ltr' name='ya_user_email' size='40' maxlength='255'>&nbsp;<font class='tiny'></font></td></tr>\n";

    // menelaos: added configurable doublecheck email routine
    if ($ya_config['doublecheckemail']==1) {
	echo "<tr><td bgcolor='$bgcolor2'>"._RETYPEEMAIL.":</td><td bgcolor='$bgcolor1'><input type='text' dir='ltr' name='ya_user_email2' size='40' maxlength='255'></td></tr>\n";
    } else {
	echo "<input type='hidden' name='ya_user_email2' value='ya_user_email'>\n";
    }
    
	$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE (need = '2') OR (need = '3') ORDER BY pos");
	    while ($sqlvalue = $db->sql_fetchrow($result)) {
	      $t = $sqlvalue[fid];
		  $value2 = explode("::", $sqlvalue[value]);
		  if (substr($sqlvalue[name],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
         	$maxlengthfield = ($sqlvalue[size]==0 ? "" : "maxlength='$sqlvalue[size]'");    		
		  if (count($value2) == 1) { 
			echo "<tr><td bgcolor='$bgcolor2'>$name_exit</td><td>";
			echo "<input type='text' name='nfield[$t]' size='20' maxlength='$maxlengthfield'>\n";
			} else {
			echo "<tr><td bgcolor='$bgcolor2'>$name_exit</td><td>";
			echo "<select name='nfield[$t]'>\n";
				for ($i = 0; $i<count($value2); $i++) {
				echo "<option value=\"".trim($value2[$i])."\">".trim($value2[$i])."</option>\n";
				}
		  	echo "</select>";
		  }
         	$reqfield = ($sqlvalue[need] == 3 ? "&nbsp;<font class='tiny' style='color:red'>"._REQUIRED."</font>" : "");
		  	echo "</td></tr>\n";	  
	    }
	
	echo "<tr><td bgcolor='$bgcolor2'>"._PASSWORD.":</td><td bgcolor='$bgcolor1'><input type='password' dir='ltr' name='user_password' size='10' maxlength='".$ya_config['pass_max']."'><br><font class='tiny'>("._BLANKFORAUTO.")</font><br><font class='tiny'>("._YA_PASSLENGTH.")</font></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._RETYPEPASSWORD.":</td><td bgcolor='$bgcolor1'><input type='password' dir='ltr' name='user_password2' size='10' maxlength='".$ya_config['pass_max']."'><br><font class='tiny'>("._BLANKFORAUTO.")</font><br><font class='tiny'>("._YA_PASSLENGTH.")</font></td></tr>\n";


         if (extension_loaded("gd") AND ($gfx_chk == 3 OR $gfx_chk == 4 OR $gfx_chk == 6 OR $gfx_chk == 7)) {
         	global $wrong_code;
         	if($wrong_code)
         	echo "<div style='color:red;'>"._WRONG_CODE."</div>";
         	echo show_captcha();
         }

    echo "<input type='hidden' name='op' value='new_confirm'>\n";
    echo "<tr><td align='right' bgcolor='$bgcolor1' colspan='2'><input type='submit' value='"._YA_CONTINUE."'></td></tr>\n";
    echo "</form></table>\n";
    echo "<br>\n";
    echo ""._WAITAPPROVAL."<br><br>\n";
    echo ""._COOKIEWARNING."<br>\n";
    echo ""._ASREGUSER."<br>\n";
    echo "<ul>\n";
    echo "<li>"._ASREG1."\n";
    echo "<li>"._ASREG2."\n";
    echo "<li>"._ASREG3."\n";
    echo "<li>"._ASREG4."\n";
    echo "<li>"._ASREG5."\n";
    $handle=opendir('themes');
    while ($file = readdir($handle)) {
        if ((!preg_match("/[.]/",$file) AND file_exists("themes/$file/theme.php"))) { $thmcount++; }
    }
    closedir($handle);
    if ($thmcount > 1) { echo "<li>"._ASREG6."\n"; }
    $sql = "SELECT custom_title FROM ".$prefix."_modules WHERE active='1' AND view='1' AND inmenu='1'";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
        $custom_title = $row[custom_title];
        if ($custom_title != "") { echo "<li>"._ACCESSTO." $custom_title\n"; }
    }
    $sql = "SELECT title FROM ".$prefix."_blocks WHERE active='1' AND view='1'";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
        $b_title = $row[title];
        if ($b_title != "") { echo "<li>"._ACCESSTO." $b_title\n"; }
    }
    if (is_active("Journal")) { echo "<li>"._CREATEJOURNAL."\n"; }
    if ($my_headlines == 1) { echo "<li>"._READHEADLINES."\n"; }
    echo "<li>"._ASREG7."\n";
    echo "</ul>\n";
    echo ""._REGISTERNOW."<br>\n";
    echo ""._WEDONTGIVE."<br><br>\n";
// removed by menelaos hetnet dot nl
//  echo "<center><font class='content'>[ <a href='modules.php?name=$module_name'>"._USERLOGIN."</a> | <a href='modules.php?name=$module_name&op=pass_lost'>"._PASSWORDLOST."</a> ]</font></center>\n";
    CloseTable();
    include("footer.php");

?>