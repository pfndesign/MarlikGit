<?php



if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

    include("header.php");

global $prefix, $db,$sitename,$userinfo,$currentlang, $user,$ya_config;

$ya_username= sql_quote($ya_username);
$ya_realname= sql_quote($ya_realname);


if (empty($ya_user_email)) {
$ya_email= sql_quote($ya_email);
}else {
$ya_email= sql_quote($ya_user_email);
}


$ya_user_email2= sql_quote($ya_user_email2);


if (empty($user_password)) {
$ya_password= sql_quote($ya_password);
}else {
$ya_password= sql_quote($user_password);
}

if (empty($user_password2)) {
$ya_confirm_password= sql_quote($ya_confirm_password);
}else {
$ya_confirm_password= sql_quote($user_password2);
}

$ip= sql_quote($ip);



 
//===========================================
// SECURITY CHECKS
//===========================================
if (getenv("HTTP_HOST") != "localhost") {
if(!empty($_COOKIE['register'])) ErrorDIV( '<p style="color:red;"> <font color="blue" ><b>'.COOKIE_SET_DATE.': '.$_COOKIE['register'].' </b></font></p>');
//$query4 = "select last_ip FROM ".__USER_TABLE." where last_ip = \"$ip\"";$numresults4=mysql_query($query4);$numrows4=mysql_num_rows($numresults4); if (!$numrows4 == 0) { ErrorDIV("<p style=\"color: red\">".IP_REGISTER_ACCESS.""); }
}
//===========================================
// USERNAME VALIDITY CHECKS
//===========================================
if (empty($ya_username)) { ErrorDIV("<p style=\"color: red\">".NO_ENTRY_USERNAME." </p>"); }

if (!checkUsername($ya_username)) {ErrorDIV("<p style=\"color: red\"> ". USERNAME_NUMBER."</p>"); }
$regex = "^(([A-Za-z0-9!#$%&'*+?^_`{|}~-][A-Za-z0-9!#$%&'*+?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$";
if (!preg_match("/$regex/", $ya_username)) {	 ErrorDIV(" ". NO_VALID_CHAR.""); }

$first =$ya_username[0];$second =$ya_username[1];$third =$ya_username[2];
if ($first==$second and $first==$third) {ErrorDIV("<p style=\"color: red\"><b>".NO_VALID_USER."</b></p>"); }
	
$BadNickList = explode("\r\n",$ya_config['bad_nick']);
for ($i=0; $i < count($BadNickList); $i++) {
if (preg_match("/$BadNickList[$i]/", $ya_username)){ ErrorDIV("<p style=\"color: red\"><b>".NO_ACCESS_USER."</b></p>"); }};

$query2 = "select username FROM ".__USER_TABLE." where username = '".sql_quote($ya_username)."'";
$numresults2=$db->sql_query($query2);$numrows2=$db->sql_numrows($numresults2); if (!$numrows2 == 0) { ErrorDIV("<p style=\"color: red\"> ". USERNAME_REGISTERED."<b>$trimmed</b></p>");}

//===========================================
// REAL NAME VALIDITY CHECKS
//===========================================
if (empty($ya_realname)) { ErrorDIV("<p style=\"color: red\">".NO_ENTRY_RUSER." </p>"); }

if (!checkRealname($ya_realname)) {ErrorDIV("<p style=\"color: red\">". RNAME_NUMBER." </p>"); }

$first2 =$ya_realname[0];$second2 =$ya_realname[1];$third2 =$ya_realname[2];
if ($first2==$second2 and $first2==$third2) {ErrorDIV("<p style=\"color: red\"><b>". NO_VALID_RNAME."</b></p>"); }


//===========================================
// EMAIL VALIDITY CHECKS
//===========================================
if (empty($ya_email)) { ErrorDIV("<p style=\"color: red\">".NO_ENTRY_EMAIL." </p>"); }

if (!validate_mail($ya_email)) {ErrorDIV( "<p >  <p style=\"color: red\"> ".NO_VALID_EMAIL." :$ya_email</p>"); }

$query3 = "select user_email FROM ".__USER_TABLE." where user_email = '".sql_quote($ya_email)."' ";
$numresults3=$db->sql_query($query3);$numrows3=$db->sql_numrows($numresults3); if (!$numrows3 == 0) { ErrorDIV("<p style=\"color: red\">". EMAIL_REGISTERED." : &quot;" . $trimmed3 . "&quot</p>"); }

if ($ya_config['doublecheckemail']==1) {if ($ya_email!=$ya_user_email2) {ErrorDIV("<p style=\"color: red\">". EMAIL_NOT_SAME." "); }} ;



//===========================================
// PASSWORD VALIDITY CHECKS
//===========================================
if (empty($ya_password)) { ErrorDIV("<p style=\"color: red\">".NO_ENTRY_PASS." </p>"); }
	
if (!checkPassword($ya_password)) {ErrorDIV("<p style=\"color: red\">".PASS_NUMBER." </p>"); }

if (empty($ya_confirm_password)) { ErrorDIV("<p style=\"color: red\">".NO_ENTRY_CONFIRM_PASS." </p>"); }

if ($ya_password!=$ya_confirm_password) {ErrorDIV("<p style=\"color: red\">".PASS_NOT_SAME.""); } ;

if (extension_loaded("gd") AND ($gfx_chk == 3 OR $gfx_chk == 4 OR $gfx_chk == 6 OR $gfx_chk == 7) AND !check_captcha()){
	$wrong_code = true;
	ErrorDIV("<p style=\"color: red\"> ". SECURITY_CODE_FAILED."</p>");
	die();
}


//if (!isset($var)) { ErrorDIV("<p>".DB_CHECK_PROBLEM."</p>");}
    $ya_email	= strtolower($ya_email);
    ya_userCheck($ya_username);
    ya_mailCheck($ya_email);
   
    if (!$stop) {
        $datekey = date("F j");
     /*   $rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $sitekey . $_POST[random_num] . $datekey));
        $code = substr($rcode, 2, $ya_config['codesize']);
        if (extension_loaded("gd") AND $code != $gfx_check AND ($ya_config['usegfxcheck'] == 1 OR $ya_config['usegfxcheck'] == 3)) {
            OpenTable();
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>"._SECCODEINCOR."<br><br>"._GOBACK."</font></center>";
            CloseTable();
            include("footer.php");
            die();
        }
      */
        if (empty($ya_password) AND empty($ya_confirm_password)) {
            $ya_password = YA_MakePass();
        } 
         elseif (
         $ya_password == $ya_confirm_password AND (strlen($ya_password) < $ya_config['pass_min'] OR strlen($ya_password) > $ya_config['pass_max'])) {
			ErrorDIV("<p style=\"color: red\"> ". _YA_PASSLENGTH."</p>");
        }
		
		$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need = '3' ORDER BY pos");
	    while ($sqlvalue = $db->sql_fetchrow($result)) {
	      $t = $sqlvalue['fid'];
          if ($nfield[$t] == "") {
		    OpenTable();
			if (substr($sqlvalue['name'],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>"._YA_FILEDNEED1."$name_exit"._YA_FILEDNEED2."<br><br>"._GOBACK."</font></center>";
            CloseTable();
            include("footer.php");
            die();
		  };
	    }
        title(_USERREGLOGIN);
        OpenTable();
        echo "<center><b>"._USERFINALSTEP."</b><br><br>$ya_realname, "._USERCHECKDATA."</center><br><br>";
        echo "<table align='center' border='0'>";
        echo "<tr><td><b>"._USERNAME.":</b> $ya_username<br></td></tr>";
        echo "<tr><td><b>"._EMAIL.":</b> $ya_email</td></tr>";
        echo "<tr><td><b>"._PASSWORD.":</b> $ya_password</td></tr>";
        echo "</table><br><br>";
        echo "<center><form action='modules.php?name=".sql_quote($module_name)."' method='post' onSubmit=\"javascript:submit.disabled=true;\"> ";

		if (is_array($nfield) &&  count($nfield) > 0) foreach ($nfield as $key => $var) echo "<input type='hidden' name='nfield[$key]' value='$nfield[$key]'>";

        echo "<input type='hidden' name='ya_username' value=\"$ya_username\">";
        echo "<input type='hidden' name='ya_realname' value=\"$ya_realname\">";
        echo "<input type='hidden' name='ya_user_email' value=\"$ya_email\">";
        echo "<input type='hidden' name='user_password' value=\"$ya_password\">";
        echo "<input type='hidden' name='op' value='new_finish'><br><br>";
        echo "<input type='submit' name='submit' value='"._FINISH."'> &nbsp;&nbsp;"._GOBACK."</form></center>";
        CloseTable();
    } else {
        OpenTable();
        echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
        echo "<font class='content'>$stop<br><br>"._GOBACK."</font></center>";
        CloseTable();
    }
    include("footer.php");

?>