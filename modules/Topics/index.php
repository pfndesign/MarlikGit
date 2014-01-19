<?php
/**
*
* @package Topic INDEX														
* @version $Id: 8:02 PM 3/25/2012 Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
*
* 
*/
if ( !defined("MODULE_FILE") )
{
    die("You can't access this file directly...");
}
define('INDEX_FILE', true);
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- "._ACTIVETOPICS."";
include("header.php");
OpenTable();

global $db, $prefix,$pagenum, $tipath;
$ThemeSel = get_theme();

$sql = "SELECT t.*,s.sid,s.counter,s.associated,s.title,SUM(s.counter) as totreads ,COUNT(s.sid) as totstories FROM ".$prefix."_topics t LEFT JOIN ".$prefix."_stories s ON  FIND_IN_SET(t.topicid, REPLACE(s.associated, '-', ',')) GROUP BY t.topicid, t.topicimage, t.topictext ORDER BY t.topictext";
$totalnum = $db->sql_numrows($db->sql_query($sql));
$ppage = 20;
$cpage = (empty($pagenum)) ? 1 : $pagenum;
$offset  = ($cpage * $ppage) - $ppage;
$sql .= " LIMIT $offset, $ppage";

$result = $db->sql_query($sql);

if ($db->sql_numrows($result) > 0) {
    $output = "<center><font class=\"title\"><b><a href='modules.php?name=Topics'>"._ACTIVETOPICS."</a></b></font><br>\n";
    $output .= "<font class=\"content\">"._CLICK2LIST."</font><br><br>\n";
    $output .= "<form action=\"modules.php?name=Search\" method=\"post\">";
    $output .= "<input type=\"name\" name=\"query\" size=\"30\">  ";
    $output .= "<input type=\"submit\" value=\""._SEARCH."\">";
    $output .= "</form></center><br><br>";
    echo $output;
    while ($row = $db->sql_fetchrow($result)) {
        $topicid = intval($row['topicid']);
        $topicname  = check_html($row['topicname'], "nohtml");
        $topicimage = check_html($row['topicimage'], "nohtml");
        $topictext = check_html($row['topictext'], "nohtml");
        if(file_exists("themes/".$ThemeSel."/images/topics/".$topicimage)) {
          $t_image = "themes/".$ThemeSel."/";
        } else {
          $t_image = "";
        }
        $t_image = $t_image.$tipath.$topicimage;
        $output = "<h3><a href='modules.php?name=News&amp;file=categories&amp;category=".Slugit($row[slug])."'>$topicname </a></h3><table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"2\">\n";
        $output .= "<tr><td valign=\"top\" width=\"25%\">";
        $output .= "<a href='modules.php?name=News&amp;file=categories&amp;category=".Slugit($row[slug])."'>
        <img src=\"$t_image\" border=\"0\" alt=\"$topictext\" title=\"$topictext\" hspace='5' vspace='5'></a><br><br>\n";
        $output .= "</td><td valign=\"top\">";

        if (!empty($row['associated'])) {
            $sql2 = "SELECT *  FROM ".$prefix."_stories WHERE FIND_IN_SET('$topicid', REPLACE(associated, '-', ',')) ORDER BY sid DESC LIMIT 0,10";
            $result2 = $db->sql_query($sql2);
            while ($row2 = $db->sql_fetchrow($result2)) {
                $output .= "<img src=\"images/icon/bullet_green.png\" border=\"0\" alt=\"\" /> $cat_link
                <a href=\"modules.php?name=News&file=article&sid=".intval($row2['sid'])."&title=".Slugit($row2['title'])."\">".htmlspecialchars($row2['title'])."</a><br>";
            }
            if ($row['totstories'] > 10) {
                $output .= "<div align=\"right\"><strong>&middot;</strong> <a href=\"modules.php?name=News&file=categories&category=".$row['slug']."\"><img src='images/icon/link_go.png'><strong>"._MORE." --&gt;</strong></a></div>";
            }
        } else {
            $output .= "<p>"._NONEWSYET."</p>";
        }
        $output .= "</td></tr>";      
         $output .= "</table><br>";
       $output .= "<img src='images/icon/newspaper.png'>"._TOTNEWS.":<b> ".number_format(intval($row['totstories']))."</b>\n";
        $output .= "<img src='images/icon/lightning.png'>"._TOTREADS.":<b>".number_format(intval($row['totreads']))."</b>\n";
        OpenTable();
        echo $output;
        CloseTable();
    }
} else {
  echo "<i>"._NONEWSYET."</i>";
}

CloseTable();

OpenTable();
echo make_pagination(10,$totalnum,$ppage,$cpage,3,"modules.php?name=Topics&pagenum",'');
CloseTable();

include("footer.php");

?>