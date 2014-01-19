<?php
/**
*
* @package BlogRoll														
* @version $Id: BlogRoll.php RC-7 4:09 PM 1/16/2010 $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}
$max = 15;
global $db,$prefix;
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
$result = $db->sql_query($sql_query);
$content .= '
<div class="blog-posts">
<marquee id="blogroll" behavior="scroll" direction="up" scrollamount="1" scrolldelay="5" onmouseover="this.stop();" onmouseout="this.start();" >';
while($r = $db->sql_fetchrow($result)){
$date = hejridate($r['date'],1,3); 
$text = substr(strip_tags(trim(nl2br($r['content']))),0,150)."...";
$rid = (empty($r['tid'])? $r['bid'] : $r['tid'] );
	$content .= '<p style="padding:9px;">
	'.$r['sender_name'].'<small>|'.$date.'</small> <br />';
	$content .= '<img src="images/icon/bullet_feed.png"><a href="modules.php?name=Your_Account&op=show_post&bid='.$rid.'">'.$text.'</a> 	</p>';
}
$content .= '
</marquee>
</div>
<br />
<a href="modules.php?name=Your_Account"><img src="images/icon/note_add.png" title="' . _BLOGPOSTS_BLOGPOST .'">' . _ADD .'</a>';

?>