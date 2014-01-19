<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}

    if ($radminsuper == 1) { 

	list($uname, $rname, $email, $site, $upass) = $db->sql_fetchrow($db->sql_query("SELECT username, name, user_email, user_website, user_password FROM ".$user_prefix."_users WHERE user_id='$chng_uid'"));
	$pagetitle = ": "._USERADMIN." - "._PROMOTEUSER;
	include("header.php");
    GraphicAdmin();
	title(_USERADMIN." - "._PROMOTEUSER);
	amain();
	echo "<br>\n";
	OpenTable();
	echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
	echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='xop' value='$xop'>\n"; }
    echo "<input type='hidden' name='op' value='promoteUserConf'>\n";
	echo "<tr><td align=center>"._SURE2PROMOTE." <b>$uname<i>($chng_uid)</i></b>?</td></tr>\n";
	echo "<tr><td><table border='0'>";
    echo "<tr><td bgcolor='$bgcolor2'>"._NAME.":</td><td colspan='3'><input type='text' dir='ltr' name='add_name' size='30' maxlength='50' value='$rname'> <font class='tiny'>"._REQUIREDNOCHANGE."</font></td></tr>";
    echo "<tr><td bgcolor='$bgcolor2'>"._NICKNAME.":</td><td colspan='3'><input type='text' dir='ltr' name='add_aid' size='30' maxlength='30' value='$uname'> <font class='tiny'>"._REQUIRED."</font></td></tr>";
    echo "<tr><td bgcolor='$bgcolor2'>"._EMAIL.":</td><td colspan='3'><input type='text' dir='ltr' name='add_email' size='30' maxlength='60' value='$email'> <font class='tiny'>"._REQUIRED."</font></td></tr>";
    echo "<tr><td bgcolor='$bgcolor2'>"._URL.":</td><td colspan='3'><input type='text' dir='ltr' name='add_url' size='30' maxlength='60' value='$site'></td></tr>";
	//[vecino398(curt)]  www.vecino398.com -Modification-
	echo "<tr><td bgcolor='$bgcolor2' valign='top'>" . _PERMISSIONS . ":</td>";
	$result = $db->sql_query("SELECT mid, title FROM ".$prefix."_modules ORDER BY title ASC");
	while ($row = $db->sql_fetchrow($result)) {
		$title = str_replace("_", " ", $row[title]);
		if (file_exists("modules/$row[title]/admin/index.php") AND file_exists("modules/$row[title]/admin/links.php") AND file_exists("modules/$row[title]/admin/case.php")) {
            echo "<td><input type=\"checkbox\" name=\"auth_modules[]\" value=\"$row[mid]\"> $title</td>"; 
			if ($a == 2) {
				echo "</tr><tr><td>&nbsp;</td>";
				$a = 0;
			} else {
				$a++;
			}
		}
	}
	echo "</tr><tr><td>&nbsp;</td>"
        ."<td><input type=\"checkbox\" name=\"add_radminsuper\" value=\"1\"> <b>" . _SUPERUSER . "</b></td>" 
	."</tr>";
/////////////////////END/////////////////////////////
    echo "<input type='hidden' name='add_password' value='$upass'>";
	echo "</table></td></tr>";
    echo "<tr><td align=center><input type='hidden' name='chng_uid' value='$chng_uid'><input type='submit' value='"._PROMOTEUSER."'></td><tr>\n";
	echo "</form>\n";
	echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<input type='hidden' name='chng_uid' value='$chng_uid'>\n";
    echo "<tr><td align='center'><input type='submit' value='"._CANCEL."'></td></tr>\n";
	echo "</form>\n";
	echo "</table></center>\n";
	CloseTable();
	include("footer.php");

    }else{
header("Location: ../../../index.php");
	die ();
}

?>