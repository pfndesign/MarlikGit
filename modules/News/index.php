<?php

/**
*
* @package News Module	- index file												
* @version $Id:  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

define('INDEX_FILE', true);
define('RATING_IN', true);
define('TAGS_IN', true);

$module_name = basename(dirname(__FILE__));
require_once("mainfile.php");
require_once(MODULES_PATH."$module_name/functions.php");
require_once(MODULES_PATH."$module_name/class.posts.php");
get_lang($module_name);
//====== PAGE TITLE =====================
global $pagetitle;

function theindex($new_topic="0") {
	global $db,$nk_post,$pagetitle, $pagenum, $storyhome, $user, $prefix, $multilingual, $currentlang, $articlecomm, $sitename, $userinfo,$nextg;
	
	if (!empty($pagenum)) {
		$pagetitle = _CONTENT."-"._CURRENT_PAGE."- $pagenum";
	}


	include("header.php");
	//automated_news();

	$nk_post = new nk_posts();
	$ctime		= date("Y-m-j H:i:s");
	//--Conditions -------------//

	if (is_user($user)) { getusrinfo($user); }

	$querylang =  $multilingual == 1 ? "AND (alanguage='$currentlang' OR alanguage='') AND approved='1'" : "AND approved='1'" ;

	$new_topic = isset($new_topic) ? intval($new_topic) : $new_topic == 0;

	if ($new_topic == 0) {
		$qdb = "WHERE (ihome='0' OR catid='0')  $querylang and time <= '$ctime'  AND  section='news' AND approved='1' AND title!='draft'";
		$home_msg = "";
	} else {
		//--Show Topics -------------//
		$qdb = "WHERE topic='".sql_quote($new_topic)."'  $querylang  and time <= '$ctime'  AND  section='news' AND approved='1' AND title!='draft'";

		list($topic_title)=$db->sql_fetchrow($db->sql_query("SELECT topictext FROM ".$prefix."_topics WHERE topicid='".sql_quote($new_topic)."' "));

		OpenTable();
		if ($topic_title) {
			echo "<center><font class=\"title\">$sitename</font><br><br>"._NOINFO4TOPIC."<br><br>[ <a href=\"modules.php?name=News\">"._GOTONEWSINDEX."</a> | <a href=\"modules.php?name=Topics\">"._SELECTNEWTOPIC."</a> ]</center>";
		} else {
			$db->sql_query("UPDATE ".$prefix."_topics SET counter=counter+1");
			echo "<center><font class=\"title\">$sitename: $topic_title</font><br><br>"
			."<form action=\"modules.php?name=Search\" method=\"post\">"
			."<input type=\"hidden\" name=\"topic\" value=\"$new_topic\">"
			.""._SEARCHONTOPIC.": <input type=\"name\" name=\"query\" size=\"30\">&nbsp;&nbsp;"
			."<input type=\"submit\" value=\""._SEARCH."\">"
			."</form>"
			."[ <a href=\"index.php\">"._GOTOHOME."</a> | <a href=\"modules.php?name=Topics\">"._SELECTNEWTOPIC."</a> ]</center>";
		}
		CloseTable();
		echo "<br>";
	}

	if (empty($pagenum)) { $pagenum = 1 ; }
	$offset = ($pagenum-1) * $storyhome ;
	

//===========================================
// BenchMARK SYSTEM
//===========================================
$istart = benchGetTime();
	//--- Begin OO Posts ------
	$nk_post->_data($offset,$pagenum,$storyhome,$querylang,$qdb);
	$nk_post->_pagination(4);
	//------------------------
$iend = benchGetTime();
if (BENCHMARK==true) {
echo benchmark_overall($istart,$iend,_CONTENT);	
}
	
//-------------------------
	
include("footer.php");
}
function thanks() {
	include("header.php");
	global $prefix, $module_name, $user,$admin;
	OpenTable();
	echo "<center><img src='images/icon/accept.png' height='16px' width='16px'>"._THANKS_COMMENT."</center>";
	CloseTable();

	include("footer.php");
}
function moderation_mod_comments_view($id) {
	global $prefix, $db, $admin_file;
	include ("header.php");
	GraphicAdmin();
	mod_menu();
	OpenTable();

	$comm = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_comments_moderated WHERE tid=".intval(sql_quote($id))));
	$comm['name'] = check_html($comm['name'], "nohtml");
	$comm['subject'] = check_html($comm['subject'], "nohtml");
	$comm['comment'] = check_html($comm['comment'], "");
	$news = $db->sql_fetchrow($db->sql_query("SELECT title, hometext, bodytext, topic FROM ".STORY_TABLE." WHERE sid=".intval(sql_quote($comm['sid']))));
	$news['title'] = check_html($news['title'], "nohtml");
	$news['hometext'] = check_html($news['hometext'], "");
	$news['bodytext'] = check_html($news['bodytext'], "");
	$topic = $db->sql_fetchrow($db->sql_query("SELECT topicimage FROM ".$prefix."_topics WHERE topicid=".intval($news['topic'])));
	if ($comm['pid'] != 0) {
		$reply = $db->sql_fetchrow($db->sql_query("SELECT name, subject, comment FROM ".$prefix."_comments_moderated WHERE tid=".intval(sql_quote($comm['pid']))));
		$reply['name'] = check_html($reply['name'], "nohtml");
		$reply['subject'] = check_html($reply['subject'], "nohtml");
		$reply['comment'] = check_html($reply['comment'], "");
	} else {
		$reply = "";
	}
	echo "<center><b>"._ORIGINALARTICLE."</b></center><br>";
	OpenTable2();
	echo "<img src=\"images/topics/".$topic['topicimage']."\" border=\"0\" align=\"right\">";
	themepreview($news['title'], $news['hometext'], $news['bodytext']);
	CloseTable2();
	if (!empty($reply)) {
		echo "<br><br><center><b>"._INREPLYTO."</b></center><br>";
		OpenTable2();
		echo "<b>".$reply['subject']."</b><br>"._BY." ".$reply['name']."<br><br>".$reply['comment']."";
		CloseTable2();
	}
	echo "<br><br><center><b>"._COMMENTAPPPENDING."</b></center><br>";
	OpenTable2();
	echo "<b>".$comm['subject']."</b><br>"._BY." ".$comm['name']."<br><br>".$comm['comment']."<br><br>";
	echo "<center><hr size=\"1\" width=\"80%\"><a href=\"".$admin_file.".php?op=moderation_approval&section=news&id=$id\"><img src=\"images/moral/approve.gif\" alt=\""._APPROVE."\" title=\""._APPROVE."\" width=\"15\" heigh=\"15\" border=\"0\"></a> &nbsp; <a href=\"".$admin_file.".php?op=moderation_reject&section=news&id=$id\"><img src=\"images/moral/reject.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" width=\"15\" heigh=\"15\" border=\"0\"></a></center>";
	CloseTable2();
	echo "<br>";
	CloseTable();
	include("footer.php");
}

if (!(isset($new_topic))) { $new_topic = 0; }
if (!(isset($op))) { $op = ""; }
if (!(isset($random_num))) { $random_num = ""; }
if (!(isset($gfx_check))) { $gfx_check = ""; }
if (!(isset($rated))) { $rated = 0; }
if (!(isset($score))) { $score = 0; }

switch ($op) {

	default:
	theindex($new_topic);
	break;

	case "moderation_mod_comments_view":
	moderation_mod_comments_view($id);
	break;

	case "thanks":
	thanks();
	break;


}

?>