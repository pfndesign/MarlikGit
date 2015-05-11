<?php

/**
*
* @package Top 10 Download List Block 												
* @version $Id:  11:02 AM 5/23/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
*
*/
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $db;

$a = 1;
$result = $db->sql_query("SELECT lid, title FROM ".$prefix."_downloads_downloads ORDER BY hits DESC LIMIT 0,10");
while ($row = $db->sql_fetchrow($result)) {
    $lid = intval($row['lid']);
    $title = check_html($row['title'], "nohtml");
    $title2 = str_replace("_", " ", $title);
    $content .= "<strong><big>&middot;</big></strong>&nbsp;$a: <a href=\"modules.php?name=Downloads&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($title)."\">$title2</a><br>";
    $a++;
}

?>