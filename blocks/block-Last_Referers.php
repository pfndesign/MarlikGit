<?php

/**
*
* @package Top 10 Referers List Block 												
* @version $Id:  11:02 AM 5/23/2010 Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
*
*/

if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $prefix, $db, $admin, $admin_file;



$ref = 10; // how many referers in block

$result = $db->sql_query("SELECT ipid,referer from ".$prefix."_iptracking WHERE referer!='' limit $ref ");
$num = $db->sql_numrows($result);
if ($num > 0) {
	OpenTable();
	$content .=  "<div style='border:0px; height:100px; padding-right:12px; overflow:auto;direction:ltr'><ul>";
	$content .=  "<center><b>" . _WHOLINKS . "</b></center><br>";
	while (list($id,$url) = $db->sql_fetchrow($result)) {
		$id = sql_quote(intval($id));
		$url = sql_quote($url);
		$url_name = substr ( $url, 0, 50 ) . '...';
		$content .=  "<li style='background:#CCF0FF;border:1px solid white;padding:5px;'>$rid <a href=\"$url\" target=\"_blank\">$url_name</a></li>
	";
	}


	if (is_admin($admin)) {
		$query = $db->sql_query("SELECT * FROM ".$prefix."_referer");
		$total = $db->sql_numrows($query);
		$content .= "<br><center>$total "._HTTPREFERERS."<br>[ <a href=\"".$admin_file.".php?op=delreferer\">"._DELETE."</a> ]</center>";
	}

}else {

	$content .=  "<div>ارجاع دهنده ای ثبت نشده است  </div>";

}


?>