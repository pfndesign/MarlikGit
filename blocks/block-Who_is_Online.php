<?php

/**
*
* @package Who is Online and where												
* @version $Id:  1:00 PM 5/29/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
*
*/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $user, $cookie, $prefix, $db, $user_prefix;

cookiedecode($user);
if (isset($_SERVER['REMOTE_ADDR'])) { $ip = $_SERVER['REMOTE_ADDR']; }
if (is_user($user))
{
    $uname = $cookie[1];
    $guest = 0;
}
else
{
    if (!empty($ip)) { 
      $uname = $ip; 
    } else {
      $uname = "";
    }
    $guest = 1;
}

$guest_online_sql = "SELECT * FROM ".$prefix."_session WHERE session_user_id !='0'";
$guest_online_query = $db->sql_query($guest_online_sql);
$guest_online_num = $db->sql_numrows($guest_online_query);

$member_online_sql = "SELECT * FROM ".$prefix."_session WHERE session_user_id ='0'";
$member_online_query = $db->sql_query($member_online_sql);
$member_online_num = $db->sql_numrows($member_online_query);

$who_online_num = $guest_online_num + $member_online_num;
$who_online = "<div align=\"center\"><span class=\"content\">"._CURRENTLY." $guest_online_num "._GUESTS." $member_online_num "._MEMBERS."<br>";

$content = $who_online;

if (is_user($user)) {
    if (is_active("Private_Messages")) {
        $sql = "SELECT user_id FROM ".$user_prefix."_users WHERE username='$uname'";
        $query = $db->sql_query($sql);
	list($user_id) = $db->sql_fetchrow($query);
	$uid = intval($user_id);
	$sql = "SELECT * FROM ".$prefix."_bbprivmsgs WHERE privmsgs_to_userid='$uid' AND (privmsgs_type='5' OR privmsgs_type='1')";
	$query = $db->sql_query($sql);
	$newpm = $db->sql_numrows($query);
    }
}

$sql2 = "SELECT title FROM ".$prefix."_blocks WHERE bkey='online'";
$query2 = $db->sql_query($sql2);
list($title) = $db->sql_fetchrow($query2);
$title = check_html($title, "nohtml");
if (is_user($user)) {
    $content .= "<br>"._YOUARELOGGED." <b>$uname</b>.<br>";
    if (is_active("Private_Messages")) {
        $sql = "SELECT user_id FROM ".$user_prefix."_users WHERE username='$uname'";
        $query = $db->sql_query($sql);
	list($user_id) = $db->sql_fetchrow($query);
	$uid = intval($user_id);
	$sql = "SELECT privmsgs_to_userid FROM ".$prefix."_bbprivmsgs WHERE privmsgs_to_userid='$uid' AND (privmsgs_type='1' OR privmsgs_type='5' OR privmsgs_type='0')";
	$query = $db->sql_query($sql);
	$numrow = $db->sql_numrows($query);
	$content .= ""._YOUHAVE." <a href=\"modules.php?name=Private_Messages\"><b>$numrow</b></a> "._PRIVATEMSG."";
    }
    $content .= "</span></div>";
} else {
    $content .= "<br>"._YOUAREANON."</span></div>";
}

?>