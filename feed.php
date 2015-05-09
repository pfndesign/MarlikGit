<?php
/**
*
* @package RSS Feed Class														
* @version $Id: $Kralpc --  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

@require_once('mainfile.php');
global $prefix,$admin,$db,$site_logo,$multilingual,$currentlang,$backend_language,$siteurl,$sitename,$slogan,$backend_title,$slogan,$name,$nextg;

//=================================DEFINITIONS =================================
define('FORUMS_TABLE',				$prefix . '_bb3forums');
define('TOPICS_TABLE',				$prefix . '_bb3topics');
define('POSTS_TABLE',				$prefix . '_bb3posts');
define('USERS_TABLE',				$prefix . '_bb3users');
$backend_title = (empty($backend_title)) ? $sitename : $backend_title;
$siteurl = (!preg_match("/http:/iu",USV_DOMAIN) ? "http://".USV_DOMAIN : USV_DOMAIN);
$section = (!empty($_GET['mod'])) ?  sql_quote($_GET['mod']) : "News";
$FeedTYPE = ($_GET['type']=='atom') ?  "AtomGenerator" : "RSSGenerator";
define("FEED_SECTION",$section);
define("FEED_TYPE",$type);
define("FEED_LIMIT_PER_PAGE",25);
$now = date("Y-m-j H:i:s");
//+============================================================================+

//============================================================================
//=================================FUNCTIONS =================================
function xml_escape($string)
{
	return str_replace(array('&','"',"'",'<','>'),
	array('&amp;','&quot;','&apos;','&lt;','&gt;'),
	$string );
}
function make_xml_compatible($text)
{
	return check_html($text,'nohtml');
}
function GetData($title,$link,$date,$author,$html){
	global $feeds;
	$feeds->addItem(new FeedItem(''.make_xml_compatible(''.xml_escape($link).'',"<![CDATA[ ',$link,' ]]>").'', ''.$title.'', ''.xml_escape($link).'', ''.make_xml_compatible($html).'',''.date3339($date).''));
	
}

//=========START FEED GENERATING============
//==========================================

try {
	include(INCLUDES_PATH."RSS/lib/FeedGenerator.php");
	$feeds=new FeedGenerator;
	$feeds->setGenerator(new $FeedTYPE); # or AtomGenerator
	$feeds->setAuthor(''.$adminmail.' ('.$admin.')');
	$feeds->setTitle(''.$backend_title.'');
	$feeds->setChannelLink(''.$siteurl.'/feed/'.$section.'/'.$type.'');
	$feeds->setLink(''.$siteurl.'');
	$feeds->setDescription(''.$site_logo.'');
	$feeds->setID(''.$siteurl.'/feed/'.$section.'/'.$type.'');
	
switch (FEED_SECTION) {
	default:
			$querylang = (!empty($multilingual)) ? "AND alanguage ='$currentlang'" : "";
			$result = $db->sql_query("SELECT *
 			FROM ".$prefix."_stories  WHERE section='news' AND approved='1'  AND time<='$now' $querylang
 			ORDER BY sid DESC LIMIT ". FEED_LIMIT_PER_PAGE."");

	if (!empty($result)) {

		while($row = $db->sql_fetchrow($result))
		{

			$title = $row['title'];
			$sid = intval($row['sid']);
			$slug_title = Slugit($title);
			if ($nextg==1) {
				$link = "".USV_DOMAIN."/article/$sid/$slug_title";
			}else {
				$link = "".USV_DOMAIN."/modules.php?name=News&file=article&sid=$sid&title=$slug_title";
			}

			$html = $row['hometext'];
			$author = $row['informant'];
			if (empty($author)) {$author= $row['aid'] ;}
			$date = strtotime( $row['time']);

			GetData($title,$link,$date,$author,$html);

		}
		$db->sql_freeresult($result);

		

	}else {
		show_error("RSS HAS NO CONTENT");
	}
/*\--------------[ BEGIN:  USV-Admin Downloads RSS ]---------------\*/
	break;
	case 'Downloads':
	$result = $db->sql_query("SELECT lid, title, description, date FROM ".$prefix."_nsngd_downloads ORDER BY date DESC LIMIT ".FEED_LIMIT_PER_PAGE."");
	while (list($rlid, $rtitle, $rdescription, $rdate) = $db->sql_fetchrow($result)) {

		$link = "".USV_DOMAIN."/modules.php?name=Downloads&op=getit&lid=$rlid";
		$date = date("Y-m-d\TH:i:s", strtotime($rdate));
		$html = make_xml_compatible($rdescription);
		$author = $row['informant'];

		GetData($rtitle,$link,$date,'',$html);

	}
	
	$db->sql_freeresult($result);



	/*\--------------[ BEGIN:  USV-Admin Content RSS ]---------------\*/
	break;
	case 'Message':
	$result = $db->sql_query("SELECT *
 			FROM ".$prefix."_stories  WHERE section='message' AND approved='1' 
 			ORDER BY sid DESC LIMIT ".FEED_LIMIT_PER_PAGE."");
	while($row = $db->sql_fetchrow($result)){
		$title = sql_quote($row['title']);
		$sid = sql_quote(intval($row['sid']));
		$slug_title = Slugit($title);
		if ($nextg==1) {
			$link = "".USV_DOMAIN."/article/$sid/$slug_title";
		}else {
			$link = "".USV_DOMAIN."/modules.php?name=News&file=article&sid=$sid&title=$slug_title";
		}

		$date = date("Y-m-d\TH:i:s", strtotime($row['time']));
		$html = make_xml_compatible($row['hometext']);
		$author = $row['informant'];

		GetData($title,$link,$date,$author,$html);

	}
	
	$db->sql_freeresult($result);
	case 'Pages':
	$result = $db->sql_query("SELECT *
 			FROM ".$prefix."_extpages  WHERE active='1' 
 			ORDER BY pid DESC LIMIT ".FEED_LIMIT_PER_PAGE."");
	while($row = $db->sql_fetchrow($result)){
		$title = sql_quote($row['title']);
		$pid = sql_quote(intval($row['pid']));
		$slug_title = Slugit($row['slug']);
		if ($nextg==1) {
			$link = "".USV_DOMAIN."/Pages/$slug_title";
		}else {
			$link = "".USV_DOMAIN."/modules.php?name=Pages&term=$slug_title";
		}

		$date = date("Y-m-d\TH:i:s", strtotime($row['post_time']));
		$html = make_xml_compatible($row['text']);

		GetData($title,$link,$date,'',$html);

	}
	
	$db->sql_freeresult($result);

	/*\--------------[ BEGIN:  USV-Admin Last Comment RSS ]---------------\*/
	break;
	case 'Comment':
	$result = $db->sql_query("SELECT * FROM " . $prefix . "_comments_moderated WHERE `active`='1' ORDER BY `date` DESC LIMIT ".FEED_LIMIT_PER_PAGE."");
	while ($row = $db->sql_fetchrow($result)) {
		$tid = intval($row['tid']);
		$comment = $row['comment'];
		$newdate = $row['date'];
		$title = sql_quote($row['title']);
		$sid = sql_quote(intval($row['sid']));
		$slug_title = Slugit($title);
		if ($nextg==1) {
			$link = "".USV_DOMAIN."/article/$sid/$slug_title";
		}else {
			$link = "".USV_DOMAIN."/modules.php?name=News&file=article&sid=$sid&title=$slug_title";
		}

		GetData($title,$link,$date,'',make_xml_compatible($comment));

	}
	
	$db->sql_freeresult($result);


	/*\--------------[ BEGIN:  USV-Admin Forums RSS ]---------------\*/
	break;
	case 'Forums':

	/*\--------------[ BEGIN:  USV-Admin News RSS ]---------------\*/
	$tsql = "SELECT t.topic_id, t.topic_title,topic_poster,t.topic_last_post_id,f.forum_id,f.forum_name, f.forum_desc_options
	FROM ".TOPICS_TABLE." t, ".FORUMS_TABLE." f where t.forum_id=f.forum_id AND

	t.topic_status != 1
	AND topic_approved != 0 
	AND topic_approved = 1
	AND t.forum_id !=9
	AND t.forum_id !=12
	AND t.forum_id !=14
	AND t.forum_id !=22
	
		
	AND (topic_moved_id = 0 or topic_moved_id='') 
	ORDER BY t.topic_last_post_id DESC LIMIT 0,20";

	$result = $db->sql_query($tsql);
	if (!$result) {
		show_error("RSS Name You Entered Is Wrong");
	}else {
		while($row = $db->sql_fetchrow($result))
		{
			$forumid=$row['forum_id'];
			$topicid=$row['topic_id'];

			$row2 = $db->sql_fetchrow($db->sql_query("SELECT post_id,poster_id,post_time,post_text,bbcode_uid,bbcode_bitfield FROM   ".POSTS_TABLE."  where post_id ='".$row['topic_last_post_id']."'"));
			$row3 = $db->sql_fetchrow($db->sql_query("SELECT user_id,username  FROM   ".USERS_TABLE."  where user_id ='".$row2['poster_id']."'"));

			$post_text2 = $row2['post_text'];
			$post_text2 = nl2br($post_text2);

			$mydate = ($row2['post_time']) + (3.5 * 3600);
			$monthnum = array ( Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep , Oct, Nov, Dec);

			$date = gmdate("Y-m-d-D-H-i-s", $mydate);
			list($year, $month, $day, $day2, $hour, $min, $sec) = preg_split ('/-/' , $date);
			$post_date = $day2.", ".$day." ".$monthnum[$month-1]." ".$year ." ". $hour .":". $min .":". $sec ;



			$title = $row['topic_title'];
			$link = "modules.php?name=phpBB3&file=viewtopic&t=$topicid";
			$html = make_xml_compatible($post_text2);
			$author = $row3['username'];

			GetData($title,$link,$post_date,$author,$html);


		}
	}
	break;
	case 'Blog':
	$username = sql_quote($_GET['username']);
	$sql_query = "
SELECT b.bid,b.content,b.reciever_name,b.date,b.sender AS sender_id,b.reciever AS receiver_id,
IFNULL(us.username, ur.username) AS sender_name,
IFNULL(ur.username, us.username) AS receiver_name
FROM ".$prefix."_blogs AS b
LEFT JOIN ".$prefix."_users AS us ON us.user_id = b.sender
LEFT JOIN ".$prefix."_users AS ur ON ur.user_id = b.reciever
WHERE us.username = '$username'
ORDER BY b.bid DESC
 LIMIT ".FEED_LIMIT_PER_PAGE."
";
	$result = $db->sql_query($sql_query);
	while($row = $db->sql_fetchrow($result)){
		$content = sql_quote($row['content']);
		$sender_name = sql_quote($row['sender_name']);
		$reciever_name  = sql_quote($row['reciever_name']);

		$date = date("Y-m-d\TH:i:s", strtotime($row['date']));
		$html = make_xml_compatible($content);
		$link = "modules.php?name=Your_Account&op=userinfo&username=$reciever_name";
		GetData($title,$link,$date,$sender_name,$html);

	}
	$db->sql_freeresult($result);
	break;
	
}

	$feeds->display();
}
catch(FeedGeneratorException $e){
	echo 'Error: '.$e->getMessage();
}
?>