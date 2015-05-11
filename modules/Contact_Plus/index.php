<?php

/**
 *
 * @package Contact_PLus														
 * @version $Id:	 KralPC $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */



if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}
require_once ("mainfile.php");
$module_name = basename(dirname(__file__));
get_lang($module_name);
$pagetitle = "- " . _CONTACTUS . "";
define('INDEX_FILE', true);
define('HTML_FORM', true); //if ur emails r not sent or delivered in spam box  , just make true into  False
addCSSToHead('modules/Contact_Plus/images/style.css', 'file');
addJSToBody('modules/Contact_Plus/images/validate.js', 'file');

function ns_form()
{
    global $db, $module_name, $gfx_chk, $sitename, $prefix, $cookie, $user_prefix,
        $user;
    include ("header.php");
    OpenTable();
    $result_s = $db->sql_query("select showaddress from " . $prefix .
        "_contact_us");
    list($showaddress) = $db->sql_fetchrow($result_s);
    $showaddress = intval($showaddress);
    if ($showaddress == 1)
    {
        echo "<br>";
        ns_info();
    }
    $result_p = $db->sql_query("SELECT * FROM " . $prefix . "_contact_us");
    $name = $db->sql_numrows($result_p);
    $name = intval($name);
    if ($name > 0)
    {
        echo "<br>";
        ns_phone();
    }
    if (is_user($user))
    {
        $result_ui = $db->sql_query("select name, uname, email from " . $user_prefix .
            "_users where uname='$cookie[1]'");
        if (!$result_ui)
        {
            $result_ui = $db->sql_query("select name,username,user_email from " .
                $user_prefix . "_users where username='$cookie[1]'");
        }
        list($yn, $yun, $ye) = $db->sql_fetchrow($result_ui);
    }
    if ($yn != "")
    {
        $ns_un = $yn;
    }
    else
    {
        $ns_un = $yun;
    }
    echo "<div><div id=\"main_box\"><div id=\"box_title\">" . _FORMHEADER . " $sitename</div><div id=\"box\" onmouseover=\"this.style.backgroundColor='#EFF4FB';\"  onmouseout=\"this.style.backgroundColor='#fff';\">";
    echo "<form onsubmit=\"return ValidateForm()\" name='form' id=form action=\"modules.php?name=$module_name\" method=\"post\" name=\"contact_plus\">";
    echo "<br><div id=\"page-wrap\">";
    echo "<div class=\"single-field\"><label for=\"cname\">" . _YOURNAME .
        ":</label><input name=\"cname\" type=\"text\" size=\"35\" value=\"$ns_un\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(cname)></div>";
    echo "<div class=\"single-field\"><label for=\"from\">" . _YOUREMAIL .
        ":</label><input name=\"from\" id=\"email\" type=\"text\" size=\"35\" value=\"$ye\"></div>";
    echo "<div class=\"single-field\"><label for=\"website\">" . _WEBSITE .
        ":</label><input name=\"website\"  type=\"text\" size=\"35\" value=\"$ns_website\"></div>";
    echo "<div class=\"single-field\"><label for=\"csubject\">" . _SUBJECT .
        ":</label><input id=\"subj\" type=\"text\" name=\"csubject\" size=\"35\" value=\"$ns_subject\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(subject)></div>";
    echo "<div class=\"single-field\"><label for=\"select\">" . _PLEASESELECT .
        ":</label><select id=\"dept\" name=\"dpid\"><option value=\"\" selected>------------------------------------------";
    $result = $db->sql_query("select pid, dept_name, dept_email from " . $prefix .
        "_contact_us order by dept_name");
    while (list($pid, $dept_name, $dept_email) = $db->sql_fetchrow($result))
    {
        $pid = intval($pid);
        $dept_name = stripslashes($dept_name);
        $dept_email = stripslashes($dept_email);
        echo "<option value=\"$pid\">$dept_name";
    }
    echo "</select></div>";
    echo "<div class=\"single-field\"><label for=\"message\">" . _YOURMESSAGE .
        ":</label><textarea id=\"message\" cols=\"45\" name=\"message\" rows=\"12\"></textarea></div>";

    if (extension_loaded("gd") AND $gfx_chk == 7)
    {
        echo "<div class=\"single-field\">" . show_captcha() . "</div>";
    }
    echo "<input type=\"hidden\" name=\"op\" value=\"ns_send\">";
    $ip = $_SERVER['REMOTE_ADDR'];
    echo "<input type=\"hidden\" name=\"ip\" value=\"$ip\">";
    echo "<input type=\"hidden\" name=\"yun\" value=\"$yun\">";
    echo "<div align='center' class=\"single-field\"><input type=\"submit\" onclick=\"CheckForm();\" name=\"submit\" value=\"" .
        _SEND . "\">";
    echo "&nbsp;&nbsp;<input type=\"reset\" value=\"" . _CLEAR . "\"></div>";
    echo "</form></div></div></div></div>";

    Closetable();
    include ("footer.php");
}
function ns_info()
{
    global $db, $module_name, $sitename, $prefix;
    $result = $db->sql_query("select address from " . $prefix . "_contact_us");
    list($address) = $db->sql_fetchrow($result);
    $address = FixQuotes(nl2br($address));
    echo "<div>";
    echo "<div id=\"main_box\">";
    echo "<div id=\"box_title\">" . _ADDRESSINFO . "</div>";
    echo "<div align=\"center\" id=\"box\" onmouseover=\"this.style.backgroundColor='#EFF4FB';\"  onmouseout=\"this.style.backgroundColor='#fff';\">";
    echo "$address";
    echo "</div></div></div><br>";
}
function ns_phone()
{
    global $db, $module_name, $sitename, $prefix;
    echo "<center><table width='85%' style=\"border:1px solid #686868; \" cellpadding=\"6\" cellspacing=\"0\" align=\"center\">"; //<-Replace with your sites color scheme
    echo "<tr  style='background:#333 url(modules/Contact_Plus/images/back.gif) repeat-x;	color:#fff'>";
    echo "<th  align=\"center\">" . _NSPHONENAME . "</th>";
    echo "<th  align=\"center\">" . _NSPHONENUM . "</th>";
    echo "<th  align=\"center\">" . _NSFAXNUM . "</th>";
    echo "<th  align=\"center\">" . _YAHOOID . "</th>";
    echo "<th  align=\"center\">" . _GMAILID . "</th></tr>";

    $result = $db->sql_query("select * from " . $prefix .
        "_contact_us order by name");
    while (list($pid, $name, $phone_num, $fax_num, $yahoo_id, $gmail_id) = $db->
        sql_fetchrow($result))
    {
        $pid = intval($pid);
        $name = stripslashes($name);
        $phone_num = stripslashes($phone_num);
        $fax_num = stripslashes($fax_num);
        $yahoo_id = stripslashes($yahoo_id);
        $gmail_id = stripslashes($gmail_id);
        echo "<tr onmouseover=\"this.style.backgroundColor='#EFF4FB';\"  onmouseout=\"this.style.backgroundColor='#fff';\">";
        if ($name == "")
        {
            echo "<th align=\"center\">------</th>";
        }
        else
        {
            echo "<th align=\"center\">$name</th>";
        }
        if ($phone_num == "")
        {
            echo "<th align=\"center\">------</th>";
        }
        else
        {
            echo "<th align=\"center\" dir=\"ltr\">$phone_num</th>";
        }
        if ($fax_num == "")
        {
            echo "<th align=\"center\">------</th>";
        }
        else
        {
            echo "<th align=\"center\" dir=\"ltr\">$fax_num</th>";
        }
        if ($yahoo_id == "")
        {
            echo "<th align=\"center\">------</th>";
        }
        else
        {
            echo "<th align=\"center\"><a href=\"ymsgr:sendim?$yahoo_id\" target=\"_self\" title=\"$yahoo_id\"><img src=\"http://opi.yahoo.com/online?u=$yahoo_id&m=g&t=1\" border=\"0\"></a></th>";
        }
        if ($gmail_id == "")
        {
            echo "<th align=\"center\">------</th>";
        }
        else
        {
            echo "<th  align=\"center\"><a href=\"mailto:$gmail_id\" title=\"$gmail_id\"><img src=\"modules/Contact_Plus/images/gmail.png\"></a></th>";
        }
    }
    echo "</tr></table></center><br><br>";
}
function ns_send($dpid, $cname, $website, $csubject, $from, $email, $message, $ip,$yun)
{
    global $db, $module_name, $sitename, $user, $nukeurl, $prefix;
    include ("header.php");
   if (extension_loaded("gd") AND $gfx_chk == 7 AND !check_captcha())
    {
        show_error(_WRONG_CODE);
    }

    if (!preg_match("/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/", $from))
    {
        OpenTable();
        echo "<center><font class=\"title\">" . _CONTACTUS . "</font></center>";
        CloseTable();
        OpenTable();
        echo "<br><center><font class=\"title\">" . _INVALIDEMAIL . ":<br><br>";
        echo "<font color=\"#CC0000\">$from</font><br><br>" . _INVALIDEMAIL2 .
            "</font>";
        echo "<br><br><br><font class=\"title\">" . _PLEASEGO . "</font>";
        echo "<br><br>";
        echo "[ <a href=\"javascript:history.go(-1)\">" . _BACK .
            "</a> ]</center><br>";
        CloseTable();
        include ("footer.php");
        exit;
    }
    $result = $db->sql_query("select dept_name, dept_email from " . $prefix .
        "_contact_us where pid='$dpid'");
    list($department, $dept_email) = $db->sql_fetchrow($result);
    $department = stripslashes(FixQuotes(check_html(removecrlf($department))));
    $from = stripslashes(FixQuotes(check_html(removecrlf($from))));

    	
///****************** SENDING USER A CONFIRMATION MESSAGE ******************
	$from_name= "$from";
	$from_address= "$from";
	$to_name="$department";
	$to_address="$dept_email";
    $subject = "$sitename |  $department : $csubject ";
          
	define("MAIL_CLASS",1); // ENABLING EMAIL SYSTEM TO RUN EMAIL CLASS     
    if (defined("HTML_FORM"))
    {

 	 $_message = "" . _YOURNAME . ": $cname";
        if (is_user($user))
        {
            $_message .= "<p>" . _USERNAME . ": <a href='$nukeurl/account/".$userinfo['userinfo']."' target='_blank'>".$userinfo['userinfo']."</a></p>";
        }
    $_message .= "<p>" . _WEBSITE . ": $website</p>
	<p>" . _SUBJECT . ": $csubject</p>
	<p>" . _DEPARTMENT . ": $department</p>
	<p><b>" . _MESSAGE . "</b>: <br>$message</p>
    <p>" . _USERIP . ": <a href='http://www.ip-adress.com/ip_tracer/$ip' target='_blank'>$ip</a><br>";
  	

    }
    else
    {
        $_message = "" . _VISITOR . ": $cname\n\n<br>";
        if (is_user($user))
        {
            $_message .= "" . _USERNAME . ": $yun\n\n<br>";
        }
        $_message .= "" . _WEBSITE . ": $website\n\n<br>" . _SUBJECT . ": $csubject\n<br>" .
            _DEPARTMENT . ": $department\n<br>" . _MESSAGE . ": $message\n\n<br>" .
            _USERIP . ": $ip";
    }
    
		//mail($to_address, $subject, $_message, "From: $from_address\nContent-Type: text/html; charset=utf-8")or die($php_errormsg);
	$send = HtmlMail($to_address,$to_name,$from_address,$from_name,$subject,$_message);
    
   if ($send == 1)
    {
        OpenTable();
        echo "<center><font class=\"title\">" . _CONTACTUS . "</font></center>";
        CloseTable();
        OpenTable();
        echo "<br>";
        echo "<br><div align=\"center\"><font class=\"title\">" . _THANKYOUFOR .
            " $sitename</font>";
        echo "<br><br>" . _EMAILSENT . "<br>" . _GETBACK . "</div><br><br>";
        echo "<center>[ <a href=\"index.php\">" . _HOME . "</a> ] - ";
        echo "[ <a href=\"modules.php?name=$module_name\">" . _CONTACTFORM .
            "</a> ]</center><br>";
        echo "<br>";
        CloseTable();
        include ("footer.php");
    }
    else
    {
        OpenTable();
        echo "<center><font class=\"title\">" . _CONTACTUS . "</font></center>";
        CloseTable();
        OpenTable();
        echo "<center><font class=\"title\">" . _ERROR2 . "</font>";
        echo "<br>" . _TRYAGAIN . "<br>";
        echo "[ <a href=\"modules.php?name=$module_name\">" . _BACK .
            "</a> ]</center>";
        CloseTable();
        include ("footer.php");
    }
    exit();
 
        include ("footer.php");
}


switch ($op)
{

    case "ns_send":
        ns_send($dpid, $cname, $website, $csubject, $from, $email, $message, $ip,
            $yun);
        break;

    default:
        ns_form();
        break;

}

?>