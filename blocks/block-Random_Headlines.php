<?php
/**
 *
 * @package Block                                                        
 * @version $Id: Random Headlines 4:09 PM 1/16/2010 $Aneeshtan                        
 * @copyright (c) Marlik Group  http://www.nukelearn.com                                            
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */
if (!defined('BLOCK_FILE'))
    {
    Header("Location: ../index.php");
    die();
    }
global $prefix, $multilingual, $currentlang, $db, $tipath, $user, $cookie, $userinfo;
getusrinfo($user);
if (!isset($mode) OR empty($mode))
    {
    if (isset($userinfo['umode']))
        {
        $mode = $userinfo['umode'];
        }
    else
        {
        $mode = "thread";
        }
    }
if (!isset($order) OR empty($order))
    {
    if (isset($userinfo['uorder']))
        {
        $order = $userinfo['uorder'];
        }
    else
        {
        $order = 0;
        }
    }
if (!isset($thold) OR empty($thold))
    {
    if (isset($userinfo['thold']))
        {
        $thold = $userinfo['thold'];
        }
    else
        {
        $thold = 0;
        }
    }
$r_options = "";
$r_options .= "&amp;mode=" . $mode;
$r_options .= "&amp;order=" . $order;
$r_options .= "&amp;thold=" . $thold;
if ($multilingual == 1)
    {
    $querylang = "AND (alanguage='$currentlang' OR alanguage='')";
    /* the OR is needed to display stories who are posted to ALL languages */
    }
else
    {
    $querylang = "";
    }
$sql     = "SELECT * FROM " . $prefix . "_topics";
$query   = $db->sql_query($sql);
$numrows = $db->sql_numrows($query);
if ($numrows > 1)
    {
    $sql    = "SELECT topicid FROM " . $prefix . "_topics";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result))
        {
        $topicid = intval($row['topicid']);
        $topic_array .= "$topicid-";
        }
    $r_topic = explode("-", $topic_array);
    mt_srand((double) microtime() * 1000000);
    $numrows = $numrows - 1;
    $topic   = mt_rand(0, $numrows);
    $topic   = $r_topic[$topic];
    }
else
    {
    $topic = 1;
    }
$sql2       = "SELECT topicid,topicimage,slug,topictext FROM " . $prefix . "_topics WHERE topicid='" . sql_quote($topic) . "'";
$query2     = $db->sql_query($sql2);
$row2       = $db->sql_fetchrow($query2);
$topicid    = intval($row2['topicid']);
$topicimage = check_html($row2['topicimage'], "nohtml");
$topictext  = check_html($row2['topictext'], "nohtml");
$topicslug  = sql_quote($row2['slug']);
$topicimage = (empty($topicimage) ? "AllTopics.gif" : (!file_exists($topicimage) ? "AllTopics.gif" : $topicimage));
$ctime      = date("Y-m-j H:i-1:s");
$content    = "<br><center><a href=\"modules.php?name=News&file=categories&category=$topicslug\"><img src=\"$tipath$topicimage\" border=\"0\" alt=\"$topictext\" title=\"$topictext\"><br>$topictext</a><br>
</center><br><a href=\"modules.php?name=Search&amp;query=$topictext\"><img src='images/icon/note.png'>" . _SEARCH . " : $topictext</a> <br><hr>";
$content .= "<table border=\"0\" width=\"100%\">";
$sql3    = "SELECT sid, title FROM " . $prefix . "_stories WHERE FIND_IN_SET($topicid, REPLACE(associated, '-', ',')) $querylang AND  time <= '$ctime'  AND  section='news' AND approved='1' AND title!='draft' ORDER BY sid DESC LIMIT 0,9";
$result3 = $db->sql_query($sql3);
while ($row3 = $db->sql_fetchrow($result3))
    {
    $sid   = intval($row3['sid']);
    $title = check_html($row3['title'], "nohtml");
    $content .= "<tr><td valign=\"top\"><img src='images/icon/bullet_star.png'></td><td><a href=\"modules.php?name=News&file=article&sid=$sid&title=$title\">$title</a></td></tr>";
    }
$content .= "</table>";
?>