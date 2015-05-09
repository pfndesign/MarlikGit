<?php

/**
*
* @package NukeNAV														
* @version $Id: 0999 $						
* @copyright (c)Marlik Group  http://www.nukelearn.com											
* @copyright (c)http://nukeseo.com												
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(!defined('MODULE_FILE')) {
	header('Location: ../../index.php');
	die();
}

global $admin_file;
define('MODAL', true);
if(!isset($admin_file)) $admin_file = 'admin';
if(!isset($module_file)) $module_file='modules';
$module_name = basename(dirname(__FILE__));
function navHead(){
	return '
	<!DOCTYPE html> 
	<html dir="ltr" lang="en-US"> 
	<head> 
	<meta charset="UTF-8" /> 
	<META NAME=”ROBOTS” CONTENT=”NOINDEX, FOLLOW”>
	</head>
	<body>';

}
function navFoot(){
	return '</body> </html>';
}
function nukeNAVlogin() {
	// Copied from /blocks/block-Login.php
	global $admin, $user, $sitekey, $gfx_chk, $admin_file, $ya_config;
	include_once('modules/Your_Account/includes/functions.php');
	if (!isset($ya_config)) $ya_config = ya_get_configs();

	$showUserInfo = navHead();
	$showUserInfo .= "<form method='post' action='modules.php?name=Your_Account'>\n"
	."<div style='direction:".langStyle('direction').";text-align:".langStyle('align').";width:200px;height:200px;margin:0px auto;padding:10px;'>\n"
	."<div>"._NICKNAME."<br><input type='text' name='username' ></div><br>"
	."<div>"._PASSWORD."<br><input type='password'  name=\"user_password\" class='intxt'></div>";

	if (extension_loaded("gd") AND ($gfx_chk == 2 OR $gfx_chk == 5 OR $gfx_chk == 7)) {
		$showUserInfo .="<div>".show_captcha()."</div>";
	}

	$showUserInfo .='<br><input id="login_submit" type="submit" alt="login" value="'._LOGIN.'" /></font>'
	."</div>\n"
	.'<input type="hidden" name="op" value="login" />'
	."</form>\n";
	
	$showUserInfo .= navFoot();
	
	return $showUserInfo;


}
function nukeNAVsearch() {
	// Enhanced from /blocks/block-Search.php
	$content = navHead();
	$content .= '<form onsubmit="this.submit.disabled=\'true\'" action="modules.php?name=Search" method="post">';
	$content .= '<br /><center><input type="text" name="query" size="40" />';
	$content .= '&nbsp;<input id="submit" type="submit" value="'._SEARCH.'" /></center><br /></form>';
	$content .= navFoot();
	
	return $content;
}
function nukeNAVAccount($value) {
	global $admin_file, $db,$prefix,$admin ,$userinfo,$module_name,$aid;
	/**
*
* @package userinfo														
* @version $Id: 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
	///Getting USER ID SENT BY A REQUEST AND QUERY IF IT EXISTS--
	$value = (!empty($value)) ? $value : sql_quote($_GET['value']);
	$result  = $db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$value' LIMIT 1");
	$num     = $db->sql_numrows($result);
	//MAIN WINDOW FOR SHOWING USER INFO ---
	$showUserInfo = navHead();
	
	$showUserInfo .='
	<style type="text/css">
	.userinfoBox{
	background-color:#81CEDB;color:#00046E;direction:'.langStyle(direction).';text-align:'.langStyle(align).';padding:10px;border:1px solid #ccc;min-height:200px;min-width:400px;overflow-y:hidden;overflow-x:hidden;
	}
	.userinfoBox a:link,a:active,a:visited,{
	color:#003DF6;
	}
	</style>';
	
	$showUserInfo .= "<div class='userinfoBox'>\n";

	//IF ONLY USER EXISTS ---
	if ($num > 0 ) {

		require_once("includes/mods/rating/inc_ratings.php");

		$usrinfo = $db->sql_fetchrow($result);

		$result = $db->sql_query("SELECT * FROM ".$prefix."_cnbya_field");
		while ($sqlvalue = $db->sql_fetchrow($result)) {
			list($value) = $db->sql_fetchrow( $db->sql_query("SELECT value FROM ".$prefix."_cnbya_value WHERE fid ='$sqlvalue[fid]' AND uid = '".$usrinfo['user_id']."'"));
			$usrinfo[$sqlvalue['name']] = $value;
		}

		$owner_username = sql_quote($usrinfo['username']);//-Owner of Your_Account
		$username = sql_quote($userinfo['username']);//-who is watching

		$U_info = "<h3>
		 <a rel='nofollow' href='modules.php?name=Your_Account&op=userinfo&username=$owner_username'><img src='images/icon/tick.png'>"._Viewing_profile_. "</a> ";
		if ($username == $owner_username) {
			$U_info .= "<a  rel='nofollow' href='modules.php?name=Your_Account&amp;op=edituser'><img src='images/icon/user_edit.png'>"._EDIT."</a>";
		}
		$U_info .= "</h3>";

		//-------- AVATAR and RANK-----------//
		//fetching user's AVATAR and RANK : not so simple babe :
		
		$owner = $db->sql_fetchrow( $db->sql_query("SELECT * FROM ".$prefix."_users WHERE  username='".$owner_username."' limit 1 "));

		//---essential  details
		$user_id = sql_quote($owner['user_id']);
		$realname = sql_quote($owner['name']);
		$user_email = sql_quote($owner['user_email']);
		$femail = sql_quote($owner['femail']);

		// check online status
		$qo = $db->sql_numrows($db->sql_query("SELECT session_user_id  FROM ".$prefix."_session WHERE session_user_id ='".$usrinfo['user_id']."'"));

		if ($qo > 0) {
			$online = "<span style='color:green'><img src='images/icon/user_green.png'>"._ONLINE."</span>";
		} else {
			$online = "<span style='color:red'><img src='images/icon/user_red.png'>"._OFFLINE."</span>";

		}
		//extra details -- -- --- -- -- -
		$user_website =  sql_quote($owner['user_website']);
		$user_icq =  sql_quote($owner['user_icq']);
		$user_occ =  sql_quote($owner['user_occ']);
		$user_from =  sql_quote($owner['user_from']);
		$user_interests =  sql_quote($owner['user_interests']);
		$user_sig =  sql_quote($owner['user_sig']);
		$user_viewemail =  sql_quote($owner['user_viewemail']);
		$user_aim =  sql_quote($owner['user_aim']);
		$user_yim =  sql_quote($owner['user_yim']);
		$user_msnm =  sql_quote($owner['user_msnm']);
		$bio = sql_quote($owner['bio']);
		//-- Act it now ---
		$website_line = ($user_website != "") ? "<a href='$user_website' title='Visit Website'><img src='".USER_IMG_DIR."icon_contact_www.gif' alt='WWW' border='0'  top='20px'></a>&nbsp;&nbsp;" : '';
		$aim_line = ($user_aim != "") ? "<a href='aim:goim?screenname=$user_aim&amp;message=Hello+Are+you+there?' title=''><img src='".USER_IMG_DIR."icon_contact_aim.gif' alt='AIM Address' border='0' style='top:20px;'></a>&nbsp;&nbsp;" : "";
		$yim_line = ($user_yim != "") ? "<a href='http://edit.yahoo.com/config/send_webmesg?.target=$user_yim&amp;.src=pg' title=''><img src='".USER_IMG_DIR."icon_contact_yahoo.gif' alt='Yahoo Address' top='20px'></a>&nbsp;&nbsp;" : "";
		$occ_line = ($user_occ != "") ? ""._OCCUPATION_." $user_occ<br />" : "";
		$from_line = ($user_from != "") ? ""._LOCATION_." $user_from<br />" : "";
		$interests_line = ($user_interests != "") ? ""._INTERESTS_." $user_interests<br />" : "";
		$bio_line = (empty($bio)) ? "".nl2br($bio)."<br />" : "";
		$newsletter = sql_quote($owner['newsletter']);
		$user_posts = sql_quote($owner['user_posts']);
		$user_rank = sql_quote($owner['user_rank']);
		$user_level = sql_quote($owner['user_level']);
		$user_active = sql_quote($owner['user_active']);
		$user_session_time = sql_quote($owner['user_session_time']);
		$user_session_page = sql_quote($owner['user_session_page']);
		$last_ip = sql_quote($owner['last_ip']);
     	//--- Date Details
		$user_lastvisit = sql_quote($owner['user_lastvisit']);
		$user_dateformat = sql_quote($owner['user_dateformat']);
		$ulastvo = date("Y-m-d H:i:s", sql_quote($owner['user_lastvisit']));
		$date_temp = explode(" ", sql_quote($owner['user_regdate']));
		$date_temp[1] = substr($date_temp[1], 0, 2);
		$date_temp[0] = month_number($date_temp[0], 2);
		$owner['user_regdate'] = $date_temp[2] . "-" . $date_temp[0] . "-" . $date_temp[1];
		$regdateu = hejridate(sql_quote($owner['user_regdate']), 1, 4);
		$lastvisitu = ($user_lastvisit != 0) ? "<br><img src='images/icon/time.png'>"._YA_LASTVISIT." ".hejridate($ulastvo, 4, 7)."<br />" : "";// get la

		/*-----------------------------------------*/
		if (!empty($owner["name"])) {$rname_1 = "<br>".htmlspecialchars(sql_quote($owner["name"]))."<br>";}
		//-------- Show Essential Details -----------//

		$U_info .= "
<img src='images/icon/status_online.png'>"._USERNAME." : $owner_username <br>
<img src='images/icon/time.png'>"._REGDATE." :$regdateu <br>
<img src='images/icon/thumb_up.png'>"._POINTS.": <b>".my_points($owner_username)."</b><br>";

		//-rank ?!
		if (is_active("phpBB3")) {
			$U_info .= "$show_rank<br>";
		}
		
		//--last visit--
		$U_info .= "$lastvisitu $show_ex_info";
		
		//----------AVATAR -------------
		if ($username == $owner_username) {
			$avatar_link ="<a href='modules.php?name=Your_Account&op=edituser'>
			<img src='".avatar_me($owner_username)."' style='width:128px;height:128px;border:2px solid #f0f0f0;padding:5px;'></a>";
		}else {
			$avatar_link ="<img src='".avatar_me($owner_username)."'>";
		}

		//====Compose PM ----- 
		$U_avatar = "<div style='text-align:center;'>$avatar_link</div>
		<center><br>".  pullRating(3, $owner['rate'], $owner['rates_count'], $owner['user_id'],false,false,false)."<br>$online<br>$PM<br></center>";

		//----------RANK -------------!!

		//Show Extra Details -------------
		if (!empty($website_line)) {
			$show_ex_info = "<br> "._OTHER." : <br>
	$website_line 
	$aim_line 
	$yim_line 
	<br>";
		}

		$U_extinfo = "<div class='ucp_block_header'>"._DESCRIPTION."</div><br>
<div style='background-color:#FFF;color:#000; border:1px solid #94A3C4;height:60px;width:300px; '>
$interests_line
$occ_line
$bio_line
</div>";

		if ($username = $owner_username) {
			$U_stat = "<div class='ucp_block_header'>"._USERINFO."</div><br>
"._POSTU."<br>  $user_posts<br />$post_info<br>";
		}

		$showUserInfo .= "<table><tr><td width='70%'>
		<div style='float:".langStyle(direction).";text-align:".langStyle(direction).";position:relative;'>$U_info<hr>$U_extinfo</div></td>\n"
		."<td width='30%'><div>$U_avatar</div></td></tr></table>\n";


		//user_block($U_stat);

	}else {
		$showUserInfo=''._USERNOTEXISTS.'<br><br><b>'.$value.'</b>';
	}
	$showUserInfo .= "</div>\n";


	$showUserInfo .=navFoot();	
	return $showUserInfo;
}


// Popups that don't require JS or CSS go here

if(!$_GET['op']){

	header ("Location: index.php");

}

else{

	switch($_GET['op']){
		case 'login':
			echo nukeNAVlogin();
			break;

		case
		'search':
		echo nukeNAVsearch();
		break;

		case 'Account':
			echo nukeNAVAccount($value);
			break;

	}
}

?>