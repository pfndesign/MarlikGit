<?php
/* ===========================
/*                   www.nukelearn.com   
/*                   Farshad Ghazanfari    
/***************************************/

if ( !defined('BLOCK_FILE') ) {
    Header('Location: ../index.php');
    die();
}

$content .= "<div>";
		global $prefix, $db,$admin;
$sql_query = "SELECT * FROM ".$prefix."_extpages  ORDER BY pid DESC LIMIT 0,7 ";
    $result = $db->sql_query ($sql_query);
    while ($row = $db->sql_fetchrow($result)) {
    	 $pid = sql_quote(intval($row['pid']));
    	 $title = sql_quote($row['title']);
    	 $slug = $row['slug'];
   		 $post_time = sql_quote(formatTimestamp($row['post_time']));
		 $slugortitle = (!empty($row['slug']) ? "".$row['slug']."" : "".$row['pid']."");
   		 $page_link = "modules.php?name=Pages&amp;term=$slugortitle";

  $content .= "<p><img src='images/icon/bullet_green.png'><a href='$page_link'>$title</a><p> "; 
    }
$content .= "</div>";

?>