<?php

/**
*
* @package Blog posts														
* @version $Id: 12:36 PM 6/9/2010 Checked BY Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $multilingual, $currentlang, $db;

if ($multilingual == 1) {
    $querylang = "AND (alanguage='$currentlang' OR alanguage='')";
} else {
    $querylang = "";
}
$content = "<div><ol>";
$result = $db->sql_query("SELECT sid, title, comments, counter FROM " . $prefix . "_stories WHERE time<=now() AND  section='news' AND approved='1' $querylang ORDER BY sid DESC LIMIT 0,5");
while ($row = $db->sql_fetchrow($result)) {
    $sid = intval($row['sid']);
    $title = check_html($row['title'], "nohtml");
    $comtotal = intval($row['comments']);
    $counter = intval($row['counter']);
    $content .= "<li>";
    $content .= " <a href=\"modules.php?name=News&amp;file=article&amp;sid=".$sid."\">$title</a>";
    $content .= "</li>";
}
$content .= "</ol></div>";
$content .= "<br><center>[ <a href=\"modules.php?name=News\">"._MORENEWS."</a> ]</center>";

?>