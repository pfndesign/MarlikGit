<?php 

/**
*
* @package acp														
* @version $Id: acp_dashboard.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

if (!defined('ADMIN_FILE')) {
	exit;
}

function create_first($name, $url, $email, $pwd, $user_new) {
	global $prefix, $db, $user_prefix, $Default_Theme;
	$first = $db->sql_numrows($db->sql_query("SELECT * FROM " . $prefix . "_authors"));
	if ($first == 0) {
		$pwd = htmlentities($pwd);
		$pwd = md5($pwd);
		$the_adm = "God";
		$email = validate($email);
		$db->sql_query("INSERT INTO " . $prefix . "_authors VALUES ('" . addslashes($name) . "', '" . sql_quote($the_adm) . "', '" . addslashes($url) . "', '" . addslashes($email) . "', '" . sql_quote($pwd) . "', '0', '1', '')");
		$user_regdate = date("M d, Y");
		$user_avatar = "gallery/blank.gif";
		$commentlimit = 4096;
		if ($url == "http://") {
			$url = "";
		}
		$db->sql_query("INSERT INTO " . $user_prefix . "_users (user_id, username, user_email, user_website, user_avatar, user_regdate, user_password, theme, commentmax, user_rank, user_level, user_lang, user_dateformat, user_level2) VALUES (NULL,'" . sql_quote($name) . "','" . sql_quote($email) . "','" . sql_quote($url) . "','" . sql_quote($user_avatar) . "','" . sql_quote($user_regdate) . "','" . sql_quote($pwd) . "','" . sql_quote($Default_Theme) . "','" . sql_quote($commentlimit) . "', '1', '2', 'persian','D M d, Y g:i a','9')");
		$phpbb3installed = $db->sql_numrows($db->sql_query("select group_id from ".$prefix."_bb3acl_groups"));
		if (!empty($phpbb3installed)) {
		$db->sql_query("UPDATE `".$prefix."_bb3users` SET `user_regdate`='".sql_quote($user_regdate)."' WHERE `user_id`=2 ");
		$db->sql_query("UPDATE `".$prefix."_bb3users` SET `username`='".sql_quote($name)."' WHERE `user_id`=2");
		$db->sql_query("UPDATE `".$prefix."_bb3users` SET `username_clean`='" . sql_quote($name) . "' WHERE `user_id`=2");
		$db->sql_query("UPDATE `".$prefix."_bb3users` SET `user_password`='".sql_quote($pwd)."' WHERE `user_id`=2 ");
		$db->sql_query("UPDATE `".$prefix."_bb3users` SET `user_email`='" . sql_quote($email) . "' WHERE `user_id`=2 ");
		$db->sql_query("UPDATE `".$prefix."_bb3forums` SET `forum_last_poster_name`='" . sql_quote($name) . "' WHERE `forum_id`=1 ");
		$db->sql_query("UPDATE `".$prefix."_bb3forums` SET `forum_last_poster_name`='" . sql_quote($name) . "' WHERE `forum_id`=2 ");
		$db->sql_query("UPDATE `".$prefix."_bb3topics` SET `topic_last_poster_name`='" . sql_quote($name) . "' WHERE `topic_id`=1 ");
		}
		
		login();
	}
}

//===========================================
//Admin login
//===========================================
function login() {
	global $gfx_chk, $admin_file,$sitename,$nukeurl;
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
	echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n";
	echo "<head>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";
	echo "<title>$sitename - "._ADMINLOGIN."</title>\n";
	admin_head();
	echo "</head>\n";
	echo "<body class='bglogin'>\n";
	echo "<div id='loginDiv'>\n";
	echo "<center><a href='http://www.nukelearn.com'><img src='".INCLUDES_ACP."style/images/nkln-logo.png'></a><center>";
	echo "<form  class='bgform' name='admin01' method='post' action='' . $admin_file . '.php'>\n";
	echo "<div class='adminbox'>\n";
	echo "<label style='text-align:".langstyle(align)."'>"._ADMINID."</labe><input type='text' name='aid' class='intxt'>";
	echo "<label style='text-align:".langstyle(align)."'>"._PASSWORD."</labe><input type='password'  name=\"pwd\" class='intxt'>";
	if (extension_loaded("gd") AND ($gfx_chk == 1 OR $gfx_chk == 5 OR $gfx_chk == 6 OR $gfx_chk == 7)) {
	echo show_captcha();
	}
	echo "<center><input type='submit' name='Submit' value='"._LOGIN."' class='adminlogin'></center>";
	echo "</div>";
	echo '<input type="hidden" name="op" value="login"  />';
	
	global $wrong_code;
	if($wrong_code){
	echo "<div class='error'>"._WRONG_CODE."</div>";
	}
	echo "</div>\n";

	echo "</form>\n";
	echo "</div>\n";
	echo "</body>\n";
	echo "</html>\n";

}
//===========================================
//Admin logout
//===========================================
function logout() {
	global $gfx_chk,$userinfo,$admin_file,$NK_session;
	setcookie("admin", false);
	setcookie("admin","",time()-31536000); //-1year
	$admin = null;
	header("Location: " . $admin_file . ".php");
}


function deleteNotice($id) {
	global $prefix, $db, $admin_file;
	$id = intval($id);
	$db->sql_query("DELETE FROM " . $prefix . "_reviews_add WHERE id = '".sql_quote($id)."'");
	Header("Location: " . $admin_file . ".php?op=reviews");
}
//===========================================
//Administration Menu
//===========================================
function adminmenu($url, $title, $image) {
	global $counter, $admingraphic, $Default_Theme;
	$ThemeSel = get_theme();
	if (file_exists("themes/$ThemeSel/images/admin/$image")) {
		$image = "themes/$ThemeSel/images/admin/$image";
	}
	else {
		$image = "images/admin/$image";
	}
	if ($admingraphic == 1) {
		$img = "<img src=\"$image\" border=\"0\" alt=\"$title\" title=\"$title\">";
	}
	else {
		$img = "";
	}
	echo "<td align=\"center\" valign=\"top\" width=\"16%\"><font class=\"content\"><a href=\"$url\">$img<b><br />$title</b></a><br><br></font></td>";
	if ($counter == 5) {
		echo "</tr><tr>";
		$counter = 0;
	}
	else {
		$counter++;
	}
}

//===========================================
//Administration Main Function
//===========================================
function adminMain() {
	global $admin;
	include ("header.php");
	ADMIN_PANE();
	ADMIN_NOTIFICATIONS();
	include ("footer.php");
}



//===========================================
//RAW Switch OPS
//===========================================
//-- Escaping SQL Injections -- -
$aid = sql_quote($aid);
$pwd = sql_quote($pwd);
//-------------------------------

$checkurl = $_SERVER['REQUEST_URI'];
if ((stripos_clone($checkurl, 'AddAuthor')) OR (stripos_clone($checkurl, 'VXBkYXRlQXV0aG9y')) OR (stripos_clone($checkurl, 'QWRkQXV0aG9y')) OR (stripos_clone($checkurl, 'UpdateAuthor')) OR (stripos_clone($checkurl, "?admin")) OR (stripos_clone($checkurl, "&admin"))) {
	die("Illegal Operation");
}


get_lang("admin");
global $admin_file,$db,$prefix;
$admin_exists = $db->sql_numrows($db->sql_query("SELECT aid FROM ".$prefix."_authors"));
if (!$admin_exists > 0) {
		//include ("header.php");
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
		echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n";
		echo "<head>\n";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";
		echo "<title>$sitename - "._ADMINLOGIN."</title>\n";
		admin_head();
		echo "</head>\n";
		echo "<body style='direction:".langstyle("direction")."';text-align:".langstyle("align")."';>\n";

	?>
	<div class="head_1"><img src="includes/acp/style/images/admin_logo.png" border="0" alt="<?php echo $sitename ?>" title="<?php echo $sitename ?>"></div>
	<div class="head_2" style="margin-bottom:20px;"><a href="<?php echo $nukeurl ?>" ><img src="images/icon/house.png"><?php echo $sitename ?></a></div>
	<?php		
	echo '<table align="center" cellpadding="0" cellspacing="0" style="width: 600px;border:1px solid #ccc; padding:5px; height: 1px"><tr>
<td style="height: 54px;background:#F5F5F5" valign="top">';
	echo "<h3 style='text-align:right'>$sitename - "._ADMINLOGIN."</h3>\n";
	echo '</td></tr><tr><td><br><br>';
	echo "<b>" . _NOADMINYET . "</b>
				<form action=\"" . sql_quote($admin_file) . ".php\" name=\"createfirst\" method=\"post\">
				<table border=\"0\" width='100%'><tr><td><b>" . _NICKNAME . ":</b></td>
				<td><input type=\"text\" dir=\"ltr\" name=\"name\" size=\"30\" maxlength=\"25\"></td></tr>
				<tr><td><b>" . _HOMEPAGE . ":</b></td><td><input type=\"text\" dir=\"ltr\" name=\"url\" size=\"30\" maxlength=\"255\" value=\"http://\"></td></tr>
				<tr><td><b>" . _EMAIL . ":</b></td><td><input type=\"text\" dir=\"ltr\" name=\"email\" size=\"30\" maxlength=\"255\"></td></tr>
				<tr><td><b>" . _PASSWORD . ":</b></td><td><input type=\"password\" dir=\"ltr\" name=\"pwd\" size=\"11\" maxlength=\"40\"></td></tr>
				<tr><td>&nbsp;</td><td>" . _TERMSCONT . "</td></tr>
				<tr><td><b>" . _TERMSA . ":</b></td><td><INPUT onclick=Disab(); type=checkbox CHECKED name=term> " . _TERMSAC . "</td></tr>
				<tr><td></td><td><input type=\"hidden\" name=\"fop\" value=\"create_first\">
				<input type=\"submit\" name=\"Submit\" value=\"" . _SUBMIT . "\">
				</td></tr></table></form>";	
	echo '</td></tr></table>';
	echo "</body>\n";
	echo "</html>\n";


	switch ($fop) {
		case "create_first" :
			create_first($name, $url, $email, $pwd, $user_new);
			break;
	}
	die();
}





if (isset ($aid) && (str_replace('[^a-zA-Z0-9@_.]', trim($aid),''))) {
	header('Location: ' . $admin_file . '.php');
	die();
}
if (isset ($aid)) {
	$aid = substr($aid, 0, 25);
}
if (isset ($pwd)) {
	$pwd = substr($pwd, 0, 40);
}


if ((isset($aid)) && (isset($pwd)) && (isset($op)) && ($op == "login")) {
	if (extension_loaded("gd") AND !check_captcha() AND ($gfx_chk == 1 OR $gfx_chk == 5 OR $gfx_chk == 6 OR $gfx_chk == 7)) {
		$wrong_code = true;
		login();
		die();
		unset($op);
	}




	$datekey = date("F j");


	if (!empty ($aid) AND !empty ($pwd)) {
		$pwd = md5($pwd);
		$result = $db->sql_query('SELECT pwd, admlanguage FROM ' . $prefix . '_authors WHERE aid=\'' . sql_quote($aid) . '\'');
		list($rpwd, $admlanguage) = $db->sql_fetchrow($result);
		$admlanguage = addslashes($admlanguage);
		if ($rpwd == $pwd) {
			$admin = base64_encode("$aid:$pwd:$admlanguage");
			setcookie('admin', $admin, time() + 3600*24);
			unset ($op);
		}
	}
}
$admintest = 0;
if (isset ($admin) && !empty ($admin)) {
	$admin = addslashes(base64_decode($admin));
	$admin = explode(':', $admin);
	$aid = addslashes($admin[0]);
	$pwd = $admin[1];
	$admlanguage = $admin[2];
	if (empty ($aid) OR empty ($pwd)) {
		$admintest = 0;
		$alert = '<html>' . "\n";
		$alert .= '<title>' . _A_INTRUDER_MSG . '</title>' . "\n";
		$alert .= '<body bgcolor="#FFFFFF" text="#000000">' . "\n\n" . '<br /><br /><br />' . "\n\n";
		$alert .= '<center><img src="images/eyes.gif" border="0" /><br /><br />' . "\n";
		$alert .= '<font face="Verdana" size="+4"><b>' . _A_GETOUT . '</b></font></center>' . "\n";
		$alert .= '</body>' . "\n";
		$alert .= '</html>' . "\n";
		die($alert);
	}
	$aid = substr("$aid", 0, 25);
	$result2 = $db->sql_query('SELECT name, pwd FROM ' . $prefix . '_authors WHERE aid=\'' . sql_quote($aid) . '\'');
	if (!$result2) {
		die('Selection from database failed!');
	}
	else {
		list($rname, $rpwd) = $db->sql_fetchrow($result2);
		if ($rpwd == $pwd && !empty ($rpwd)) {
			$admintest = 1;
		}
	}
}
$ops = array('ADMIN_INFO','GraphicAdminM','ADMIN_PANE', 'mod_authors', 'modifyadmin', 'UpdateAuthor', 'AddAuthor', 'deladmin2', 'deladmin', 'assignstories', 'deladminconf');

if(!isset($op)) {
	$op = "adminMain";
} elseif(($op=="AddAuthor" OR $op=="deladmin2" OR $op=="deladmin" OR $op=="assignstories" OR $op=="deladminconf") AND ($rname != "God")) {
	die("Illegal Operation");
}
$pagetitle = '- ' . _ADMINMENU;

?>