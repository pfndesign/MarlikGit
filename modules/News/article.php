<?php

/**
*
* @package News Module														
* @version $Id:  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

$module_name = basename(dirname(__FILE__));
require_once("mainfile.php");
require_once(MODULES_PATH."$module_name/functions.php");

define('RATING_IN', true);
define('TAGS_IN', true);


$optionbox = "";
get_lang($module_name);

$sid = sql_quote(intval($_GET['sid']));
$title = sql_quote($title);

if (empty($sid) AND empty($title) ) {
	show_error("ARTICLE YOU ARE REFERING IS TOTALY WRONG<br>empty SID or Title");
}


if ($save AND is_user($user)) {
	cookiedecode($user);
	getusrinfo($user);
	if(!isset($mode)) { $mode = $userinfo['umode']; }
	if(!isset($order)) { $order = $userinfo['uorder']; }
	if(!isset($thold)) { $thold = $userinfo['thold']; }
	$db->sql_query("UPDATE ".$user_prefix."_users SET umode='$mode', uorder='$order', thold='$thold' where uid='$cookie[0]'");
	getusrinfo($user);
	$info = base64_encode("$userinfo[user_id]:$userinfo[username]:$userinfo[user_password]:$userinfo[storynum]:$userinfo[umode]:$userinfo[uorder]:$userinfo[thold]:$userinfo[noscore]");
	setcookie("user","$info",time()+$cookieusrtime);
}

if ($op == "Reply") {
  $display = "";
  if(isset($mode)) { $display .= "&mode=".$mode; }
  if(isset($order)) { $display .= "&order=".$order; }
  if(isset($thold)) { $display .= "&thold=".$thold; }
  Header("Location: modules.php?name=$module_name&file=comments&op=Reply&pid=0&sid=".$sid.$display);
}
$ctime = date("Y-m-j H:i-1:s");
$result = $db->sql_query("select * FROM ".$prefix."_stories where sid='$sid'  OR title='$title' AND approved='1'  AND time <= '$ctime' AND  section='news' LIMIT 0,1")or die(mysql_error());
$numrows = $db->sql_numrows($result);
if (empty($numrows)) {
	show_error("ARTICLE ADDRESS YOU! ARE REFERING DOES NOT EXIST IN OUR DATABASE<br><br>[<b>$title</b><br>$sid</a>]");
}
$row = $db->sql_fetchrow($result);
$catid = intval($row['catid']);
$sid = intval($row['sid']);
$aaid = strip_tags($row['aid']);
$time = $row['time'];
$title = strip_tags($row['title']);
$hometext = stripslashes($row['hometext']);
$bodytext =stripslashes($row['bodytext']); 
$topic = strip_tags($row['topic']);
$informant = strip_tags($row['informant']);
$acomm = intval($row['acomm']);
$haspoll = intval($row['haspoll']);
$pollID = intval($row['pollID']);
$score = intval($row['score']);
$ratings = intval($row['ratings']);
$notes = stripslashes($row['notes']);

if (empty($aaid) AND empty($informant)) {
	show_error("ARTICLE YOU ARE REFERING DOES NOT HAVE ANY WRITER'S INFORMATION ");
}

$db->sql_query("UPDATE ".$prefix."_stories SET counter=counter+1 where sid='$sid'");

$artpage = 1;
$pagetitle = "- ".strip_tags($row['title'])."";
require("header.php");
$artpage = 0;

if (!empty($notes)) {
	$notes = "<br><br><b>"._NOTE."</b> <i>$notes</i>";
} else {
	$notes = "";
}

if(empty($bodytext)) {
	$bodytext = "$hometext";
} else {
	$bodytext = "$hometext<br><br>$bodytext";
}

if(empty($informant)) {
	$informant = $anonymous;
}

getTopics($sid);

if ($catid != 0) {
	$row2 = $db->sql_fetchrow($db->sql_query("select title from ".$prefix."_stories_cat where catid='$catid'"));
	$title1 = filter($row2['title'], "nohtml");
	$title = "<a href=\"modules.php?name=$module_name&amp;file=categories&amp;op=newindex&amp;catid=$catid\"><font class=\"storycat\">$title1</font></a>: $title";
}

$printpage = "modules.php?name=$module_name&amp;file=print&amp;sid=$sid";


define("hide_rside",true);
StoryInfo($sid);
themearticle($aaid, $informant, $time, $title, $bodytext, $topic, $topicname, $topicimage, $topictext, $printpage);

if ($multilingual == 1) {
	$querylang = "AND (blanguage='$currentlang' OR blanguage='')";
} else {
	$querylang = "";
}
 
/* Determine if the article has attached a poll */
if ($haspoll == 1) {
	$url = sprintf("modules.php?name=Surveys&amp;op=results&amp;pollID=%d", $pollID);
	$boxContent = "<form action=\"modules.php?name=Surveys\" method=\"post\">";
	$boxContent .= "<input type=\"hidden\" name=\"pollID\" value=\"".$pollID."\">";
	$row3 = $db->sql_fetchrow($db->sql_query("SELECT pollTitle, voters FROM ".$prefix."_poll_desc WHERE pollID='$pollID'"));
	$pollTitle = filter($row3['pollTitle'], "nohtml");
	$voters = $row3['voters'];
	$boxTitle = _ARTICLEPOLL;
	$boxContent .= "<font class=\"content\"><b>$pollTitle</b></font><br><br>\n";
	$boxContent .= "<table border=\"0\" width=\"100%\">";
	for($i = 1; $i <= 12; $i++) {
		$result4 = $db->sql_query("SELECT pollID, optionText, optionCount, voteID FROM ".$prefix."_poll_data WHERE (pollID='$pollID') AND (voteID='$i')");
		$row4 = $db->sql_fetchrow($result4);
		$numrows = $db->sql_numrows($result4);
		if($numrows != 0) {
			$optionText = $row4['optionText'];
			if(!empty($optionText)) {
				$boxContent .= "</td><input type=\"radio\" name=\"voteID\" value=\"".$i."\"></td><td width=\"100%\"><font class=\"content\">$optionText</font></td><td>\n";
			}
		}
	}
	$boxContent .= "</table><br><font class=\"content\"><input type=\"submit\" value=\""._VOTE."\"></font><br>";
	if (is_user($user)) {
		cookiedecode($user);
	}
	for($i = 0; $i < 12; $i++) {
		$row5 = $db->sql_fetchrow($db->sql_query("SELECT optionCount FROM ".$prefix."_poll_data WHERE (pollID='$pollID') AND (voteID='$i')"));
		$optionCount = $row5['optionCount'];
		$sum = (int)$sum+$optionCount;
	}
	$boxContent .= "<font class=\"content\">[ <a href=\"modules.php?name=Surveys&amp;op=results&amp;pollID=$pollID&amp;mode=".$userinfo['umode']."&amp;order=".$userinfo['uorder']."&amp;thold=".$userinfo['thold']."\"><b>"._RESULTS."</b></a> | <a href=\"modules.php?name=Surveys\"><b>"._POLLS."</b></a> ]<br>";

	if ($pollcomm) {
		$result6 = $db->sql_query("select * from ".$prefix."_pollcomments where pollID='$pollID'");
		$numcom = $db->sql_numrows($result6);
		$boxContent .= "<br>"._VOTES.": <b>$sum</b><br>"._PCOMMENTS." <b>$numcom</b>\n\n";
	} else {
		$boxContent .= "<br>"._VOTES." <b>$sum</b>\n\n";
	}
	$boxContent .= "</font></form>\n\n";
	themecenterbox($boxTitle, $boxContent);
}


render_blocks('c', 'block-BookMark.php', ''._RSSUSV_SHAREDLINKS.'', '', '', '');//sharing box


$optiontitle = ""._OPTIONS."";
$optionbox = "&nbsp;<img src='images/icon/printer.png' border='0' alt='"._PRINTER."' title='"._PRINTER."'> <a href=\"modules.php?name=$module_name&amp;file=print&amp;sid=$sid\">"._PRINTER."</a>";
$optionbox .= "&nbsp;<img src='images/icon/pdf.png' border='0' alt='"._PDF."' title='"._PDF."'> <a href=\"modules.php?name=$module_name&amp;file=pdf&amp;sid=$sid\">"._PDF."</a>";
if (is_user($user)) {
	$optionbox .= "&nbsp;<img src='images/icon/user.png' border='0' alt='"._FRIEND."' title='"._FRIEND."'> <a href=\"modules.php?name=$module_name&amp;file=friend&amp;op=FriendSend&amp;sid=$sid\">"._FRIEND."</a>";
}
$optionbox .= "<br>\n";
if (is_admin($admin)) {
	$optionbox .= "<b>"._ADMIN."</b><a href=\"".$admin_file.".php?op=adminStory\"><img src=\"images/add.gif\" alt=\""._ADD."\" title=\""._ADD."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=EditStory&sid=$sid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=RemoveStory&sid=$sid\"><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>";
}
themecenterbox($optiontitle,$optionbox);

$topicidarr = explode(",",$topicid);
$boxtitle = ""._RELATED."";
/*
$boxstuff = "<font class=\"content\">";
$result8 = $db->sql_query("select name, url from ".$prefix."_related where tid='$topic'");
while ($row8 = $db->sql_fetchrow($result8)) {
	$name = filter($row8['name'], "nohtml");
	$url = filter($row8['url'], "nohtml");
	$boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"$url\" target=\"new\">$name</a><br>\n";
}$topicid,$topicname,$topicimage,$topictext,$associated
*/

$boxstuff = "<div style='width:100%;text-align:".langStyle(align).";'>&nbsp;<a href=\"modules.php?name=Search&amp;topic=".$topicidarr[0]."\">"._MOREABOUT." ".$topicname."</a><br>\n";
$boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=Search&amp;author=$aaid\">"._NEWSBY." $aaid</a>\n";
$boxstuff .= "</font><br><hr noshade width=\"95%\" size=\"1\"><b>"._MOSTREAD." $topictext:".$topicidarr[0]."</b><br>\n";

global $multilingual, $currentlang, $admin_file, $user;
if ($multilingual == 1) {
	$querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
} else {
	$querylang = "";
}

$result = $db->sql_query("select sid, title,counter from ".$prefix."_stories where FIND_IN_SET(".$topicidarr[0].", REPLACE(associated, '-', ',')) AND approved='1' $querylang order by counter desc limit 0,10");
while ($row9 = $db->sql_fetchrow($result)) {
$topstory = intval($row9['sid']);
$ttitle = filter($row9['title'], "nohtml");
$boxstuff .= "<img src='images/icon/bullet_black.png'><a href=\"modules.php?name=$module_name&file=article&sid=$topstory&title=".Slugit($ttitle)."\">
$ttitle </a>
[".number_format($row9['counter'])."&nbsp; "._VISIT."]
<br>\n";
}
$boxstuff .= "</div>";
$db->sql_freeresult($result);
themecenterbox($boxtitle,$boxstuff);



if (((empty($mode) OR ($mode != "nocomments")) OR ($acomm == 0)) OR ($articlecomm == 1)) {
  include("modules/News/comments.php");
}

cookiedecode($user);
include ("footer.php");

?>