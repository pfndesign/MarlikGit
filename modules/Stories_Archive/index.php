<?php
if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}
define('INDEX_FILE', true);
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

function select_month() {
    global $prefix, $user_prefix, $db, $module_name, $j_month_name;
    include("header.php");

    OpenTable();
    echo "<center><font class=\"content\">"._SELECTMONTH2VIEW."</font><br><br></center><br><br>";
    $result = $db->sql_query("SELECT time from ".$prefix."_stories Where time<=now() AND  section='news' AND approved='1' order by time DESC");
    echo "<ul>";
	$thismonth = "";
    while($row = $db->sql_fetchrow($result)) {
	  $time = $row['time'];
        $hejri_temp = hejridate($time, 4, 8);
        list($hyear , $hmonth, $hday) = explode("-", $hejri_temp);
        $month = $j_month_name[$hmonth];
        if ($month != $thismonth) {
            $year = $hyear;
            echo "<li><a href=\"modules.php?name=$module_name&amp;sa=show_month&amp;year=$year&amp;month=$hmonth\">$month, $year</a>";
            $thismonth = $month;
        }
    }
    echo "</ul>"
        ."<br><br><br><center>"
        ."<form action=\"modules.php?name=Search\" method=\"post\">"
        ."<input type=\"text\" name=\"query\" size=\"30\">&nbsp;"
        ."<input type=\"submit\" value=\""._SEARCH."\">"
        ."</form><br><br>"        
        ."[ <a href=\"modules.php?name=$module_name&amp;sa=show_all\">"._SHOWALLSTORIES."</a> ]</center>";
    CloseTable();
    include("footer.php");
}

function show_month($year, $month) {
     global $prefix, $user_prefix, $db, $bgcolor1, $bgcolor2, $user, $cookie, $sitename, $multilingual, $language, $module_name, $articlecomm, $j_month_name, $j_days_in_month;
        $year = intval($year);
        $month = htmlentities($month);
        $month_l = $j_month_name[$month];
    include("header.php");
    title(_STORIESARCHIVE." $month_l $year");
    $r_options = "";
    if (isset($cookie[4])) { $r_options .= "&amp;mode=$cookie[4]"; }
    if (isset($cookie[5])) { $r_options .= "&amp;order=$cookie[5]"; }
    if (isset($cookie[6])) { $r_options .= "&amp;thold=$cookie[6]"; }
    OpenTable();
    ?><style type="text/css">.row1{background:#CEE5EF;}.row2{background:#E1EAED;line-height:19px;}</style><?php 
    echo "<table border=\"0\" width=\"100%\"><tr class='row1'>"
                ."<td bgcolor=\"$bgcolor2\" align=\"right\"><b>"._ARTICLES."</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._COMMENT."</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._READS."</b></td>"
                //."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._USCORE."</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._DATE."</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._ACTIONS."</b></td></tr>";
        //convert hejri date to gregorian date
        $start_date = $year . "-" . $month . "-01";
        $start_date = hejriback($start_date, 2, 2);
        $end_date = $year . "-" . $month . "-" . $j_days_in_month[$month-1];
        $end_date = hejriback($end_date, 2, 2);
        
        $result = $db->sql_query("SELECT sid, catid, title, time, comments, counter, topic, alanguage from ".$prefix."_stories WHERE section = 'news' AND approved = 1 AND  time >= '$start_date 00:00:00' AND time <= '$end_date 23:59:59' order by sid DESC");
    while ($row = $db->sql_fetchrow($result)) {
                $sid = intval($row['sid']);
                $catid = intval($row['catid']);
                $title = stripslashes(check_words(check_html($row['title'], "nohtml")));
                $time = $row['time'];
                $comments = stripslashes($row['comments']);
                $counter = intval($row['counter']);
                $topic = intval($row['topic']);
                $alanguage = $row['alanguage'];
                $time = explode(" ", $time);
                $actions = "<a href=\"modules.php?name=News&amp;file=print&amp;sid=$sid\">
                <img src=\"images/icon/printer.png\" border=0 alt=\""._PRINTER."\" title=\""._PRINTER."\" width=\"16\" height=\"11\"></a>&nbsp;
                <a href=\"modules.php?name=News&amp;file=friend&amp;op=FriendSend&amp;sid=$sid\">
                <img src=\"images/icon/email.png\" border=0 alt=\""._FRIEND."\" title=\""._FRIEND."\" width=\"16\" height=\"11\"></a>";

                if ($catid == 0) {
                    $title = "<a href=\"modules.php?name=News&file=article&sid=$sid&title=".Slugit($title)."$r_options\">$title</a>";
                } elseif ($catid != 0) {
                    $row_res = $db->sql_fetchrow($db->sql_query("SELECT title from ".$prefix."_stories_cat where catid='$catid'"));
                    $cat_title = stripslashes($row_res['title']);
                    $title = "<a href=\"modules.php?name=News&amp;file=categories&amp;op=newindex&amp;catid=$catid\"><i>$cat_title</i></a>: <a href=\"modules.php?name=News&file=article&sid=$sid&title=".Slugit($title)."\">$title</a>";
                }
/*
                if ($multilingual == 1) {
                    if (empty($alanguage)) {
                        $alanguage = $language;
                    }
                    $alt_language = ucfirst($alanguage);
                    $lang_img = "<img src=\"images/language/flag-$alanguage.png\" border=\"0\" hspace=\"2\" alt=\"$alt_language\" title=\"$alt_language\">";
                } else {
                    $lang_img = "<strong><big><b>&middot;</b></big></strong>";
                }
               */ 
                
                if ($articlecomm == 0) {
                    $comments = 0;
                }
                echo "<tr class='row2'>"
                    ."<td bgcolor=\"$bgcolor1\" align=\"right\">$lang_img $title</td>"
                    ."<td bgcolor=\"$bgcolor1\" align=\"center\">$comments</td>"
                    ."<td bgcolor=\"$bgcolor1\" align=\"center\">$counter</td>"
                   // ."<td bgcolor=\"$bgcolor1\" align=\"center\">".pullRating(1,$storyinfo[rate],$storyinfo[rates_count],$sid,false,false,false);."</td>"
                    ."<td bgcolor=\"$bgcolor1\" align=\"center\">" . hejridate($time[0], 1, 3) . "</td>"
                    ."<td bgcolor=\"$bgcolor1\" align=\"center\">$actions</td></tr>";
    }
    echo "</table>"
        ."<br><br><br><hr size=\"1\" noshade>"
        ."<font class=\"content\">"._SELECTMONTH2VIEW."</font><br>";
    $result2 = $db->sql_query("SELECT time from ".$prefix."_stories order by time DESC");
    echo "<ul>";
    while($row2 = $db->sql_fetchrow($result2)) {
        $time = $row2['time'];
        $hejri_temp = hejridate($time, 4, 8);
        list($hyear , $hmonth, $hday) = explode("-", $hejri_temp);
        $month = $j_month_name[$hmonth];
        if ($month != $thismonth) {
            $year = $hyear;
            echo "<li><a href=\"modules.php?name=$module_name&amp;sa=show_month&amp;year=$year&amp;month=$hmonth\">$month, $year</a>";
            $thismonth = $month;
        }
    }
    echo "</ul><br><br><center>"
        ."<form action=\"modules.php?name=Search\" method=\"post\">"
        ."<input type=\"text\" name=\"query\" size=\"30\" class='text' >&nbsp;"
        ."<input type=\"submit\" value=\""._SEARCH."\">"
        ."</form><br /><br />"
        ."[ <a href=\"modules.php?name=$module_name\">"._ARCHIVESINDEX."</a> | <a href=\"modules.php?name=$module_name&amp;sa=show_all\">"._SHOWALLSTORIES."</a> ]</center>";
    CloseTable();
    include("footer.php");
}

function show_all($min) {
    global $prefix, $user_prefix, $db, $bgcolor1, $bgcolor2, $user, $cookie, $sitename, $multilingual, $language, $module_name, $j_month_name;
    if (!isset($min)) {
	$min = 0;
    }
	else $min = intval($min);
    $max = 250;
    include("header.php");
    title(""._STORIESARCHIVE."");
    title("$sitename: "._ALLSTORIESARCH."");
    if (isset($cookie[4])) { $r_options .= "&amp;mode=$cookie[4]"; }
    if (isset($cookie[5])) { $r_options .= "&amp;order=$cookie[5]"; }
    if (isset($cookie[6])) { $r_options .= "&amp;thold=$cookie[6]"; }
    OpenTable();
    ?><style type="text/css">.row1{background:#CEE5EF;}.row2{background:#E1EAED;line-height:19px;}</style><?php 
    echo "<table border=\"0\" width=\"100%\"><tr class='row1'>"
	."<td bgcolor=\"$bgcolor2\" align=\"right\"><b>"._ARTICLES."</b></td>"
	."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._COMMENTS."</b></td>"
	."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._READS."</b></td>"
	//."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._USCORE."</b></td>"
	."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._DATE."</b></td>"
	."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._ACTIONS."</b></td></tr>";
    $result = $db->sql_query("SELECT sid, catid, title, time, comments, counter, topic, alanguage from ".$prefix."_stories  Where time<=now() AND  section='news' AND approved='1' order by sid DESC limit $min,$max");
    $numrows = $db->sql_numrows($db->sql_query("select * from ".$prefix."_stories"));
	while($row = $db->sql_fetchrow($result)) {
	$sid = intval($row['sid']);
	$catid = intval($row['catid']);
	$title = stripslashes(check_html($row['title'], "nohtml"));
	$time = $row['time'];
	$comments = stripslashes($row['comments']);
	$counter = intval($row['counter']);
	$topic = intval($row['topic']);
	$alanguage = $row['alanguage'];
	$time = explode(" ", $time);
                $actions = "<a href=\"modules.php?name=News&amp;file=print&amp;sid=$sid\">
                <img src=\"images/icon/printer.png\" border=0 alt=\""._PRINTER."\" title=\""._PRINTER."\" width=\"16\" height=\"11\"></a>&nbsp;
                <a href=\"modules.php?name=News&amp;file=friend&amp;op=FriendSend&amp;sid=$sid\">
                <img src=\"images/icon/email.png\" border=0 alt=\""._FRIEND."\" title=\""._FRIEND."\" width=\"16\" height=\"11\"></a>";


	if ($catid == 0) {
	    $title = "<a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."\">$title</a>";
	} elseif ($catid != 0) {
	    $row_res = $db->sql_fetchrow($db->sql_query("SELECT title from ".$prefix."_stories_cat where catid='$catid'"));
	    $cat_title = stripslashes($row_res['title']);
	    $title = "<a href=\"modules.php?name=News&amp;file=categories&amp;op=newindex&amp;catid=$catid\"><i>$cat_title</i></a>: <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid$r_options\">$title</a>";
	}
	/*if ($multilingual == 1) {
	    if (empty($alanguage)) {
		$alanguage = $language;
	    }
	    $alt_language = ucfirst($alanguage);
	    $lang_img = "<img src=\"images/language/flag-$alanguage.png\" border=\"0\" hspace=\"2\" alt=\"$alt_language\" title=\"$alt_language\">";
	} else {
	    $lang_img = "<strong><big><b>&middot;</b></big></strong>";
	}
	*/echo "<tr class='row2'>"
	    ."<td bgcolor=\"$bgcolor1\" align=\"right\">$lang_img $title</td>"
	    ."<td bgcolor=\"$bgcolor1\" align=\"center\">$comments</td>"
	    ."<td bgcolor=\"$bgcolor1\" align=\"center\">$counter</td>"
       // ."<td bgcolor=\"$bgcolor1\" align=\"center\">".pullRating($sid,1,false,false,false)."</td>"
	    ."<td bgcolor=\"$bgcolor1\" align=\"center\">" . hejridate($time[0], 1, 3) . "</td>"
	    ."<td bgcolor=\"$bgcolor1\" align=\"center\">$actions</td></tr>";
    }
    echo "</table>"
	."<br><br><br>";
	$a = 0;
    if (($numrows > 250) AND ($min == 0)) {
	$min = $min+250;
	$a++;
	echo "<center>[ <a href=\"modules.php?name=$module_name&amp;sa=show_all&amp;min=$min\">"._NEXTPAGE."</a> ]</center><br>";
    }
    if (($numrows > 250) AND ($min >= 250) AND ($a != 1)) {
	$pmin = $min-250;
	$min = $min+250;
	$a++;
	echo "<center>[ <a href=\"modules.php?name=$module_name&amp;sa=show_all&amp;min=$pmin\">"._PREVIOUSPAGE."</a> | <a href=\"modules.php?name=$module_name&amp;sa=show_all&amp;min=$min\">"._NEXTPAGE."</a> ]</center><br>";
    }
    if (($numrows <= 250) AND ($a != 1) AND ($min != 0)) {
	$pmin = $min-250;
	echo "<center>[ <a href=\"modules.php?name=$module_name&amp;sa=show_all&amp;min=$pmin\">"._PREVIOUSPAGE."</a> ]</center><br>";
    }
    echo "<hr size=\"1\" noshade>"
	."<font class=\"content\">"._SELECTMONTH2VIEW."</font><br>";
    $result2 = $db->sql_query("SELECT time from ".$prefix."_stories order by time DESC");
    echo "<ul>";
	$thismonth = "";
    while($row2 = $db->sql_fetchrow($result2)) {
	 $time = $row2['time'];
        $hejri_temp = hejridate($time, 4, 8);
        list($hyear , $hmonth, $hday) = explode("-", $hejri_temp);
        $month = $j_month_name[$hmonth];
        if ($month != $thismonth) {
            $year = $hyear;
            echo "<li><a href=\"modules.php?name=$module_name&amp;sa=show_month&amp;year=$year&amp;month=$hmonth\">$month, $year</a>";
            $thismonth = $month;
        }
    }
   echo "</ul><br><br><center>"
        ."<form action=\"modules.php?name=Search\" method=\"post\">"
        ."<input type=\"text\" name=\"query\" size=\"30\" >&nbsp;"
        ."<input type=\"submit\" value=\""._SEARCH."\"><br />"
        ."</form>"
	."[ <a href=\"modules.php?name=$module_name\">"._ARCHIVESINDEX."</a>  ]</center>";
    CloseTable();
    include("footer.php");
}

	 $sa = isset($sa) ? $sa : "";
  	 $min = isset($min) ? intval($min) : 0;
  	 $year = (isset($year) && intval($year) > 0) ? intval($year) : gmdate('Y');
  	 $month = (isset($month) && intval($month) > 0) ? intval($month) : gmdate('m');
  	 $month_l = isset($month_l)? $month_l : "";
	 
switch($sa) {

    case "show_all":
    show_all($min);
    break;

    case "show_month":
     show_month($year, $month);
    break;
	
    default:
    select_month();
    break;

}

?>