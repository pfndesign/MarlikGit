<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV MarlikCMS PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.MarlikCMS.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|	* Copyright (c) 2005 - 2006 by http://www.irannuke.net										|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $prefix, $db,$aid,$admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='News'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
	if ($row2['name'] == "$admins[$i]" AND !empty($row['admins'])) {
		$auth_user = 1;
	}
}
if ($row2['radminsuper'] == 1 || $auth_user == 1) {
	
function mod_menu() {
	global $prefix, $db, $user_prefix, $admin_file;
	$new_comments = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_comments"));
	$num_surveys = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_pollcomments_moderated"));
	$num_reviews = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_reviews_comments_moderated"));
	$num_users = $db->sql_numrows($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE karma!=0"));
	title("Moderation - Users Karma System");
	OpenTable();
	echo "<center><b>"._CONTENTMODERATION."</b><br>"._SELECTOPTION."<br><br>[ ";
	echo "<a href=\"".$admin_file.".php?op=moderation_news\">"._COMMENTS_ADMIN."</a> (<b>".$new_comments.""._COMMENT."</b>) | ";
	if ($num_surveys != 0) {
		echo "<a href=\"".$admin_file.".php?op=moderation_surveys\">"._SURVEYCOMMENTS."</a> (<b>".$num_surveys."</b>) | ";
	} else {
		echo ""._SURVEYCOMMENTS." (<b>".$num_surveys."</b>) | ";
	}
	if ($num_reviews != 0) {
		echo "<a href=\"".$admin_file.".php?op=moderation_reviews\">"._REVIEWSCOMMENTS."</a> (<b>".$num_reviews."</b>) | ";
	} else {
		echo ""._REVIEWSCOMMENTS." (<b>".$num_reviews."</b>) | ";
	}
	if ($num_users != 0) {
		echo "<a href=\"".$admin_file.".php?op=moderation_users_list\">"._ALLMARKEDUSERS."</a> (<b>".$num_users."</b>) ]</center>";
	} else {
		echo ""._ALLMARKEDUSERS." (<b>".$num_users."</b>) ]</center>";
	}
	CloseTable();
	echo "<br>";
}

function moderation() {
	global $prefix, $db, $bgcolor2, $admin_file, $user_prefix;
	include ("header.php");
	GraphicAdmin();
	//mod_menu();
	include("footer.php");
}

function moderation_news() {
include ("header.php");
GraphicAdmin();
//mod_menu();
	
OpenTable();

if (!comments_moderated(0,'')) {
	echo _COMMENTS_NO_ENTERY_WAITING;
}else {
echo comments_moderated(0,'');
}
CloseTable();

OpenTable();

if (!comments_moderated(1,'')) {
	echo _COMMENTS_NO_ENTERY_MODERATED ."<br>"._COMMENTS_HELP_ACTIVENEWS;
}else {
echo comments_moderated(1,'');
}
CloseTable();

include("footer.php");}

function moderation_reject($section, $id) {
	global $prefix, $db, $admin_file;
	if ($section == "news") {$delete_ids = implode(",",$_POST['delete']);$db->sql_query("DELETE FROM ".$prefix."_comments WHERE tid='$id'");$db->sql_query("UPDATE ".$prefix."_stories SET comments=comments-1 WHERE sid=".intval($row[sid]));$db->sql_query("DELETE FROM ".$prefix."_comments_moderated WHERE tid='$id'");
		Header("Location: ".$admin_file.".php?op=moderation_news");	die();	}
	if ($section == "surveys") {
		$db->sql_query("DELETE FROM ".$prefix."_pollcomments_moderated WHERE tid='$id'");
		Header("Location: ".$admin_file.".php?op=moderation_surveys");
		die();
	}
	if ($section == "reviews") {
		$db->sql_query("DELETE FROM ".$prefix."_reviews_comments_moderated WHERE cid='$id'");
		Header("Location: ".$admin_file.".php?op=moderation_reviews");
		die();
	}
}

function moderation_news_view($id) {
	global $prefix, $db, $admin_file;
	include ("header.php");
	GraphicAdmin();
	////mod_menu();
	OpenTable();

	$comm = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_comments_moderated WHERE tid=".intval($id)));
	$comm['name'] = check_html($comm['name'], "nohtml");
	$comm['subject'] = check_html($comm['subject'], "nohtml");
	$comm['comment'] = check_html($comm['comment'], "");
	$news = $db->sql_fetchrow($db->sql_query("SELECT title, hometext, bodytext, topic FROM ".$prefix."_stories WHERE sid=".intval($comm['sid'])));
	$news['title'] = check_html($news['title'], "nohtml");
	$news['hometext'] = check_html($news['hometext'], "");
	$news['bodytext'] = check_html($news['bodytext'], "");
	$topic = $db->sql_fetchrow($db->sql_query("SELECT topicimage FROM ".$prefix."_topics WHERE topicid=".intval($news['topic'])));
	if ($comm['pid'] != 0) {
		$reply = $db->sql_fetchrow($db->sql_query("SELECT name, subject, comment FROM ".$prefix."_comments_moderated WHERE tid=".intval($comm['pid'])));
		$reply['name'] = check_html($reply['name'], "nohtml");
		$reply['subject'] = check_html($reply['subject'], "nohtml");
		$reply['comment'] = check_html($reply['comment'], "");
	} else {
		$reply = "";
	}

	if (!empty($reply)) {
		echo "<br><br><center><b>"._INREPLYTO."</b></center><br>";
		OpenTable();
		echo "<b>".$reply['subject']."</b><br>"._BY." ".$reply['name']."<br><br>".$reply['comment']."";
		CloseTable();
	}
	echo "<h3 style='text-align:right'>"._COMMENTAPPPENDING."</h3>";
	OpenTable();
	echo "<b>".$comm['subject']."</b><br>"._BY." <b>".$comm['name']."</b><br><br>".$comm['comment']."<br><br>";
	echo "<center><hr size=\"1\" width=\"80%\">
	<a href=\"".$admin_file.".php?op=moderation_approval&section=news&id=$id\">
	"._APPROVE." <img src=\"images/check.png\" alt=\""._APPROVE."\" title=\""._APPROVE."\" ></a> &nbsp; 
	<a href=\"".$admin_file.".php?op=moderation_reject&section=news&id=$id\">
	<img src=\"images/delete.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" >"._REJECT." </a></center>";
	CloseTable();
	echo "<br>"._GOBACK."";
	
	CloseTable();
	include("footer.php");
}

function moderation_mc_view($id) {
	global $prefix, $db, $admin_file;
	include ("header.php");
	GraphicAdmin();
	////mod_menu();
	OpenTable();

	//require_once("includes/javascript/jquery/plugins/bbedit/bbedit.php");
	$comm = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_comments_moderated WHERE tid=".intval($id)));
	$comm['name'] = check_html($comm['name'], "nohtml");
	$comm['subject'] = check_html($comm['subject'], "nohtml");
	$comm['comment'] = check_html($comm['comment'], "");
	$news = $db->sql_fetchrow($db->sql_query("SELECT title, hometext, bodytext, topic FROM ".$prefix."_stories WHERE sid=".intval($comm['sid'])));
	$news['title'] = check_html($news['title'], "nohtml");
	$news['hometext'] = check_html($news['hometext'], "");
	$news['bodytext'] = check_html($news['bodytext'], "");
	$topic = $db->sql_fetchrow($db->sql_query("SELECT topicimage FROM ".$prefix."_topics WHERE topicid=".intval($news['topic'])));
	if ($comm['pid'] != 0) {
		$reply = $db->sql_fetchrow($db->sql_query("SELECT name, subject, comment FROM ".$prefix."_comments_moderated WHERE tid=".intval($comm['pid'])));
		$reply['name'] = check_html($reply['name'], "nohtml");
		$reply['subject'] = check_html($reply['subject'], "nohtml");
		$reply['comment'] = check_html($reply['comment'], "");
	} else {
		$reply = "";
	}

	if (!empty($reply)) {
		echo "<br><br><center><b>"._INREPLYTO."</b></center><br>";
		OpenTable();
		echo "<b>".$reply['subject']."</b><br>"._BY." ".$reply['name']."<br><br>".$reply['comment']."";
		wysiwyg_textarea("comment", $reply['comment'], "PHPNuke", "30", "20");
		CloseTable();
	}
	echo "<h3 style='text-align:right'>"._COMMENTAPPPENDING."</h3>";
	echo "<form action='".$admin_file.".php?op=moderation_approval' method='post'><div style='text-align:right;'>
	 <b>".$comm['subject']."</b><br>"._BY." <b>".$comm['name']."</b><br><br>
	 <img src='images/icon/help.png'>می توانید این نظر را ویرایش کنید<br>";
	
		echo '
    <link rel="stylesheet" type="text/css" href="includes/javascript/jquery/plugins/bbedit/bbedit.css" />
    <script type="text/javascript" src="includes/javascript/jquery/plugins/bbedit/jquery.bbedit.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $("#comment").bbedit();
    });
    </script>';
			echo '<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top" width="50%">';
			//echo '<textarea wrap="virtual" cols="100" rows="10" name="comment" id="comment">'.$comm['comment'].'</textarea>';
		wysiwyg_textarea("comment", $comm['comment'], "PHPNuke", "30", "20");
			echo '</td></tr></table>';
		echo "<br><br>
	 </div>
	 ";
	
	echo "<center><hr size=\"1\" width=\"100%\">
	<input type='hidden' name='section' value='news'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' value='"._APPROVE."- ذخیره'>
	<a href=\"".$admin_file.".php?op=moderation_reject&section=news&id=$id\">
	<img src=\"images/delete.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" >"._REJECT." </a></center></form>";
	echo "<br>"._GOBACK."";
	
			CloseTable();
			include("footer.php");}

function moderation_surveys() {
	global $prefix, $db, $user_prefix, $bgcolor2, $bgcolor1, $admin_file;
	include ("header.php");
	GraphicAdmin();
	//mod_menu();
	OpenTable();
	echo "<center><font class=\"title\"><b>"._SURVEYPENDING."</b></font></center><br>";
	echo "<table border=\"1\" align=\"center\" width=\"100%\"><tr>";
	echo "<td bgcolor=\"$bgcolor2\" width=\"100%\">&nbsp;<b>"._COMMENTTITLE."</b></td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\">&nbsp;<b>"._USER."</b>&nbsp;</td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\">&nbsp;<b>"._FUNCTIONS."</b>&nbsp;</td></tr>";
	$sql = $db->sql_query("SELECT tid, subject, name FROM ".$prefix."_pollcomments_moderated");
	while ($row = $db->sql_fetchrow($sql)) {
		$row['subject'] = check_html($row['subject'], "nohtml");
		$row['name'] = check_html($row['name'], "nohtml");
		echo "<td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"".$admin_file.".php?op=moderation_surveys_view&id=".intval($row['tid'])."\">".$row['subject']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"modules.php?name=Your_Account&op=userinfo&username=".$row['name']."\" target=\"_blank\">".$row['name']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<a href=\"".$admin_file.".php?op=moderation_approval&section=surveys&id=".intval($row['tid'])."\"><img src=\"images/moral/approve.gif\" alt=\""._APPROVE."\" title=\""._APPROVE."\" width=\"15\" heigh=\"15\" border=\"0\"></a> &nbsp; <a href=\"".$admin_file.".php?op=moderation_reject&section=surveys&id=".intval($row['tid'])."\"><img src=\"images/moral/reject.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" width=\"15\" heigh=\"15\" border=\"0\"></a>&nbsp;</td></tr>";
		$a = 1;
	}
	if ($a != 1) {
		echo "<td bgcolor=\"$bgcolor1\" colspan=\"3\" align=\"center\">&nbsp;<i>"._NOCONTENT."</i>&nbsp;</td></tr>";
	}
	echo "</table>";
	CloseTable();
	include("footer.php");
}

function moderation_surveys_view($id) {
	global $prefix, $db, $admin_file;
	include ("header.php");
	GraphicAdmin();
	//mod_menu();
	OpenTable();
	$comm = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_pollcomments_moderated WHERE tid='$id'"));
	$comm['name'] = check_html($comm['name'], "nohtml");
	$comm['subject'] = check_html($comm['subject'], "nohtml");
	$comm['comment'] = check_html($comm['comment'], "");
	$poll = $db->sql_fetchrow($db->sql_query("SELECT pollTitle FROM ".$prefix."_poll_desc WHERE pollID=".intval($comm['pollID'])));
	$poll['pollTitle'] = check_html($poll['pollTitle'], "nohtml");
	if ($comm['pid'] != 0) {
		$reply = $db->sql_fetchrow($db->sql_query("SELECT name, subject, comment FROM ".$prefix."_pollcomments WHERE tid=".intval($comm['pid'])));
		$reply['name'] = check_html($reply['name'], "nohtml");
		$reply['subject'] = check_html($reply['subject'], "nohtml");
		$reply['comment'] = check_html($reply['comment'], "");
	} else {
		$reply = "";
	}
	echo "<center><b>"._COMMENTTOSURVEY."</b></center><br>";
	OpenTable2();
	echo "<center><i>".$poll['pollTitle']."</i></center>";
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
	echo "<center><hr size=\"1\" width=\"80%\"><a href=\"".$admin_file.".php?op=moderation_approval&section=surveys&id=$id\"><img src=\"images/moral/approve.gif\" alt=\""._APPROVE."\" title=\""._APPROVE."\" width=\"15\" heigh=\"15\" border=\"0\"></a> &nbsp; <a href=\"".$admin_file.".php?op=moderation_reject&section=surveys&id=$id\"><img src=\"images/moral/reject.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" width=\"15\" heigh=\"15\" border=\"0\"></a></center>";
	CloseTable2();
	echo "<br>";
	CloseTable();
	include("footer.php");
}

function moderation_reviews() {
	global $prefix, $db, $user_prefix, $bgcolor2, $bgcolor1, $admin_file;
	include ("header.php");
	GraphicAdmin();
	//mod_menu();
	OpenTable();
	echo "<center><font class=\"title\"><b>"._REVIEWSPENDING."</b></font></center><br>";
	echo "<table border=\"1\" align=\"center\" width=\"100%\"><tr>";
	echo "<td bgcolor=\"$bgcolor2\" width=\"100%\">&nbsp;<b>"._COMMENTTITLE."</b></td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\">&nbsp;<b>"._USER."</b>&nbsp;</td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\">&nbsp;<b>"._FUNCTIONS."</b>&nbsp;</td></tr>";
	$sql = $db->sql_query("SELECT cid, rid, userid FROM ".$prefix."_reviews_comments_moderated");
	while ($row = $db->sql_fetchrow($sql)) {
		$row['userid'] = intval($row['userid']);
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT title FROM ".$prefix."_reviews WHERE id=".intval($row['rid'])));
		$row2['title'] = check_html($row2['title'], "nohtml");
		echo "<td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"".$admin_file.".php?op=moderation_reviews_view&id=".intval($row['cid'])."\">For Review: ".$row2['title']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"modules.php?name=Your_Account&op=userinfo&username=".$row['userid']."\" target=\"_blank\">".$row['userid']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<a href=\"".$admin_file.".php?op=moderation_approval&section=reviews&id=".intval($row['cid'])."\"><img src=\"images/moral/approve.gif\" alt=\""._APPROVE."\" title=\""._APPROVE."\" width=\"15\" heigh=\"15\" border=\"0\"></a> &nbsp; <a href=\"".$admin_file.".php?op=moderation_reject&section=reviews&id=".intval($row['cid'])."\"><img src=\"images/moral/reject.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" width=\"15\" heigh=\"15\" border=\"0\"></a>&nbsp;</td></tr>";
		$a = 1;
	}
	if ($a != 1) {
		echo "<td bgcolor=\"$bgcolor1\" colspan=\"3\" align=\"center\">&nbsp;<i>"._NOCONTENT."</i>&nbsp;</td></tr>";
	}
	echo "</table>";
	CloseTable();
	include("footer.php");
}

function moderation_reviews_view($id) {
	global $prefix, $db, $admin_file;
	$id = intval($id);
	include ("header.php");
	GraphicAdmin();
	//mod_menu();
	OpenTable();
	$comm = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_reviews_comments_moderated WHERE cid='$id'"));
	$comm['userid'] = intval($comm['userid']);
	$comm['score'] = intval($comm['score']);
	$comm['comments'] = check_html($comm['comments'], "");
	$revi = $db->sql_fetchrow($db->sql_query("SELECT title FROM ".$prefix."_reviews WHERE id=".intval($comm['rid'])));
	$revi['title'] = check_html($revi['title'], "nohtml");
	echo "<center><b>Comment to the Review:</b></center><br>";
	OpenTable2();
	echo "<center><i>".$revi['title']."</i></center>";
	CloseTable2();
	echo "<br><br><center><b>"._COMMENTAPPPENDING."</b></center><br>";
	OpenTable2();
	echo "<b>".$revi['title']."</b><br>"._BY." ".$comm['userid']." "._WITHSCORE." ".$comm['score']."/10<br><br>".$comm['comments']."<br><br>";
	echo "<center><hr size=\"1\" width=\"80%\"><a href=\"".$admin_file.".php?op=moderation_approval&section=reviews&id=$id\"><img src=\"images/moral/approve.gif\" alt=\""._APPROVE."\" title=\""._APPROVE."\" width=\"15\" heigh=\"15\" border=\"0\"></a> &nbsp; <a href=\"".$admin_file.".php?op=moderation_reject&section=reviews&id=$id\"><img src=\"images/moral/reject.gif\" alt=\""._REJECT."\" title=\""._REJECT."\" width=\"15\" heigh=\"15\" border=\"0\"></a></center>";
	CloseTable2();
	echo "<br>";
	CloseTable();
	include("footer.php");
}

function moderation_approval($section='news',$id,$comment) {
	
	global $prefix, $db, $admin_file;

	$section = sql_quote($section);
	$id = sql_quote($id);
	$comment = sql_quote($comment);
	switch ($section)
	{
	case 'news':
			$sql = "UPDATE ".$prefix."_comments_moderated SET  active = '1'";
			if(!empty($comment)){
				$sql .= ", comment='$comment' ";
			}		
			$sql .= "WHERE tid='$id'";
			$db->sql_query($sql)or die(mysql_error());
			Header("Location: ".$admin_file.".php?op=moderation_news&status=done");
	break;
	
	case 'surveys':
		$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_pollcomments_moderated WHERE tid='$id'"));
		$db->sql_query("INSERT INTO ".$prefix."_pollcomments VALUES (NULL, '".intval($row['pid'])."', '".intval($row['pollID'])."', '".$row['date']."', '".$row['name']."', '".$row['email']."', '".$row['url']."', '".$row['host_name']."', '".$row['subject']."', '".$row['comment']."', '".intval($row['score'])."', '0', '0')");
		$db->sql_query("UPDATE ".$prefix."_poll_desc SET comments=comments+1 WHERE pollID='".intval($row['pollID']));
		$db->sql_query("DELETE FROM ".$prefix."_pollcomments_moderated WHERE tid='$id'");
		Header("Location: ".$admin_file.".php?op=moderation_surveys");
		die();
		break;
	
	case 'reviews':
		$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_reviews_comments_moderated WHERE cid='$id'"));
		$db->sql_query("INSERT INTO ".$prefix."_reviews_comments VALUES (NULL, '".intval($row['rid'])."', '".$row['userid']."', '".$row['date']."', '".$row['comments']."', '".intval($row['score'])."')");
		$db->sql_query("DELETE FROM ".$prefix."_reviews_comments_moderated WHERE cid='$id'");
		Header("Location: ".$admin_file.".php?op=moderation_reviews");
		die();
	break;
	
	}
}

function moderation_users_list($section=0) {
	global $prefix, $db, $admin_file, $user_prefix, $bgcolor1, $bgcolor2;
	include ("header.php");
	GraphicAdmin();
	//mod_menu();
	OpenTable();
	$sql = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE karma='1'");
	echo "<center><font class=\"title\"><b>"._REGKARMAUSERS."</b></font></center><br>";
	echo "<table border=\"1\" align=\"center\" width=\"50%\"><tr>";
	echo "<td bgcolor=\"$bgcolor2\" width=\"100%\">&nbsp;<b>"._USERNAME."</b></td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\" nowrap>&nbsp;<b>"._CURRENTKARMA."</b>&nbsp;</td></tr>";
	while($row = $db->sql_fetchrow($sql)) {
		echo "<tr><td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"modules.php?name=Your_Account&op=userinfo&username=".$row['username']."\" target=\"_blank\">".$row['username']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<img src=\"images/moral/".$row['karma'].".gif\" border=\"0\" alt=\""._KARMALOW."\" title=\""._KARMALOW."\">&nbsp;</td></tr>";
		$a = 1;
	}
	if ($a != 1) {
		echo "<tr><td bgcolor=\"$bgcolor1\" colspan=\"2\" align=\"center\">&nbsp;<i>"._NOCONTENT."</i>&nbsp;</td></tr>";
	}
	echo "</table><br><br>";
	$a = 0;
	$sql = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE karma='2'");
	echo "<center><font class=\"title\"><b>"._BADKARMAUSERS."</b></font></center><br>";
	echo "<table border=\"1\" align=\"center\" width=\"50%\"><tr>";
	echo "<td bgcolor=\"$bgcolor2\" width=\"100%\">&nbsp;<b>"._USERNAME."</b></td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\" nowrap>&nbsp;<b>"._CURRENTKARMA."</b>&nbsp;</td></tr>";
	while($row = $db->sql_fetchrow($sql)) {
		echo "<tr><td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"modules.php?name=Your_Account&op=userinfo&username=".$row['username']."\" target=\"_blank\">".$row['username']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<img src=\"images/moral/".$row['karma'].".gif\" border=\"0\" alt=\""._KARMABAD."\" title=\""._KARMABAD."\">&nbsp;</td></tr>";
		$a = 1;
	}
	if ($a != 1) {
		echo "<tr><td bgcolor=\"$bgcolor1\" colspan=\"2\" align=\"center\">&nbsp;<i>"._NOCONTENT."</i>&nbsp;</td></tr>";
	}
	echo "</table><br><br>";
	$a = 0;
	$sql = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE karma='3'");
	echo "<center><font class=\"title\"><b>"._DEVKARMAUSERS."</b></font></center><br>";
	echo "<table border=\"1\" align=\"center\" width=\"50%\"><tr>";
	echo "<td bgcolor=\"$bgcolor2\" width=\"100%\">&nbsp;<b>"._USERNAME."</b></td>";
	echo "<td bgcolor=\"$bgcolor2\" align=\"center\" nowrap>&nbsp;<b>"._CURRENTKARMA."</b>&nbsp;</td></tr>";
	while($row = $db->sql_fetchrow($sql)) {
		echo "<tr><td bgcolor=\"$bgcolor1\">&nbsp;<a href=\"modules.php?name=Your_Account&op=userinfo&username=".$row['username']."\" target=\"_blank\">".$row['username']."</a>&nbsp;</td>";
		echo "<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<img src=\"images/moral/".$row['karma'].".gif\" border=\"0\" alt=\""._KARMADEVIL."\" title=\""._KARMADEVIL."\">&nbsp;</td></tr>";
		$a = 1;
	}
	if ($a != 1) {
		echo "<tr><td bgcolor=\"$bgcolor1\" colspan=\"2\" align=\"center\">&nbsp;<i>"._NOCONTENT."</i>&nbsp;</td></tr>";
	}
	echo "</table><br>";
	CloseTable();
	include("footer.php");
}

switch($op) {

	case "moderation":
		moderation();
		break;

	case "comment_panel":
		comment_panel($tid);
		break;
	case "moderation_news":
		moderation_news();
		break;

	case "moderation_news_view":
		moderation_news_view($id);
		break;
	case "moderation_mc_view":
		moderation_mc_view($id);
		break;


	case "moderation_surveys":
		moderation_surveys();
		break;

	case "moderation_surveys_view":
		moderation_surveys_view($id);
		break;

	case "moderation_reviews":
		moderation_reviews();
		break;

	case "moderation_reviews_view":
		moderation_reviews_view($id);
		break;

	case "moderation_approval":
		moderation_approval($section, $id,$comment);
		break;

	case "moderation_reject":
		moderation_reject($section, $id);
		break;

	case "moderation_users_list":
		moderation_users_list($section);
		break;

}

} else {
	echo "Access Denied";
}

?>