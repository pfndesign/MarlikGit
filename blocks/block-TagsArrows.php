<?php
/**
*
* @package TAG Cloud Block														
* @version $Id: 2009-12-12 15:35:19Z JAMES $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(stripos($_SERVER['SCRIPT_NAME'],'block-Tag_Cloud.php')){
	die("Illegal Access!");
}
global $db,$prefix;

$content .= '
<style type="text/css">
.taglist{position:relative;}
.taglist a{display:block;float:left;white-space:nowrap;background-image:url(images/articles/tagbackgr.gif);background-position:top right;background-color:#e5f1ff;background-repeat:no-repeat;margin-right:5px;margin-bottom:5px;line-height:1.2;padding:2px 12px 4px 6px}
.taglist a:hover{background-color:#ccdff5}
.taglist a.ontag{background-color:#1975e1;color:#FFF}
.taglist a small{color:#7bb0ef;font-size:12px}
</style>
';

$result = $db->sql_query("SELECT t.*,s.* FROM `".TAGS_TABLE."` AS t
LEFT JOIN `".STORY_TABLE."` AS s ON FIND_IN_SET(t.tid, REPLACE(s.tags, ' ', ','))
GROUP BY t.tag
ORDER BY t.count DESC 
LIMIT 12");

$content .= '<div class="taglist">';
while($row = $db->sql_fetchrow($result)){
	$content .= '<a href="modules.php?name=News&amp;file=tags&amp;tag='.$row[slug].'" title="'.$row[tag].'"> '.$row[tag].' </a>';
}
$content .= '</div><div style="clear:both"" ></div>';

$db->sql_freeresult($result);
?>