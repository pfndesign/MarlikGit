<?php


/**
*
* @package Categories														
* @version $Id: News System  RC-7 4:09 PM 1/16/2010 $Aneeshtan						
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
require_once(MODULES_PATH."$module_name/class.posts.php");

get_lang($module_name);



define('INDEX_FILE', true);

$categories = 1;
$cat = $catid;
$category = sql_quote($category);
global $pagetitle;
$pagetitle = $category;

automated_news();

function catindex($category) {

	global $storyhome, $pagenum, $httpref, $httprefmax, $topicname, $topicimage, $topictext, $datetime, $user, $cookie, $nukeurl, $prefix, $multilingual, $currentlang, $db, $articlecomm, $module_name, $userinfo;

	if (is_user($user)) { getusrinfo($user); }


	if ($multilingual == 1) {
	$querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
	} else {
	$querylang = "";
	}

$category = Slugit(sql_quote(trim($category)));
	
	list($int_cat) = $db->sql_fetchrow($db->sql_query("SELECT `topicid` FROM "._TOPICS_TABLE." where `slug`='$category' LIMIT 1"));
	if (empty($int_cat)) {
		list($int_cat) = $db->sql_fetchrow($db->sql_query("SELECT `topicid` FROM "._TOPICS_TABLE." where `topicname`='$category' LIMIT 1"));
			if (empty($int_cat)) {
				list($int_cat) = $db->sql_fetchrow($db->sql_query("SELECT `topicid` FROM "._TOPICS_TABLE." where `topicid`='$category' LIMIT 1"));
					if (empty($int_cat)) {
						show_error(_WRONG_CATNAME."<br>
		<b>".sql_quote($_GET['category'])."</b>
						");
					}
			}
	}
	
	
	include("header.php");

	if (isset($userinfo['storynum'])) {
	$storynum = $userinfo['storynum'];
	} else {
	$storynum = $storyhome;
	}
	if (empty($pagenum)) { $pagenum = 1 ; }
	$offset = ($pagenum-1) * $storynum ;

	
	$ctime = date("Y-m-j H:i-1:s");
	//$result = $db->sql_query("SELECT * FROM ".$prefix."_stories where associated LIKE '%$int_cat-%' $querylang  AND time <= '$ctime' AND  section='news' ORDER BY sid DESC limit $offset, $storynum");
	$nk_post = new nk_posts();
	$qdb = "where FIND_IN_SET($int_cat, REPLACE(associated, '-', ',')) $querylang  AND time <= '$ctime' AND  section='news' AND title!='draft'";
	
	$nk_post->_data($offset,$pagenum,$storyhome,$querylang,$qdb);
	$nk_post->_pagination(5,$category);
	
		if ($nk_post->totalnum == 0) {
		Opentable();
		echo "<center><img src='images/alert.gif'><br>
		<b>".sql_quote($_GET['category'])."</b>
		<br>"._NO_ARTICLE."
		</center>
		";
		Closetable();
	}


	include("footer.php");

}

switch ($op) {
	default:
		if ($category== "") {
			Header("Location: modules.php?name=$module_name");
		}
		catindex($category);
	break;

}



?>