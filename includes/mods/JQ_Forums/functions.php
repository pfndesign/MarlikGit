<?php
/**
*
* @package phpBB3 Latest Forum Block with advanced Jquery Pagination												
* @version $Id:  1:00 PM 5/29/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com	
* This program is NOT a free software. You can NOT redistribute it and/or modify										
*
*/


function mybbslugit($message)
{
	
	$title = strip_tags($message);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	//$title = remove_accents($title);
	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}
		$title = utf8_uri_encode($title, 500);
	}

	$title = strtolower($title);
	$title = preg_replace('/[^%a-z0-9]/', '-', $title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '-', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');
	$message = preg_replace("#&(?!\#[0-9]+;)#si", "&amp;", $title); // Fix & but allow unicode
	$message = str_replace("<", "&lt;", $message);
	$message = str_replace(">", "&gt;", $message);
	$message = str_replace("\"", "&quot;", $message);
	
	
	return $message;
}


function JQ_Forums_PAGE($page){
	
global $prefix, $multilingual, $currentlang, $db, $tipath, $user, $cookie, $userinfo;

$TopicsPerPage = 20;


if (!is_numeric($page)) {
	die("ورودی صفحه شما معتبر نمی باشد ");
}
/*--- FORUMS CONSTANTS :
// 
*/
$TopicsPerPage  = 15; // change this if you are seeking to view more topics
//---------------------

$count = $db->sql_query("SELECT tid FROM mybb_threads order by lastpost");
$forumspost = $db->sql_numrows($count);
$totalpages = ceil($forumspost / $TopicsPerPage);

if ($page > $totalpages ) {
	$page = $totalpages;
}
	
$offset = ($page-1) * $TopicsPerPage ;

	
// When set to 1 then Forums permissions which View and/or Read are NOT set to 'ALL' will NOT be displayed in the center block


//Here we should samrt enought to union all these counts
//First Thing to do is build a nice joined mysql query
//Now We go :
$result = $db->sql_query("SELECT threads.tid,threads.subject,threads.lastposter,threads.replies,threads.views,threads.lastposteruid,
users.username, users.usergroup, users.displaygroup
FROM mybb_threads AS threads  left join mybb_users AS users ON threads.lastposteruid=users.uid  ORDER BY threads.lastpost DESC LIMIT $offset,$TopicsPerPage
"
);

$TopicsPerPage ="";
while( $row = $db->sql_fetchrow($result) )
{
	$replycount = $row['replies'];
	$views = $row['views'];
	$threadid = $row['tid'];
	$poster = $row['lastposter'];
	$title = $row['subject'];
	$lastposteruid = $row['lastposteruid'];



	$TopicImage = "&nbsp;<img border=0 src=\"images/icon/bullet_star.png\">";
/*

     $lastposter_query = $db->query("SELECT username, usergroup, displaygroup FROM ".TABLE_PREFIX."users WHERE uid='".$lastpost_data['lastposteruid']."'");
                       $lastposter_format = $db->fetch_array($lastposter_query);
                     $lastposter = format_name($lastposter_format['username'], $lastposter_format['usergroup'], $lastposter_format['displaygroup']);
                    $lastpost_profilelink = build_profile_link($lastposter, $lastpost_data['lastposteruid']); 
					
					SELECT tid,subject,lastposter,replies,views,lastposteruid FROM mybb_threads order by lastpost DESC LIMIT $offset,$TopicsPerPage

*/

	$TopicTitleShow = "<a  style='color:#666666;' href=\"forums/Thread-" . mybbslugit($title) ."--$threadid?action=lastpost\">$title</a>";

	$Topic_Buffer .= "<tr onmouseover=\"this.style.backgroundColor='#FFFFB9';\" onmouseout=\"this.style.backgroundColor='#FBFEFF';\"  onclick=\"this.style.backgroundColor='#FFFF0D';\" class='topicRow'><td class='rowBG' >$TopicImage $TopicTitleShow</td><td class='rowBG' align=\"center\">$views</td><td class='rowBG' align=\"center\">$replycount</td>
	<td class='rowBG'  align=\"center\"><a href='forums/User-" . mybbslugit($poster) ."--$lastposteruid'>$poster</a></td></tr>";

}

$prevIMG='<span style="color:666666;padding:10px;"><a  class="button" id="prevPage" style="color:666666;"href="javascript:changePage()">قبلی </a></span>';
$nextIMG='<span ><a class="button" href="javascript:changePage()"  id="nextPage" > بعدی </a></span>';




/* Write Table to Screen */
$latestForums = "";
$latestForums .= "<table width=\"100%\" id='ForumsDiv'>";
$latestForums .= "<tr class='topicRow'><td class='rowBG' >عنوان </td><td class='rowBG' align=\"center\">بازدید</td><td class='rowBG' align=\"center\">پاسخ ها</td>
<td class='rowBG'  align=\"center\">آخرین ارسال</td></tr>";
$latestForums .= "$Topic_Buffer";
$latestForums .= "</table>";
$latestForums .= "<br>
صفحه کنونی : <b>".Convertnumber2farsi($page)."</b> / کل صفحات :<b> ". Convertnumber2farsi($totalpages)."</b>";

return  $latestForums;

}

?>