<?php
if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php"))
{
	header("Location: ../../../index.php");
	die();
}
if (!defined('CNBYA'))
{
	echo "CNBYA protection";
	exit;
}
 if (is_active("phpBB3")) {
$prow = $db->sql_fetchrow( $db->sql_query("SELECT user_id FROM ".USERS_TABLE." WHERE  username='$owner_username' "));

$result8 = $db->sql_query(
"SELECT t.topic_last_post_id, t.topic_id, t.topic_title, t.topic_views, t.topic_replies, t.topic_time, t.topic_last_post_time, t.topic_first_poster_name, t.topic_last_poster_name,t.topic_last_poster_colour, t.topic_last_poster_id, topic_poster, t.forum_id

			    FROM ". $prefix ."_bb3topics t
			    LEFT JOIN " . $prefix ."_bb3forums f ON (t.forum_id = f.forum_id)
			    WHERE 	t.topic_poster='".$prow['user_id']."' and topic_approved != 0 AND topic_approved = 1 AND (topic_moved_id = 0 or topic_moved_id='')
			    GROUP BY t.topic_title
			    ORDER BY t.topic_last_post_id DESC limit 0,10"
                         );
if (($db->sql_numrows($result8) > 0))
{
	echo "<br>";
	OpenTable();
	echo "<b> ".$usrinfo['username']." آخرین فعالیت های انجمنی  :</b><br><br><hr>";
	while (list($topic_last_post_id, $topic_id, $topic_title, $topic_views, $topic_replies, $topic_time,
	      $topic_last_post_time, $topic_first_poster_name,
	      $topic_last_poster_name,$topic_last_poster_colour,$topic_last_poster_id, $topic_poster,
	      $forum_id) = $db->sql_fetchrow($result8))
	{

					$result9 = $db->sql_query("SELECT forum_name
     					    FROM ". $prefix ."_bb3forums
     					    WHERE forum_id='$forum_id'");
					list($forum_name)=$db->sql_fetchrow($result9);
					
					
if ($topic_last_poster_colour == "") {$topic_last_poster_colour = "000";}
			echo
			"<li><a href=\"modules.php?name=phpBB3&file=viewtopic&f=$forum_id&t=$tid\"  style='padding:2px;background:#".$topic_last_poster_colour.";color:#fff'>$forum_name</a> &#187; <a href=\"modules.php?name=phpBB3&file=viewtopic&t=$topic_id\">$topic_title <img src='images/minisquare.png' title='$topic_views مشاهده '> </a><br>
";
		
	}
	
	echo
			"<div style='float:left;text-align:left'>
<a href='#'  style='padding:2px;background:RED;color:RED' title='مدیران سایت'>&#187;</a>
<a href='#' style='padding:2px;background:Green;color:Green' title='مدیران انجمن'>&#187;</a>
<a href='#' style='padding:2px;background:Black;color:Black' title='بی پاسخ'>&#187;</a></div>";
	CloseTable();
}
}
?>