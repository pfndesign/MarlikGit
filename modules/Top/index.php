<?php
/**
*
* @package  TOP MODULE FOR MarlikCMS														
* @version $Id:  MarlikCMS  $			
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

include("header.php");
global $prefix, $db,$sitename,$multilingual,$currentlang;


if ($multilingual == 1) {
	$queryalang = "WHERE (alanguage='$currentlang' OR alanguage='')"; /* top stories */
	$querya1lang = "WHERE (alanguage='$currentlang' OR alanguage='') AND"; /* top stories */
	$queryslang = "WHERE slanguage='$currentlang' "; /* top section articles */
	$queryplang = "WHERE planguage='$currentlang' "; /* top polls */
	$queryrlang = "WHERE rlanguage='$currentlang' "; /* top reviews */
} else {
	$queryalang = "WHERE";
	$querya1lang = "WHERE";
	$queryslang = "";
	$queryplang = "";
	$queryrlang = "";
}

OpenTable();
echo "<center><font class=\"title\"><b>"._TOPWELCOME." $sitename!</b></font></center>";
CloseTable();
echo "<br>\n\n";
OpenTable();

//--Current Time 
$ctime		= date("Y-m-j H:i:s");
$top = 10; // change this if you need more to show in top links of the website.
		
/* Top 10 read stories */

$result = $db->sql_query("SELECT `sid`, `title`, `counter` FROM ".$prefix."_stories $queryalang AND `time` <= '$ctime'  AND `section`='news' AND `approved`='1' AND `title`!='draft' ORDER BY `counter` DESC LIMIT 0,$top");
if ($db->sql_numrows($result) > 0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._READSTORIES."</b></font><br><br><font class=\"content\">\n";
	$lugar=1;
	while ($row = $db->sql_fetchrow($result)) {
		$sid = intval($row['sid']);
		$title = stripslashes(check_words(check_html($row['title'], "nohtml")));
		$counter = intval($row['counter']);
		if($counter>0) {
			echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."\">$title</a> - ($counter "._READS.")<br>\n";
			$lugar++;
		}
	}
	echo "</font></td></tr></table><br>\n";
}
$db->sql_freeresult($result);
/* Top 10 categories */

$result5 = $db->sql_query("SELECT * FROM ".$prefix."_topics ORDER BY `counter` DESC LIMIT 0,$top");
if ($db->sql_numrows($result5) > 0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._ACTIVECAT."</b></font><br><br><font class=\"content\">\n";
	$lugar=1;
	while ($row5 = $db->sql_fetchrow($result5)) {
		$catid = intval($row5['topicid']);
		$title = stripslashes(check_words(check_html($row5['topicname'], "nohtml")));
		$slug = stripslashes(check_words(check_html($row5['slug'], "nohtml")));
		$counter = intval($row5['counter']);
			echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=News&amp;file=categories&amp;category=$slug\">$title</a> - ($counter "._HITS.")<br>\n";
			$lugar++;
	}
	echo "</font></td></tr></table><br>\n";
}
$db->sql_freeresult($result5);
/* Top 10 tags */

$result = $db->sql_query("SELECT * FROM ".$prefix."_tags ORDER BY `count` DESC LIMIT 0,$top");
if ($db->sql_numrows($result) > 0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._ACTIVETAGS."</b></font><br><br><font class=\"content\">\n";
	$lugar=1;
	while ($row = $db->sql_fetchrow($result)) {
			echo "<strong><big>&middot;</big></strong>&nbsp;".$row['tag'].": <a href=\"modules.php?name=News&file=tags&tag=".$row['slug']."\">".$row['tag']."</a> - (".$row['count']." "._HITS.")<br>\n";
			$lugar++;
	}
	echo "</font></td></tr></table><br>\n";
}
$db->sql_freeresult($result);
/* Top 10 users submitters */

$result7 = $db->sql_query("SELECT * FROM ".$prefix."_users WHERE `user_active`='1' ORDER BY `points` DESC LIMIT 0,$top");
if ($db->sql_numrows($result7) > 0) {
/* kralpc.com -- start---*/
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._USER." ( "._TOPRATED." )
	</b></font><br><br><font class=\"content\">\n";
/* kralpc.com -- end---*/
	$lugar=1;
	while ($row7 = $db->sql_fetchrow($result7)) {
		$uname = stripslashes($row7['username']);
		$points = $row7['points'];
		/* kralpc.com -- start---*/
			echo "<strong><big>&middot;</big></strong>&nbsp;<img src='".avatar_me($uname)."' style='border:2px solid white;width:45px;height:45px;'><a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$uname\">$uname</a> - ("._POINTS." : ".number_format($points).")<br>\n";
		/* kralpc.com -- end---*/
		$lugar++;
	}
	echo "</font></td></tr></table><br>\n";
}
$db->sql_freeresult($result7);
/* Top 10 Polls */

$result8 = $db->sql_query("select * from ".$prefix."_poll_desc $queryplang AND active='1'");
if ($db->sql_numrows($result8)>0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._VOTEDPOLLS."</b></font><br><br><font class=\"content\">\n";
	$lugar = 1;
	$result9 = $db->sql_query("SELECT pollID, pollTitle, timeStamp, voters FROM ".$prefix."_poll_desc $queryplang order by voters DESC limit 0,$top"); 
    $counter = 0; 
    while($row9 = $db->sql_fetchrow($result9)) { 
   $resultArray[$counter] = array($row9[pollID], $row9[pollTitle], $row9[timeStamp], $row9[voters]);
		$counter++;
	}
	for ($count = 0; $count < count($resultArray); $count++) {
		$id = $resultArray[$count][0];
		$pollTitle = $resultArray[$count][1];
		$voters = $resultArray[$count][3];
		$sum = 0;
		for($i = 0; $i < 12; $i++) {
			$result10 = $db->sql_query("SELECT optionCount FROM ".$prefix."_poll_data WHERE (pollID='$id') AND (voteID='$i')"); 
       $row10 = $db->sql_fetchrow($result10); 
       $optionCount = $row10['optionCount'];
			$sum = (int)$sum+$optionCount;
		}
		$pollTitle = check_html($pollTitle, "nohtml");
		echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=Surveys&amp;pollID=$id\">$pollTitle</a> - ($sum "._LVOTES.")<br>\n";
		$lugar++;
		$sum = 0;
	}
	echo "</font></td></tr></table><br>\n";
}
$db->sql_freeresult($result8);
/* Top 10 authors */

$result11 = $db->sql_query("SELECT aid, counter FROM ".$prefix."_authors ORDER BY counter DESC LIMIT 0,$top");
if ($db->sql_numrows($result11) > 0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._MOSTACTIVEAUTHORS."</b></font><br><br><font class=\"content\">\n";
	$lugar=1;
	while ($row11 = $db->sql_fetchrow($result11)) {
		$aid = stripslashes($row11['aid']);
		$counter = intval($row11['counter']);
		if($counter>0) {
			echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=Search&amp;query=&amp;author=$aid\">$aid</a> - ($counter "._NEWSPUBLISHED.")<br>\n";
			$lugar++;
		}
	}
	echo "</font></td></tr></table><br>\n";
}
$db->sql_freeresult($result11);
/* Top 10 downloads */

$result13 = $db->sql_query("SELECT lid, cid, title, hits FROM ".$prefix."_nsngd_downloads ORDER BY hits DESC LIMIT 0,$top");
if ($db->sql_numrows($result13) > 0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._DOWNLOADEDFILES."</b></font><br><br><font class=\"content\">\n";
	$lugar=1;
	while ($row13 = $db->sql_fetchrow($result13)) {
		$lid = intval($row13['lid']);
		$cid = intval($row13['cid']);
		$title = stripslashes(check_words(check_html($row13['title'], "nohtml")));
		$hits = intval($row13['hits']);
		if($hits>0) {
			$row_res = $db->sql_fetchrow($db->sql_query("SELECT title FROM ".$prefix."_nsngd_categories WHERE cid='$cid'"));
			$ctitle = check_words(check_html($row_res['title'], "nohtml"));
			$utitle = str_replace(" ", "_", $title);
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=Downloads&amp;op=getit&amp;lid=$lid\">$title</a> ("._CATEGORY.": $ctitle) - ($hits "._LDOWNLOADS.")<br>\n";
			$lugar++;
		}
	}
	echo "</font></td></tr></table>\n\n";
}
$db->sql_freeresult($result13);
/* Top 10 Pages in Content */


$result14 = $db->sql_query("SELECT sid, title, counter FROM ".$prefix."_stories $queryalang AND ns.time <= '$ctime'  AND  ns.section='message' AND ns.approved='1' AND ns.title!='draft' ORDER BY counter DESC LIMIT 0,$top");
if ($db->sql_numrows($result14) > 0) {
	echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td>\n"
	."<font class=\"option\"><b>$top "._MOSTREADPAGES."</b></font><br><br><font class=\"content\">\n";
	$lugar=1;
	while ($row14 = $db->sql_fetchrow($result14)) {
		$pid = intval($row14['sid']);
		$title = stripslashes(check_words(check_html($row14['title'], "nohtml")));
		$counter = intval($row14['counter']);
		if($counter>0) {
			echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."\">$title</a> - ($counter "._READS.")<br>\n";
			$lugar++;
		}
	}
	echo "</font></td></tr></table>\n\n";
}

CloseTable();
include("footer.php");

?>