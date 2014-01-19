<?php
/**
*
* @package block-comments														
* @version $Id: 0999 2009-12-13 Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if ( !defined('BLOCK_FILE') ) {
    Header('Location: ../index.php');
    die();
}


	$content .= "<div>";
		global $prefix, $db,$admin;
$sql_query = "SELECT * FROM ".$prefix."_comments_moderated WHERE active='1'  ORDER BY pid DESC LIMIT 0,5 ";
    $result = $db->sql_query ($sql_query);
	    if($db->sql_numrows($result) > 0){
		while ($row = $db->sql_fetchrow($result)) {
    	 $sid = intval($row['sid']);
    	 $name = check_html(htmlspecialchars(($row['name'])));
    	 $comment = check_html(htmlspecialchars(($row['comment'])));
    	 $comment = substr($comment, 0, 90) . '...';
   		 $post_time = hejridate($row['date'],4,2);

   		 
  $content .= "<strong><big>�</big></strong><a href='article$sid.html'>$comment</a><font color='gray'> $name : $post_time</font><br> "; 
    }
		}else{
		$content .= _NO_COMMENTS;
		}
    $db->sql_freeresult($result);

$content .= "</div>";


?>