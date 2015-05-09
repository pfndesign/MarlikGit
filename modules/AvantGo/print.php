<?php

/**
*
* @package News Module	- index file												
* @version $Id:  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

if(!isset($sid)) {
    exit();
}

function PrintPage($sid) {
    global $site_logo, $nukeurl,$topic, $topicname, $topicimage, $topictext,$currentlang, $sitename, $prefix, $db, $module_name, $ThemeSel, $nextg;
    $sid = intval($sid);
    $row = $db->sql_fetchrow($db->sql_query("SELECT title, time, hometext, bodytext, topic, notes FROM ".$prefix."_stories WHERE sid='$sid'"));
    $title = check_words(check_html($row['title'], "nohtml"));
    $time = $row['time'];
    $hometext = check_words(check_html($row['hometext'], ""));
    $bodytext = check_words(check_html($row['bodytext'], ""));
    $topic = intval($row['topic']);
    $topic = intval($row['topic']);
    $time = $row['time'];
	$datetime = hejridate($time);	
	if ($currentlang == "persian"){$times="$datetime";}else {$times="$time";}
    $notes = check_words(check_html($row['notes'], ""));
    $row2 = $db->sql_fetchrow($db->sql_query("SELECT topictext FROM ".$prefix."_topics WHERE topicid='$topic'"));
	getTopics($sid);
	StoryInfo($sid);
    formatTimestamp($time);
    echo "<html>
	    <head>\n
        <title>$sitename - $title</title>\n
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n
        <LINK REL=\"StyleSheet\" HREF=\"themes/$ThemeSel/style/style.css\" TYPE=\"text/css\">\n
        </head>\n
	    <body>
	    <center>
	    <div style='color:black;background:white;border:1px solid black;width:60%;text-align:right;margin:0px auto;padding:30px;direction:".langstyle(direction)."'>
	    <img src=\"images/$site_logo\" border=\"0\" alt=\"\"><br><br>
	    <font class=\"content\">
	    <b>$title</b>
	    </font>
	    <br>
	    <font class=tiny><b>"._PDATE."</b> $times <br><b>"._PTOPIC."</b> $topicname</font><br><br>
	    <font class=\"content\">
	    $hometext<br><br>
	    $bodytext<br><br>
	    $notes<br><br>
	    </font>
	    <br><br>
	    "._COMESFROM." $sitename<br>
	    <a href=\"".USV_DOMAIN."\">".USV_DOMAIN."</a><br><br>
	    "._THEURL."<br>
	    <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."\"><br>
	    <div style='direction:ltr;'>".USV_DOMAIN."/modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Deslug($title)."</div>
	    </a>
	    </div>
	    </center>
	    </body>
	    </html>";
    die();
}

PrintPage($sid);

?>