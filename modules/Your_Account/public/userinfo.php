<?php
/**
 *
 * @package userinfo														
 * @version $Id: 0999 2009-12-12 15:35:19Z Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike	
 *
 */
if (!defined('CNBYA')) {
	echo "CNBYA protection";
	exit;
}
define("blocks_show", false);
// NO side blocks
$username = sql_quote($_GET['username']);
$result   = $db->sql_query("SELECT * FROM " . $prefix . "_users WHERE username='$username' LIMIT 1");
$num      = $db->sql_numrows($result);
if ($num > 0) {
	$usrinfo = $db->sql_fetchrow($result);
	$result2 = $db->sql_query("SELECT * FROM " . $prefix . "_cnbya_field");
	while ($sqlvalue = $db->sql_fetchrow($result2)) {
		list($value) = $db->sql_fetchrow($db->sql_query("SELECT value FROM " . $prefix . "_cnbya_value WHERE fid ='$sqlvalue[fid]' AND uid = '" . $usrinfo['user_id'] . "'"));
		$usrinfo[$sqlvalue['name']] = $value;
	}
	$db->sql_freeresult($result2);
	if (!$bypass)
	        cookiedecode($user);
	global $admin_file, $admin, $userinfo, $module_name,$pagetitle, $aid;
	
	//-Owner of Your_Account
	$owner_username = sql_quote($_GET['username']);
	if (empty($owner_username)) {
		$owner_username = sql_quote($userinfo['username']);
	}
	$pagetitle = "" . _Viewing_profile_ . " $owner_username";//page title
	
	include("header.php");

	$username = sql_quote($userinfo['username']);
	//The user who is watching
	//-- Farshad : Why to redirect visitors to login or register page?  maybe its just a visit of a profile.
	if (!is_user(sql_quote($user))) {
		//Header("Location: modules.php?name=$module_name");
	}
	//-------- AVATAR and RANK-----------//
	$owner      = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".__USER_TABLE." WHERE  username='" . $owner_username . "' limit 1 "));
	//---essential  details
	$user_id    = sql_quote($owner['user_id']);
	$realname   = sql_quote($owner['name']);
	$user_email = sql_quote($owner['user_email']);
	$femail     = sql_quote($owner['femail']);
	//information about groups
	list($gname,$gcolor,$gid)=my_group($owner['username']);
	// check online status
	$qo         = $db->sql_numrows($db->sql_query("SELECT session_user_id  FROM " . $prefix . "_session WHERE session_user_id ='" . $usrinfo['user_id'] . "'"));
	if ($qo > 0) {
		$online = _ONLINE;
	} else {
		$online = _OFFLINE;
	}
	//extra details -- -- --- -- -- -
	$user_website          = sql_quote($owner['user_website']);
	$user_icq              = sql_quote($owner['user_icq']);
	$user_occ              = sql_quote($owner['user_occ']);
	$user_from             = sql_quote($owner['user_from']);
	$user_interests        = sql_quote($owner['user_interests']);
	$user_sig              = sql_quote($owner['user_sig']);
	$user_viewemail        = sql_quote($owner['user_viewemail']);
	$user_aim              = sql_quote($owner['user_aim']);
	$user_yim              = sql_quote($owner['user_yim']);
	$user_msnm             = sql_quote($owner['user_msnm']);
	$bio                   = sql_quote($owner['bio']);
	//-- Act it now ---
	$website_line          = ($user_website != "") ? "<a href='$user_website' title='Visit Website'><img src='" . USER_IMG_DIR . "icon_contact_www.gif' alt='WWW' border='0'  top='20px'></a>&nbsp;&nbsp;" : '';
	$aim_line              = ($user_aim != "") ? "<a href='aim:goim?screenname=$user_aim&amp;message=Hello+Are+you+there?' title=''><img src='" . USER_IMG_DIR . "icon_contact_aim.gif' alt='AIM Address' border='0' style='top:20px;'></a>&nbsp;&nbsp;" : "";
	$yim_line              = ($user_yim != "") ? "<a href='http://edit.yahoo.com/config/send_webmesg?.target=$user_yim&amp;.src=pg' title=''><img src='" . USER_IMG_DIR . "icon_contact_yahoo.gif' alt='Yahoo Address' top='20px'></a>&nbsp;&nbsp;" : "";
	$occ_line              = ($user_occ != "") ? "<strong>" . _OCCUPATION_ . "</strong> $user_occ<br />" : "";
	$from_line             = ($user_from != "") ? "<strong>" . _LOCATION_ . "</strong> $user_from<br />" : "";
	$interests_line        = ($user_interests != "") ? "<strong>" . _INTERESTS_ . "</strong> $user_interests<br />" : "";
	$bio_line              = ($bio != "") ? "<strong>" . _Bio . "</strong> " . nl2br($bio) . "<br />" : "";
	$newsletter            = sql_quote($owner['newsletter']);
	$user_posts            = sql_quote($owner['user_posts']);
	$user_rank             = sql_quote($owner['user_rank']);
	$user_level            = sql_quote($owner['user_level']);
	$user_active           = sql_quote($owner['user_active']);
	$user_session_time     = sql_quote($owner['user_session_time']);
	$user_session_page     = sql_quote($owner['user_session_page']);
	$last_ip               = sql_quote($owner['last_ip']);
	//--- Date Details
	$user_lastvisit        = sql_quote($owner['user_lastvisit']);
	$user_dateformat       = sql_quote($owner['user_dateformat']);
	$ulastvo               = date("Y-m-d H:i:s", sql_quote($owner['user_lastvisit']));
	$date_temp             = explode(" ", sql_quote($owner['user_regdate']));
	$date_temp[1]          = substr($date_temp[1], 0, 2);
	$date_temp[0]          = month_number($date_temp[0], 2);
	$owner['user_regdate'] = $date_temp[2] . "-" . $date_temp[0] . "-" . $date_temp[1];
	$regdateu              = hejridate(sql_quote($owner['user_regdate']), 1, 4);
	$lastvisitu            = ($user_lastvisit != 0) ? "<br><strong>" . _YA_LASTVISIT . "</strong> " . hejridate($ulastvo, 4, 7) . "<br />" : "";
	// get la
	/*-----------------------------------------*/
	if (!empty($owner["name"])) {
		$rname_1 = "<br>" . htmlspecialchars(sql_quote($owner["name"])) . "<br>";
	}
	//-------- Show Essential Details -----------//
	$U_info = "<div class='ucp_block_header'>"._INFO."</div><br>
" . _USERNAME . "	: <b>$owner_username</b> <br>
" . _REGDATE . " :<b>$regdateu</b> <br>
"._POINTS." : <b> " . $owner['points'] . "</b><br>
"._GROUP." :<span style='color:$gcolor'><b> " . langit($gname) . "</b></span><br>";
	if (is_active("phpBB3")) {
		$U_info .= "$show_rank<br>";
	}
	$U_info .= "$lastvisitu
$show_ex_info
";
	//----------AVATAR -------------
	if ($username == $owner_username) {
		$avatar_link = "<a href='modules.php?name=Your_Account&amp;op=edituser'><img src='" . avatar_me($owner_username) . "'></a>";
	} else {
		$avatar_link = "<img src='" . avatar_me($owner_username) . "' alt='avatar' class='frame'>";
	}
	$U_avatar = "<CENTER><div style='text-align:center;'>$avatar_link</div>
	<center><br>" . pullRating(3, $usrinfo['rate'], $usrinfo['rates_count'], $usrinfo['user_id'], true, true, true) . "</center><br>$online<br> $rname_1";
	if ($username == $owner_username) {
		$U_avatar .= '<a href="modules.php?name=Your_Account&amp;op=edituser">'._YA_EDIT.'</a>';
	}
	if (is_admin($admin)) {
		$U_avatar .= "<br><a href='modules.php?name=Your_Account&amp;op=edituser&amp;uname=$username'><font color='#FF0000'><strong>"._ADMIN.":"._EDIT.": $username</strong></font></a><br /></center>";
	}

	//----------RANK -------------
	$phpbb3row  = $db->sql_fetchrow($db->sql_query("SELECT user_rank FROM nuke_bb3users WHERE username='$owner_username' limit 1 "));
	$rank_id    = sql_quote($phpbb3row["user_rank"]);
	$phpbb3row2 = $db->sql_fetchrow($db->sql_query("SELECT rank_title,rank_image FROM nuke_bb3ranks WHERE rank_id='$rank_id' "));
	$rank_image = sql_quote($phpbb3row2["rank_image"]);
	$rank_title = sql_quote($phpbb3row2["rank_title"]);
	if (!empty($rank_title)) {
		$show_rank .= " "._RANK." :<br> <img src='" . PHPBB3_RANK_DIR . "$rank_image'><br><b>$rank_title</b><br>";
	}
	//Show Extra Details -------------
	if (!empty($website_line)) {
		$show_ex_info = "<br> "._INFO."  <br>
	$website_line 
	$aim_line 
	$yim_line 
	<br>";
	}
	$U_extinfo = "<div class='ucp_block_header'>"._YINTERESTS."</div><br>
<div style='background-color:#FFF; border:1px solid #94A3C4;height:50px; '>
$interests_line
$occ_line
$bio_line
</div>";
	if ($username == $owner_username) {
		$U_extinfo .= "<a href='modules.php?name=Your_Account&amp;op=edituser'>"._YA_EDIT."</a>";
	}
	if ($username = $owner_username) {
		$U_stat = "<div class='ucp_block_header'>آمار کاربری</div><br>
<strong>" . _POSTU . "</strong><br>  $user_posts<br />$post_info<br>";
	}
	echo "<h3 style='text-align:right;padding-right:40px;'>" . _Viewing_profile_ . "<span style='color:$gcolor;font-size:20px;'><b> " . $owner_username . "</b></span></h3>";
	echo "<center><table width='100%' align='center;'><tr>";
	//-------- sider for plugins -----------//
	echo "<td style='width:30%;vertical-align:top;padding:5px;'>";
	//Devider We need To make it more like FaceBook
	OpenTable();
	user_block($U_avatar);
	user_block($U_info);
	user_block($U_extinfo);
	//user_block($U_stat);
	//-------- Automatic File Inclusion FOR SIDER----------//
	if ((strtolower($usrinfo['username']) == strtolower($cookie[1])) AND ($usrinfo['user_password'] == $cookie[2])) {
		$sincsdir = dir("" . INCLUDES_UCP . "");
		while ($func = $sincsdir->read()) {
			if (substr($func, 0, 3) == "si-") {
				$sincslist .= "$func ";
			}
		}
		closedir($sincsdir->handle);
		$sincslist = explode(" ", $sincslist);
		sort($sincslist);
		for ($i = 0; $i < sizeof($sincslist); $i++) {
			if ($sincslist[$i] != "") {
				$counter = 0;
				include($sincsdir->path . "/$sincslist[$i]");
			}
		}
	}
	CloseTable();
	//-------- Main View -----------//
	echo "</td><td style='width:70%;vertical-align:top;padding:5px;'>";
	if ($userinfo['username'] == $owner_username) {
		OpenTable();
		nav(1);
		CloseTable();
	}
	// show account info only to the owner
	$incsdir = dir("" . INCLUDES_UCP . "");
	while ($func = $incsdir->read()) {
		if (substr($func, 0, 3) == "ui-") {
			$incslist .= "$func ";
		}
	}
	closedir($incsdir->handle);
	$incslist = explode(" ", $incslist);
	sort($incslist);
	for ($i = 0; $i < sizeof($incslist); $i++) {
		if ($incslist[$i] != "") {
			$counter = 0;
			include($incsdir->path . "/$incslist[$i]");
		}
	}
	echo "</td></tr></table></center>";
	$db->sql_freeresult($result);
	include("footer.php");
} else {
	Header("Location: modules.php?name=$module_name");
	show_error("<H4 style='text-align:center;color:red'>WRONG USERNAME SPECIFIED</H4> <br>$username");
}
?>