<?php
/**
*
* @package Blog posts														
* @version $Id: 0999 2009-12-13 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
if ( !defined('BLOCK_FILE') ) {
	Header('Location: ../index.php');
	die();
}

$content .= "<div id='blog_box' style='text-align:".langStyle(align)."'><b>". _BLOGPOSTS_LATESTPOSTS ."</b> :<br>";
global $prefix, $db,$userinfo;

$sql_query = "
SELECT b.bid,b.tid,b.content,b.date,b.sender AS sender_id,b.reciever AS receiver_id,
IFNULL(us.username, ur.username) AS sender_name,
IFNULL(ur.username, us.username) AS receiver_name
FROM ".$prefix."_blogs AS b
LEFT JOIN ".$prefix."_users AS us ON us.user_id = b.sender
LEFT JOIN ".$prefix."_users AS ur ON ur.user_id = b.reciever
ORDER BY b.bid DESC
limit 10
";
$result = $db->sql_query ($sql_query);
if (!$result) {
	die(mysql_error());
}
while ($row = $db->sql_fetchrow($result)) {
	$bid = intval($row['bid']);
	$sender = intval($row['sender']);
	$text = analyse_content($row['content'],1,1,1);
	$text = substr($text, 0, 90) . '...';
	$date = hejridate($r[date],1,3); 
	$rid = (empty($r['tid'])? $r['bid'] : $r['tid'] );
	$content .= "<img src='images/icon/bullet_orange.png' alt='--' title='" . _BLOGPOSTS_BLOGPOST ."'> <a href='modules.php?name=Your_Account&op=userinfo&username=".$row['receiver_name']."'>$text</a><br>
<font color='gray'> ".$row['sender_name']." : $post_time</font><br> ";
}

$content .= "</div><br>
<a href='modules.php?name=Your_Account&op=show_post&bid=".$rid."'><img src='images/icon/note_add.png' alt='--' title='" . _BLOGPOSTS_BLOGPOST ."'>" . _BLOGPOSTS_BLOGPOST . "</a>

";
$content .= "</div>";

?> 