<?php
/**
*
* @package TAG Cloud Block														
* @version $Id: 2009-12-12 15:35:19Z JAMES $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(stripos($_SERVER['SCRIPT_NAME'],'block-Tag_Cloud.php')){
die("Illegal Access!");
}
global $db,$prefix;
function tag_size($count,$total,$slug,$tag){
$percent = floor((($count / $total) * 30) + 10);
return '<span style="font-size: '.$percent.'px;"><a href="modules.php?name=News&file=tags&tag='.$slug.'" title="'.$count.'' . _TAGCLOUD_NEWS . '">'.$tag.'</a></span> ';
}
list($total) = $db->sql_fetchrow($db->sql_query('SELECT SUM(count) FROM `'.TAGS_TABLE.'` LIMIT 1'));

$result = $db->sql_query("SELECT t.*,s.* FROM `".TAGS_TABLE."` AS t
LEFT JOIN `".STORY_TABLE."` AS s ON FIND_IN_SET(t.tid, REPLACE(s.tags, ' ', ','))
GROUP BY t.tag
ORDER BY t.count DESC 
LIMIT 12");

$content = '<div class="tag-cloud">';
while($row = $db->sql_fetchrow($result)){
$content .= tag_size($row['count'],$total,$row['slug'],$row['tag']);
}
$content .= '</div>';
?>
