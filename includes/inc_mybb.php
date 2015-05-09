<?php
/**
*
* @package MYBB BRIDGE		= > Nukelearn Bridge											
* @version $Id: MYBB BRIDGE  11:49 AM 2/10/2012  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
//---//
// Hey fellas at copypasteourcode.ir :D  
// I did this job just to help you understand that how weak you are. 
// It's been a while that you are copying our codes and I haven't even bothered to mention it . 
// But now that I want to say good bye to this foolish open source society , my word to you is :
// happy copying and wish you a little bit dignity and manner .

global $db,$userinfo;
$mybb_prefix = 'mybb';
$nkln_prefix = 'nuke';
define("INSIDE_NKLN", true);
define('MYBBC_TO_NUKELEARN',0);
if(MYBBC_TO_NUKELEARN==1){
		
//=================================================================
// LETS REDIRECT ACTIONS
//=================================================================

// Make navigation

if($_REQUEST['name'] == "Your_Account"){
switch($_REQUEST['op'])
{

	case "new_user":
		Header("Location: ./forums/member.php?action=register");
		exit();
	break;
	case "userinfo":
		Header("Location: ./forums/usercp.php");	
		exit();
	break;
	case "edituser":
		Header("Location: ./forums/usercp.php?action=profile");	
		exit();
	break;
	case "login":
		Header("Location: ./forums/member.php?action=login");
		exit();
	break;
	case "logout":
		Header("Location: ./forums/member.php?action=logout&logoutkey=2cff5f7eedc9ca49d7288c752ac8a506");
		exit();

	break;
}
}

if($_REQUEST['stop'])
{
	Header("Location: ./forums/usercp.php");	
}

//===========================================
// LETS CHECK IF WE HAVE A USER LOGGED IN OUR CUSTEDY
//===========================================
$mybb_login = false;
$user_exists = false;

if ($_COOKIE['mybbuser']){
//check user from Nukelearn 
$NLB_user = $_COOKIE['mybbuser'];
$NLB_user = explode("_", $NLB_user);
$NLB_user_id = (int)$NLB_user[0];
$result=$db->sql_query("SELECT  `username`,`password`,`email`,`regdate`,`language` FROM ".$mybb_prefix."_users WHERE `uid`='".$NLB_user_id."' LIMIT 1");
list($NLB_user_nname,$NLB_user_pwd,$NLB_user_email,$NLB_regdate,$NLB_language)= $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$NLB_regdate = date("M d, Y",$NLB_regdate);


if(empty($userinfo['username'])){
if (!empty($NLB_user_id) AND !empty($NLB_user_pwd)) {
	$result = $db->sql_query("SELECT `user_id`,`username`,`user_email`,`user_password` FROM `".$nkln_prefix."_users` WHERE `username`='$NLB_user_nname' LIMIT 1") or die(mysql_error());
$nklnSwitch = $db->sql_fetchrow($result);
$user_exists=(!empty($nklnSwitch[0]) ? true : false); 
$db->sql_freeresult($result);
}
}else{
$user_exists=true; 
}

	$mybb_login=(!empty($NLB_user) ? true : false);
	//die("Dr.Feri  :$NLB_user_id $NLB_user_nname $NLB_user_pwd");
}else{
	//die("Dr.Feri we do not have mybb cookie ! =>".$_COOKIE['mybbuser']);
}
		

//=================================================================
// LETS CHECK IF WE HAVE A USER NOT REGISTERED IN OUR CUSTEDY
//=================================================================
if ($mybb_login==true){
if ($user_exists==true){
if(!empty($nklnSwitch[0]) AND !empty($nklnSwitch[1]) AND !empty($nklnSwitch[2])){
	// Now we know he is online !  lets make him legit by generating new user cookie :P
	$infouser = base64_encode("$nklnSwitch[0]:$nklnSwitch[1]:$nklnSwitch[3]::::::::" );
	setcookie('user', $infouser, time () + 36000 * 24 , '/');
	//hey man update Nukelearn user table
	/*
	$db->query("UPDATE `".$prefix."_users` SET `user_sig`='".$RUrow['signature']."',`user_avatar`='".$RUrow['avatar']."',`user_avatar_type`='3' WHERE username='".$RUrow['username']."'");
	*/
}
	//die("Dr.Feri->$nklnSwitch[0] $nklnSwitch[1] $nklnSwitch[3] ");
		
}else{
// now we have a user in mybb but not in Nukelearn , then no wait ! lets create it =->
	$lv = time();
	$result = $db->sql_query("INSERT INTO ".$prefix."_users (`name`, `username`, `user_email`, `user_avatar`, `user_regdate`, `user_viewemail`, `user_password`, `user_lang`, `user_lastvisit`) 
	VALUES ('".sql_quote($NLB_user_nname)."', '".sql_quote($NLB_user_nname)."', '".sql_quote($NLB_user_email)."', 'gallery/blank.gif', '".sql_quote($NLB_regdate)."', '0', '".sql_quote($NLB_user_pwd)."', '".sql_quote($NLB_language)."', '".sql_quote($lv)."')") or die("<div class='error'>اشکالی در پل ارتباطی نیوک لرن - مای بی بی وجود دارد<br>".mysql_error()."</div>");
	$db->sql_freeresult($result);
	
	$infouser = base64_encode ( "".mysql_insert_id().":$NLB_user_nname:$NLB_user_pwd:$setstorynum:$setumode:$setuorder:$setthold:$setnoscore:$setublockon:$settheme:$setcommentmax" );
	setcookie ( 'user', $infouser, time () + 36000 * 24 );
	
	Header("Location: index.php");	
}
}else{
	//die("mybb login is not found");
}
}else{
	//die("mybb bridge is not reveresed");
}

//End OF THIS STORY ... THIS IS NOTHING COMPARE TO OUR CODING POWER , BUT LETS FACE IT, CHANGE YOUR CHILDISH BEHAVIOUR.
?>