<?php

/**
*
* @package Total Hits												
* @version $Id:  1:00 PM 5/29/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
*
*/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $startdate, $db;

list($ipid) = $db->sql_fetchrow($db->sql_query("SELECT ipid FROM ".$prefix."_iptracking ORDER BY ipid DESC"));
$content = "<font class=\"tiny\"><center>"._WERECEIVED."<br><b>$ipid</b><br>"._PAGESVIEWS."</center></font>";

?>