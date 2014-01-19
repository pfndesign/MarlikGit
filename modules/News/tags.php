<?php
/**
*
* @package News Module	-TAGS													
* @version $Id:  6:23 PM 1/8/2010  REVISION Aneeshtan - JAMES $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
global $pagetitle;
$pagetitle = $tag;
function theindex($tag) {
	global $storyhome, $pagenum, $httpref, $httprefmax, $topicname, $topicimage, $topictext, $datetime, $user, $cookie, $nukeurl, $prefix, $multilingual, $currentlang, $db, $articlecomm, $module_name, $userinfo,$nextg,$nk_post;
	if (is_user($user)) { getusrinfo($user); }
	if ($multilingual == 1) {
		$querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
	} else {
		$querylang = "";
	}
	$tag = (sql_quote(trim(Slugit($tag))));
	list($int_tag) = $db->sql_fetchrow($db->sql_query("SELECT tid FROM ".TAGS_TABLE." where `slug`='$tag' LIMIT 1"));
	if (empty($int_tag)) {
		list($int_tag) = $db->sql_fetchrow($db->sql_query("SELECT tid FROM ".TAGS_TABLE." where `tag`='$tag' LIMIT 1"));
			if (empty($int_tag)) {
				show_error("شناسه کلیدواژه مورد نظر شما معتبر نیست");
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
	
	$ctime = date("Y-m-j H:i:s");

	$nk_post = new nk_posts();
	$qdb = "where tags  LIKE '% $int_tag %' $querylang   AND time <= '$ctime' AND  section='news' AND title!='draft'";
	
	$nk_post->_data($offset,$pagenum,$storyhome,$querylang,$qdb);
	$nk_post->_pagination(6,$tag);
	
		if ($nk_post->totalnum == 0) {
		Opentable();
		echo "<center><img src='images/alert.gif'><br>
		<br>متاسفانه مطلبی با کلید واژه <b>$tag</b> ثبت نشده است
		</center>
		";
		Closetable();
	}


	include("footer.php");
}


theindex($tag);

?>