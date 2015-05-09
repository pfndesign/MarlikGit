<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV NUKELEARN PORTAL																|
	|	* @version : 1.0.0.599																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.nukelearn.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

global $prefix, $db,$admin, $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) { die ("Access Denied"); }
$aid = substr("$aid", 0,25);

if (is_superadmin($admin) OR is_admin_of("Contact_Plus",$admin)) {

// [START]- USV -- Kralpc - Contact US -- 10/10/09-----
function menu() {
    global $prefix, $db, $admin_file;
    OpenTable();
    echo "<table border=\"0\" width=\"50%\" align=\"center\">
    <tr>
			<td><img src='images/icon/phone.png'>&nbsp;<a href=\"".ADMIN_OP."Add_Contact_US\">"._NSADDPHONE."</a></td>
			<td><img src='images/icon/house.png'>&nbsp;<a href=\"".ADMIN_OP."Add_Contact_Address\">"._NSSETTING."</a></td>
	</tr>
	</table>";
    CloseTable();
    }
function contact() {
    global $prefix, $db, $admin_file;
    include("header.php");
    GraphicAdmin();
    menu();
    OpenTable();
    echo "<center><b><u>"._NSCURRENTPHONE."</u></b></center>";
    echo "<table id=\"gradient-style\" width=\"95%\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" align=\"center\">";
    echo "<tr bgcolor=\"$bgcolor4\">";
    echo "<th scope='col' align=\"center\">"._RADIF."</th>";
    echo "<th scope='col' align=\"center\">"._NSNAME."</th>";
    echo "<th scope='col' align=\"center\">"._NSPHONENUM."</th>";
    echo "<th scope='col' align=\"center\">"._NSFAXNUM."</th>";
    echo "<th scope='col' align=\"center\">"._YAHOOID."</th>";
    echo "<th scope='col' align=\"center\">"._GMAILID."</th>";
    echo "<th scope='col' align=\"center\">"._DEPTNAME."</th>";
    echo "<th scope='col' align=\"center\">"._DEPTEMAIL."</th>";
    echo "<th scope='col' align=\"center\">"._NSCONTACTFUNC."</th></tr>";
    $radifnum = 1;
    $result = $db->sql_query("select pid, name, phone_num, fax_num, yahoo_id, gmail_id, dept_name, dept_email from ".$prefix."_contact_us order by pid");
    while(list($pid, $name, $phone_num, $fax_num, $yahoo_id, $gmail_id, $dept_name, $dept_email) = $db->sql_fetchrow($result)) {
    $pid = intval($pid);
    $name = stripslashes($name);
    $phone_num  = stripslashes($phone_num);
    $fax_num    = stripslashes($fax_num);
    $yahoo_id   = stripslashes($yahoo_id);
    $gmail_id   = stripslashes($gmail_id);
    $dept_name  = stripslashes($dept_name);
    $dept_email = stripslashes($dept_email);
    echo "<tr bgcolor=\"$bgcolor4\">";
    echo "<td align=\"center\">$radifnum</td>";
    echo "<td align=\"center\">$name</td>";
    echo "<td align=\"center\">$phone_num</td>";
    echo "<td align=\"center\">$fax_num</td>";
    echo "<td align=\"center\">$yahoo_id</td>";
    echo "<td align=\"center\">$gmail_id</td>";
    echo "<td align=\"center\">$dept_name</td>";
    echo "<td align=\"center\">$dept_email</td>";
    echo "<td align=\"center\">";
    echo "<a href=\"".ADMIN_OP."contact_us_edit&amp;pid=$pid#Edit\"><img src='images/icon/cog_edit.png' title=\""._NSFEDIT."\"></a>&nbsp;&nbsp;";
    echo "<a href=\"".ADMIN_OP."contact_us_delete&amp;pid=$pid#Delete\"><img src='images/icon/cog_delete.png' title=\""._NSFDELETE."\"></a>";
    echo "</td></tr>";
    $radifnum++;
        }
    echo "</table>";
    CloseTable();
    include("footer.php");
}
function Add_Contact_Address() {
    global $prefix, $db, $admin_file;
    include("header.php");
    GraphicAdmin();
    menu();
    OpenTable();
    echo "<br><br><center><font class=\"option\"><b><u>"._NSCURRADDRESS."</u></b></font><br><br>";
    $result = $db->sql_query("select address from ".$prefix."_contact_us");
    list($address) = $db->sql_fetchrow($result);
    $address = FixQuotes(nl2br(filter_text($address)));
    echo "<table cellspacing=\"0\" cellpadding=\"6\" border=\"0\" align=\"center\">";
    echo "<tr><td align=\"right\">";
    echo "$address";
    echo "</td></tr></table>";
    echo "<br><br>";
    echo "<form action='".$admin_file.".php' method='post'>";
    $result_s = $db->sql_query("select showaddress from ".$prefix."_contact_us");
    list($showaddress) = $db->sql_fetchrow($result_s);
    echo "<center>"._NSADDSHOW." ";
    if ($showaddress == 1) {
    echo "<input type='radio' name='xshow_add' value='1' checked>"._NSYES." &nbsp;
    <input type='radio' name='xshow_add' value='0'>"._NSNO."";
    } else {
    echo "<input type='radio' name='xshow_add' value='1'>"._NSYES." &nbsp;
    <input type='radio' name='xshow_add' value='0' checked>"._NSNO."";
    }
    echo "<br>"._NSADDRESS2."<br>";
    $result = $db->sql_query("select address from ".$prefix."_contact_us");
    list($address) = $db->sql_fetchrow($result);
    echo "<textarea name=\"address\" cols=\"60\" rows=\"10\">";
    echo "".stripslashes($address)."";
    echo "</textarea><br><br>";
    echo "<br><br><input type='hidden' name='op' value='showinfo'>";
    echo "<input type='submit' name=\"submit\" value=\""._NSSAVE."\">";
    echo "</form></center>";
    echo "<br><br><img src='images/icon/arrow_undo.png'>&nbsp;&nbsp;<a href=\"".ADMIN_OP."contact\">"._BACK."</b>";
    CloseTable();
    include("footer.php");
}
function show_info($xshow_add,$address) {
    global $prefix, $db, $admin_file;
    $db->sql_query("update ".$prefix."_contact_us set showaddress='$xshow_add'");
    $address = stripslashes($address);
    $db->sql_query("update ".$prefix."_contact_us set address='$address'");
    Header("Location: ".ADMIN_OP."contact#Default");
}
function Add_Contact_US() {
    global $prefix, $db, $admin_file;
    include("header.php");
    GraphicAdmin();
    menu();
    OpenTable();
    echo "<br><center><b>"._NSADDPHONE."</b><br><br>";
    echo "<form action=\"".$admin_file.".php\" method=\"post\">";
    echo"<div dir='ltr' align=\"center\">
	<table border=\"0\" width=\"40%\">
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._NSNAME.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" name=\"name\" size=\"50\"></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._NSPHONENUM.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"phone_num\" size=\"50\"></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._NSFAXNUM.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"fax_num\" size=\"50\"></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._YAHOOID.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"yahoo_id\" size=\"50\" id='yahoo'><label for=\"yahoo\"><font color=\"#FF0000\"><b>*</b></font>"._NOYAHOOCOM."</label></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._GMAILID.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"gmail_id\" size=\"50\" id='gmail'><label for=\"gmail\"><font color=\"#FF0000\"><b>*</b></font>"._WITHGMAILCOM."</label></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._DEPTNAME.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" name=\"dept_name\" size=\"50\" id='dept'><label for=\"dept\"><font color=\"#FF0000\"><b>*</b></font>"._DEPTLABEL."</label></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._DEPTEMAIL.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"dept_email\" size=\"50\" id='depte'><label for=\"depte\"><font color=\"#FF0000\"><b>*</b></font>"._DEPTLABEL."</label></td>
		</tr>
		</table></div>";
    echo "<input type=\"hidden\" name=\"op\" value=\"contact_us_add\">";
    echo "<input type=\"submit\" value=\""._NSADD."\">";
    echo "</form>";
    echo "<br><br><img src='images/icon/arrow_undo.png'>&nbsp;&nbsp;<a href=\"".ADMIN_OP."contact\">"._BACK."</center>";
    echo "<br><br>";
    CloseTable();
      include("footer.php");
}
function contact_us_add($name, $phone_num, $fax_num, $yahoo_id, $gmail_id, $dept_name, $dept_email) {
    global $prefix, $db, $admin_file;
    $name = stripslashes(FixQuotes($name));
    $phone_num  = stripslashes(FixQuotes($phone_num));
    $fax_num    = stripslashes(FixQuotes($fax_num));
    $yahoo_id    = stripslashes(FixQuotes($yahoo_id));
    $gmail_id    = stripslashes(FixQuotes($gmail_id));
    $dept_name    = stripslashes(FixQuotes($dept_name));
    $dept_email    = stripslashes(FixQuotes($dept_email));
    $address    = stripslashes(FixQuotes($address));
    $showaddress    = stripslashes(FixQuotes($showaddress));
    $db->sql_query("insert into ".$prefix."_contact_us values (NULL,'$name','$phone_num', '$fax_num', '$yahoo_id', '$gmail_id', '$dept_name', '$dept_email', '$address', '$showaddress')");
    Header("Location: ".ADMIN_OP."contact#Default");
}
function contact_us_edit($pid) {
    global $prefix, $db, $admin_file;
    include("header.php");
    GraphicAdmin();
    menu();
    OpenTable();
    $result = $db->sql_query("select pid, name, phone_num, fax_num, yahoo_id, gmail_id, dept_name, dept_email  from ".$prefix."_contact_us where pid='$pid'");
    $pid        = intval($pid);
    $name       = stripslashes($name);
    $phone_num  = stripslashes($phone_num);
    $fax_num    = stripslashes($fax_num);
    $yahoo_id   = stripslashes($yahoo_id);
    $gmail_id   = stripslashes($gmail_id);
    $dept_name  = stripslashes($dept_name);
    $dept_email = stripslashes($dept_email);
    list($pid, $name, $phone_num, $fax_num, $yahoo_id, $gmail_id, $dept_name, $dept_email) = $db->sql_fetchrow($result);
    echo "<center><b>"._CONTACTEDIT."</b><br><br>";
    echo "<form action=\"".$admin_file.".php\" method=\"post\">";
    echo"<div dir='ltr' align=\"center\">
	<table border=\"0\" width=\"40%\">
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._NAME.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" name=\"name\" size=\"50\" value=\"$name\"></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._NSPHONENUM.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"phone_num\" size=\"50\" value=\"$phone_num\"></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._NSFAXNUM.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"fax_num\" size=\"50\" value=\"$fax_num\"></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._YAHOOID.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"yahoo_id\" size=\"50\" value=\"$yahoo_id\" id='yahoo'><label for=\"yahoo\"><font color=\"#FF0000\"><b>*</b></font>"._NOYAHOOCOM."</label></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._GMAILID.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"gmail_id\" size=\"50\" value=\"$gmail_id\" id='gmail'><label for=\"gmail\"><font color=\"#FF0000\"><b>*</b></font>"._WITHGMAILCOM."</label></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._DEPTNAME.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" name=\"dept_name\" size=\"50\" value=\"$dept_name\" id='dept'><label for=\"dept\"><font color=\"#FF0000\"><b>*</b></font>"._DEPTLABEL."</label></td>
		</tr>
		<tr>
			<td width=\"20%\">
			<p dir=\"rtl\">"._DEPTEMAIL.":</td>
			<td width=\"20%\">
			<p dir=\"rtl\" align=\"right\"><input type=\"text\" dir=\"ltr\" name=\"dept_email\" size=\"50\" value=\"$dept_email\" id='depte'><label for=\"depte\"><font color=\"#FF0000\"><b>*</b></font>"._DEPTLABEL."</label></td>
		</tr>
		</table></div>";
    echo "<input type=\"hidden\" name=\"pid\" value=\"$pid\">";
    echo "<input type=\"hidden\" name=\"op\" value=\"contact_us_modify\">";
    echo "<input type=\"submit\" value=\""._NSSAVE."\">";
    echo "</form></center>";
    echo "<br><br>";
    CloseTable();
    include("footer.php");
}
function contact_us_modify($pid, $name, $phone_num, $fax_num, $yahoo_id, $gmail_id, $dept_name, $dept_email) {
    global $prefix, $db, $admin_file;
    $name = stripslashes(FixQuotes($name));
    $phone_num  = stripslashes(FixQuotes($phone_num));
    $fax_num    = stripslashes(FixQuotes($fax_num));
    $db->sql_query("update ".$prefix."_contact_us set name='$name', phone_num='$phone_num', fax_num='$fax_num', yahoo_id='$yahoo_id', gmail_id='$gmail_id', dept_name='$dept_name', dept_email='$dept_email'  where pid='$pid'");
    Header("Location: ".ADMIN_OP."contact#Default");
}
function contact_us_delete($pid, $confirm = 0) {
    global $prefix, $db, $admin_file;
    if ($confirm == 1) {
    $db->sql_query("delete from ".$prefix."_contact_us where pid='$pid'");
    Header("Location: ".ADMIN_OP."contact#Default");
    } else {
    include("header.php");
    GraphicAdmin();
    menu();
    OpenTable();
        $result = $db->sql_query("select pid, name from ".$prefix."_contact_us where pid='$pid'");
        $pid        = intval($pid);
        $name = stripslashes($name);
    list($pid, $name) = $db->sql_fetchrow($result);
    echo "<center><br><br>";
    echo "<b>"._DELETECONTACT."</b><br><br>";
    echo ""._CONTACTDELSURE." <b>$name</b><br>";
    echo "<br><br>";
    echo "<input type=\"button\" value=\""._NSYES."\" title=\""._NSYES."\" onClick=\"window.location='".ADMIN_OP."contact_us_delete&amp;pid=$pid&amp;confirm=1'\">&nbsp;&nbsp;";
    echo "<input type=\"button\" value=\""._NSNO."\" title=\""._NSNO."\" onClick=\"window.location='".ADMIN_OP."contact#Default'\">";
    echo "</center><br><br>";
    CloseTable();
    include("footer.php");
    }
}
// [END]- USV -- Kralpc - Contact US -- 10/10/09-----
switch ($op) {

    case "contact":
    contact();
    break;

    case "showinfo":
    show_info($xshow_add,$address);
    break;

    case "Add_Contact_Address":
    Add_Contact_Address();
    break;

    case "Add_Contact_US":
    Add_Contact_US();
    break;

    case "contact_us_add":
    contact_us_add($name, $phone_num, $fax_num, $yahoo_id, $gmail_id, $dept_name, $dept_email, $address, $showaddress);
    break;

    case "contact_us_edit":
    contact_us_edit($pid);
    break;

    case "contact_us_modify":
    contact_us_modify($pid, $name, $phone_num, $fax_num, $yahoo_id, $gmail_id, $dept_name, $dept_email);
    break;

    case "contact_us_delete":
    contact_us_delete($pid, $confirm);
    break;
}

} else {
    echo "Access Denied";
}

?>