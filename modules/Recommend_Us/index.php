<?php
if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- "._RECOMMEND."";

function RecommendSite($mess="0") {
	global $user, $cookie, $prefix, $db, $user_prefix, $module_name, $gfx_chk;
    include ("header.php");

    OpenTable();
    echo "<h3>"._RECOMMEND."</h3><br />";
	$mess = intval($mess);
	if ($mess == 1) {
		$mess = "<center>"._SECURITYCODEERROR."</center><br><br>";
	} else {
		$mess = "";
	}
    echo "$mess<form action=\"modules.php?name=$module_name\" method=\"post\">"
		."<input type=\"hidden\" name=\"op\" value=\"SendSite\">";
	if (is_user($user)) {
		$row = $db->sql_fetchrow($db->sql_query("SELECT username, user_email from ".$user_prefix."_users where user_id = '".intval($cookie[0])."'"));
		$yn = stripslashes(check_html($row['username'], "nohtml"));
		$ye = stripslashes(check_html($row['user_email'], "nohtml"));
	}
	else {
		$yn = "";
		$ye = "";
	}
    echo "<b>"._FYOURNAME." </b><br><input type=\"text\" name=\"yname\" value=\"$yn\" ><br><br />"
		."<b>"._FYOUREMAIL."<br></b> <input type=\"text\" dir=\"ltr\" name=\"ymail\" value=\"$ye\"><br><br>\n"
		."<b>"._FFRIENDNAME."<br></b> <input type=\"text\" name=\"fname\" ><br><br />\n"
		."<b>"._FFRIENDEMAIL."<br></b><input type=\"text\" dir=\"ltr\" name=\"fmail\"><br>\n";
			mt_srand ((double)microtime()*1000000);
	$maxran = 1000000;
	$random_num = mt_rand(0, $maxran);

    if (extension_loaded("gd") AND $gfx_chk == 7)
    {
        echo "<div class=\"single-field\">" . show_captcha() . "</div>";
    }
	echo "<input type=submit value="._SEND."></form>\n";
    CloseTable();
    include ('footer.php');
}

function SendSite($yname, $ymail, $fname, $fmail, $random_num="0", $gfx_check) {
    global $sitename, $slogan, $nukeurl, $module_name, $gfx_chk, $sitekey;

    if (empty($fname) OR empty($fmail) OR empty($yname) OR empty($ymail)) {
  	                 include("header.php");
  	                 title("$sitename - "._RECOMMEND."");
  	                 OpenTable();
  	                 echo "<center>"._SENDSITEERROR."<br><br>"._GOBACK."";
  	                 CloseTable();
  	                 include("footer.php");
  	                 die();
  	         }
             $fname = removecrlf(check_html($fname, "nohtml"));
  	         $fmail = validate_mail(removecrlf(check_html($fmail, "nohtml")));
  	         $yname = removecrlf(check_html($yname, "nohtml"));
  	         $ymail = validate_mail(removecrlf(check_html($ymail, "nohtml")));
	$datekey = date("F j");
	$rcode = hexdec(md5($_SERVER['HTTP_USER_AGENT'] . $sitekey . $random_num . $datekey));
	$code = substr($rcode, 2, 3);
   if (extension_loaded("gd") AND $gfx_chk == 7 AND !check_captcha())
    {
        show_error(_WRONG_CODE);
		Header("Location: modules.php?name=$module_name&op=RecommendSite&mess=$mess");
    } else {
    $subject = ""._INTSITE." $sitename";
    $message = ""._HELLO." $fname:\n\n<br>"._YOURFRIEND." $yname "._OURSITE." $sitename "._INTSENT."\n\n\n<br>"._FSITENAME." $sitename\n<br>$slogan\n<br>"._FSITEURL." <a href=\"$nukeurl\">$nukeurl</a>\n";
	         if (empty($fname) || empty($fmail) || empty($yname) || empty($ymail)) {
  	                 Header("Location: modules.php?name=$module_name");
  	         } else {	
    $message = FarsiMail($message);
    mail($fmail, $subject, $message, "From: \"$yname\" <$ymail>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nContent-transfer-encoding: 8bit");
    update_points(3);
    Header("Location: modules.php?name=$module_name&op=SiteSent&fname=$fname");
		}
	}
}

function SiteSent($fname) {
    include ('header.php');
    $fname = removecrlf(check_html($fname, "nohtml"));
    OpenTable();
    echo "<center><font class=\"content\">"._FREFERENCE." $fname...<br><br>"._THANKSREC."</font></center>";
    CloseTable();
    include ('footer.php');
}

if (!isset($mess)) { $mess = 0; }
if (!isset($op)) { $op = ""; }
	 
switch($op) {

    case "SendSite":
	SendSite($yname, $ymail, $fname, $fmail, $random_num, $gfx_check);
    break;
	
    case "SiteSent":
    SiteSent($fname);
    break;

    default:
	RecommendSite($mess);
    break;

}

?>