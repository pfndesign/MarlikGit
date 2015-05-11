<?php

if (!defined('MODULE_FILE')) {
 	die ("You can't access this file directly...");
 }

 require_once("mainfile.php");
 $module_name = basename(dirname(__FILE__));
 get_lang($module_name);

 function avtgo() {
global $sitename, $slogan, $db, $prefix, $module_name, $site_logo, $Default_Theme;
if (file_exists("themes/$Default_Theme/images/logo.gif")) {
$avantgo_logo = "themes/$Default_Theme/images/logo.gif";
} elseif (file_exists("images/$site_logo")) {
$avantgo_logo = "images/$site_logo";
} elseif (file_exists("images/logo.gif")) {
$avantgo_logo = "images/logo.gif";
} else {
$avantgo_logo = "";
} 	header("Content-Type: text/html");
 	echo "<html>\n"
 	."<head>\n"
 	."<link rel='StyleSheet' href='".MODULES_PATH."AvantGo/avant.css' type='text/css' />\n" 	
 	."<title>$sitename - "._AVANTGO."</title>\n"
 	."<meta name=\"HandheldFriendly\" content=\"True\">\n"
 	."<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n"
 	."</head>\n"
 	."<body>\n\n\n"
 	."<h1>"._AVANTGO." $sitename</h1>"
 	."<div dir=\"rtl\" align=\"center\">\n";
 	$result = $db->sql_query("SELECT sid, title, time FROM ".$prefix."_stories  WHERE approved='1'  AND time<=now() ORDER BY sid DESC LIMIT 10");
 	if (empty($result)) {
 		echo "An error occured";
 	} else {
 		$a = 1 ;
    echo "\r\n"
 		."\t<table border=\"0\" align=\"center\" width='80%'>\r\n"
 		."\t\t<tr>\r\n"
 		."\t\t\t<td class='header-td' width='5%'>#</td>\r\n"
 		."\t\t\t<td class='header-td'>"._TITLE."</td>\r\n"
		 ."\t\t\t<td class='header-td'>"._PRINT."</td>\r\n"
 		."\t\t\t<td class='header-td'>"._DATE."</td>\r\n"
 		."\t\t</tr>\r\n";
 		for ($m=0; $m < $db->sql_numrows($result); $m++) {
 			$row = $db->sql_fetchrow($result);
 			$sid = intval($row['sid']);
 			$title = check_html($row['title'], "nohtml");
 			$time = $row['time'];
 			echo "\t\t<tr>\r\n"
 			."<td  class='bg-tr'>".$a++."</td>\n"
 			."\t\t\t<td  class='bg-tr'><a href=\"modules.php?name=$module_name&amp;op=ReadStory&amp;sid=$sid\">$title</a></td>\r\n"
 			 ."\t\t\t<td  class='bg-tr'><a href=\"modules.php?name=$module_name&amp;file=print&amp;sid=$sid\"><img src=\"images/icon/printer.png\" border=\"0\" alt=\""._PRINT."\"></a></td>\r\n"
			."\t\t\t<td  class='bg-tr'>" .  hejridate($time) . "</td>\r\n"
 			."\t\t</tr>\r\n";
 		}
 		echo"\t</table>\r\n";
 		
 		echo"<br><b>"._GOBACK."</b>";
 	}
 	echo "</body>\n"
 	."</html>";
 	include ("includes/inc_counter.php");
 	die();
 }

 function ReadStory($sid) {
 	global $site_logo, $nukeurl, $sitename, $currentlang, $prefix, $db, $module_name, $ThemeSel;
 	$sid = intval($sid);
 	$num = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_stories WHERE sid='$sid'  AND approved='1'  AND time<=now()"));
 	if ($num == 0) {
 		Header("Location: modules.php?name=$module_name");
 		die();
 	}
 	$sid = intval(trim($sid));
 	$row = $db->sql_fetchrow($db->sql_query("SELECT title, time, hometext, bodytext, topic, notes FROM ".$prefix."_stories WHERE sid='$sid'  AND approved='1'  AND time<=now()"));
 	$title = check_html($row['title'], "nohtml");
   	$time = $row['time'];
	$datetime = hejridate($time, 4, 9) ;	
	if ($currentlang == "persian"){$times="$datetime";}else {$times="$time";}
 	$hometext = check_html($row['hometext'], "");
 	$bodytext = check_html($row['bodytext'], "");
 	$topic = intval($row['topic']);
 	 $notes = check_html($row['notes'], "");
 	$row2 = $db->sql_fetchrow($db->sql_query("SELECT topictext FROM ".$prefix."_topics WHERE topicid='$topic'"));
 	$topictext = check_html($row2['topictext'], "nohtml");
 	formatTimestamp($time);
 	echo "
    <html>
    <head>
    <title>$sitename - $title</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <meta name=\"HandheldFriendly\" content=\"True\">
    </head>
    <body bgcolor=\"#ffffff\" text=\"#000000\">
    <table dir=\"rtl\" border=\"0\" align=\"center\"><tr><td>
    <table border=\"0\" width=\"640\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\"><tr><td>
    <table border=\"0\" width=\"640\" cellpadding=\"20\" cellspacing=\"1\" bgcolor=\"#ffffff\"><tr><td>
    
    <img src=\"images/$site_logo\" border=\"0\" alt=\"\"><br><br>
    <b>$title</b><br>
  <b>"._PDATE."</b> $times<br><b>"._PTOPIC."</b> $topictext<br><br>
    
    $hometext<br><br>
    $bodytext<br><br>
    $notes<br><br>
    
    </td></tr></table></td></tr></table>
    <br><br>
    "._COMESFROM." $sitename<br>
    <a href=\"$nukeurl\">$nukeurl</a><br><br>
    "._THEURL."<br>
    <a href=\"$nukeurl/modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."\">$nukeurl/modules.php?name=News&amp;file=article&amp;sid=$sid</a><br><br><a href=\"http://www.MarlikCMS.com\" target=\"_blank\">MarlikCMS USV © 2009-2011 MarlikCMS

    
    </td></tr></table>
    </body>
    </html>
    ";
 }

 switch($op) {

 	case "ReadStory":
 	ReadStory($sid);
 	break;

 	default:
 	avtgo();
 	break;
 }

?>