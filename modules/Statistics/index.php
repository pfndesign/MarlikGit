<?php
/**
 *
 * @package statistics														
 * @version $Id: statistics.php 6:45 PM 1/9/2010 Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */


if ( !defined("MODULE_FILE") )
{
	die("You can't access this file directly...");
}
define("blocks_show",false);
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

function StatMain(){
	include_once('header.php');
	OpenTable();
	show_charts();
	CloseTable();
	include_once('footer.php');
}
function show_charts(){
	global $db,$prefix;

	$result = $db->sql_query("SELECT type, var, count from ".$prefix."_counter order by type desc");
	while ($row = $db->sql_fetchrow($result)) {
		$type = check_words(check_html($row['type'], "nohtml"));
		$var = check_words(check_html($row['var'], "nohtml"));
		$count = intval($row['count']);
		if(($type == "config") && ($var == "Synchronization")) {
			$Synchronization = $count;
		}elseif(($type == "total") && ($var == "visits")) {
			$totalVisits = $count;
		}
		elseif(($type == "total") && ($var == "pageviews")) {
			$totalPVisits = $count;
		} elseif($type == "browser") {
			if($var == "FireFox") {
				$firefox = $count;
			} elseif($var == "Chrome") {
				$Chrome = $count;
			} elseif($var == "MSIE") {
				$msie = $count;
			} elseif($var == "Konqueror") {
				$konqueror = $count;
			} elseif($var == "Opera") {
				$opera = $count;
			} elseif($var == "Lynx") {
				$lynx = $count;
			} elseif($var == "Bot") {
				$bot = $count;
			} elseif(($type == "browser") && ($var == "Other")) {
				$b_other = $count;
			}
		} elseif($type == "os") {
			if($var == "Windows") {
				$windows = $count;
			} elseif($var == "Mac") {
				$mac = $count;
			} elseif($var == "Linux") {
				$linux = $count;
			} elseif($var == "FreeBSD") {
				$freebsd = $count;
			} elseif($var == "SunOS") {
				$sunos = $count;
			} elseif($var == "IRIX") {
				$irix = $count;
			} elseif($var == "BeOS") {
				$beos = $count;
			} elseif($var == "OS/2") {
				$os2 = $count;
			} elseif($var == "AIX") {
				$aix = $count;
			} elseif(($type == "os") && ($var == "Other")) {
				$os_other = $count;
			}
		} elseif($type == "se") {
			if($var == "google") {
				$google = $count;
			} elseif($var == "yahoo") {
				$yahoo = $count;
			} elseif($var == "bing") {
				$bing = $count;
			} elseif(($type == "se") && ($var == "other")) {
				$se_other = $count;
			}
		}
	}

	$db->sql_freeresult($result);


	//Hamed: since the previous query wasn't working,I came up with this one that makes even less query(half the previous one) and yaay it's working.
	//fist we have to play a little bit with the date
	
	//Farshad : what about a better look at our query ?! :D
	//this is the mighty query
	//SURE IT IS AND IT'S POWERED BY ME :D


	$today = date('Y-m-d');
	$yesterday = date('Y-m-d',time()-(3600 *24));

	$GeneralStat = $db->sql_fetchrow($db->sql_query("
		SELECT (SELECT COUNT(*) from ".$prefix."_users) TotalUsers,
       (SELECT COUNT(*) from  " . STORY_TABLE . ") TotalStories,
       (SELECT COUNT(*) from " . COMMENTS_TABLE . ") totalcomm,
       (SELECT COUNT(*) from " . DOWNLOAD_TABLE . ") totalfiles,
       (SELECT COUNT(*) from ".$prefix."_session) totalonlines,
       (SELECT `startdate` from `".$prefix."_config`) StartDate,
       (SELECT COUNT(*) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tuv,
       (SELECT COUNT(*) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yuv,
       (SELECT COUNT(*) from ".$prefix."_session WHERE session_user_id > 0 ) uonline,
       (SELECT COUNT(*) from ".$prefix."_session WHERE session_user_id = '0' ) gonline,
       (SELECT `count` from ".$prefix."_counter WHERE type = 'total' AND var = 'visits') totalVisits,
       (SELECT `count` from ".$prefix."_counter WHERE type = 'total' AND var = 'pageviews') totalPVisits,
       (SELECT COUNT(*) from ".$prefix."_authors ) TotalAuthors,
       (SELECT COUNT(*) from ".$prefix."_topics) TotalTopics,
       (SELECT COUNT(*) from ".$prefix."_tags) TotalTags;
  "));


	$tdy = $db->sql_fetchrow($sres);
	$TotalVisitsToday = $GeneralStat['tuv'];
	$TotalPVisitsToday = $GeneralStat['tv'];
	$TotalVisitsYesterday = $GeneralStat['yuv'];
	$TotalPVisitsYesterday = $GeneralStat['yv'];
	$TotalCrawlers = $GeneralStat['TotalCrawlers'];

	/// LIST ALL VISITS PER LISTENED DAYS
	$result = $db->sql_query("SELECT DATE(date_time) as date, COUNT(DISTINCT ip_address) AS TotalVisitsToday, COUNT(ip_address) AS TotalPVisitsToday  FROM ".$prefix."_iptracking GROUP BY date ORDER BY date_time DESC");
	$a =0 ;
	$array_chart_v = array();
	$array_chart_pv = array();
	while ($row = $db->sql_fetchrow($result)) {
		$a++;
		$date=$row['date'];


		$array_chart_v[] = intval($row['TotalVisitsToday']);
		$array_chart_pv[] = intval($row['TotalPVisitsToday']);


		$TotalVisitsTodaycount=$row['TotalVisitsToday'];
		$TotalPVisitsTodaycount=$row['TotalPVisitsToday'];

		$dateArr = explode(' ',$date);
		$comma = ($a==1) ? "" : ",";

		$visitLists .= "$comma$TotalVisitsTodaycount";
		$visitListsV .= "<img src='images/icon/time.png'>".hejridate($dateArr[0],1)."<img src='images/icon/bullet_orange.png'>[<b>".number_format($TotalVisitsTodaycount)."</b>]<br>";

		$HitsLists .= "$comma$TotalPVisitsTodaycount";
		$HitsListsV .= "<img src='images/icon/time.png'>".hejridate($dateArr[0],1)."<img src='images/icon/bullet_orange.png'>[<b>".number_format($TotalPVisitsTodaycount)."</b>]<br>";
	}

	$db->sql_freeresult($result);

$chartcolor = 			
			array(
			'#00BAFF',    // <-- blue windows - bing - msie
			'#FF0600',    // <-- red  linux -  google - chrome
			'#FFD508',    // <-- yellow mac - yahoo - firefox
			'#52C230',    // <-- green freebsd - - opera
			'#B39C86',   // <-- brown sunos -konquer 
			'#6C6C6C',   // <-- gray other - bot
			'#F7F6EB'   // <-- other 
			);



	$chartUrlPie1 = urlencode("modules.php?name=Statistics&op=chartDATA&chartTitle=pie&chartType=pie&chartValue=chartArraySO");
	$chartUrlPie2 = urlencode("modules.php?name=Statistics&op=chartDATA&chartTitle=pie&chartType=pie&chartValue=chartArrayBS");
	$chartUrlPie3 = urlencode("modules.php?name=Statistics&op=chartDATA&chartTitle=pie&chartType=pie&chartValue=chartArraySE");

	$chartUrlLine = urlencode("modules.php?name=Statistics&op=chartDATA&chartTitle=Visits Per Day&chartType=line&chartValue=array_chart_v");
	$chartUrlBar = urlencode("modules.php?name=Statistics&op=chartDATA&chartTitle=Page Visits Per Day&chartType=bar&chartValue=array_chart_pv");
 ?>
 <style type="text/css">
.break{margin-right:6px;color:#3E6D8E;background-color:#E0EAF1;border-bottom:1px solid #3E6D8E;border-right:1px solid #7F9FB6;padding:3px 4px 3px 4px;margin:2px 2px 2px 0;text-decoration:none;font-size:90%;line-height:2.4;white-space:nowrap;
}
</style>
<script type="text/javascript" src="includes/openChart/js/swfobject.js"></script>
<script type="text/javascript">

swfobject.embedSWF(
"includes/openChart/open-flash-chart.swf", "pie_chart1",
"350", "350", "9.0.0", "expressInstall.swf",
{"data-file":"<?php echo $chartUrlPie1; ?>"} );

swfobject.embedSWF(
"includes/openChart/open-flash-chart.swf", "pie_chart2",
"350", "350", "9.0.0", "expressInstall.swf",
{"data-file":"<?php echo $chartUrlPie2; ?>"} );

swfobject.embedSWF(
"includes/openChart/open-flash-chart.swf", "pie_chart3",
"350", "350", "9.0.0", "expressInstall.swf",
{"data-file":"<?php echo $chartUrlPie3; ?>"} );


swfobject.embedSWF(
"includes/openChart/open-flash-chart.swf", "line_chart", "430", "200",
"9.0.0", "expressInstall.swf",
{"data-file":"<?php echo $chartUrlLine; ?>"} );

swfobject.embedSWF("includes/openChart/open-flash-chart.swf", "my_chart", "430", "200", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo $chartUrlBar; ?>"} );
</script>
  <h3>
  <?PHP global $sitename; echo _STAT_TITLE .$sitename; ?>
  </h3>
 
<table style="width:100%;">

<tr>

<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>
<p>
<?PHP echo _STAT_CHART_USERS_LINE ?>
</p>

<p>
<center><div id="my_chart"></div></center>
</p>
 <br>
 
 

<img src='images/icon/chart_line.png'>
<?PHP echo _STAT_CHART_VISITED ?>
:<br>
<?PHP echo _TODAY ?>: <b><?php echo number_format($TotalPVisitsToday)?></b> <br> <?PHP echo _YESTERDAY ?> : <b><?php echo number_format($TotalPVisitsYesterday)?></b><br>
<?PHP echo _AVERAGE ?> : <b><?php if (!empty($a)){echo number_format(round($TotalPVisitsToday/$a));}else {echo _NO_CONTENT;}?></b><br>
<?PHP echo _STAT_CHART_VISITED_ALL ?>: <b><?php echo number_format($totalPVisits) ?></b><hr>
<div style="overflow:auto;height:150px;"><?php echo $HitsListsV ;?><br></div>
<img src='images/icon/bullet_error.png'><?PHP echo _STAT_CHART_LISTENEDIN ?><span style="color:red"><b><?php echo  $a ?> </b><?PHP echo _STAT_CHART_LISTENEDINDAY ?></span>
</td>

<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>
<p>
<?PHP echo _STAT_CHART_USERS_LINE ?>
</p>
<br>
<center><div id="line_chart"></div></center>
<br>


<img src='images/icon/chart_bar.png'>
<?PHP echo _STAT_CHART_SUMMMARY ?><br>
<img src='images/icon/chart_curve.png'><?PHP echo _STAT_CHART_UNIQUE_USERS ?>:<br>
<?PHP echo _TODAY ?> : <b><?php echo number_format($TotalVisitsToday)?></b><br> <?PHP echo _YESTERDAY ?> : <b><?php echo number_format($TotalVisitsYesterday)?></b><br>
<?PHP echo _AVERAGE ?>: <b><?php if (!empty($a)){echo number_format(round($totalVisits/$a));}else {echo _NO_CONTENT;}?></b><br>
<?PHP echo _STAT_CHART_VISITORS_ALL ?>: <b><?php echo number_format($totalVisits) ?></b>
 <hr>
 <div style="overflow:auto;height:150px;">
<?php echo $visitListsV ;?>
</div>
<img src='images/icon/bullet_error.png'><?PHP echo _STAT_CHART_LISTENEDIN ?><span style="color:red"><b><?php echo  $a ?> </b><?PHP echo _STAT_CHART_LISTENEDINDAY ?></span>
</td>

</tr>
<tr>

<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>

<p>
<?PHP echo _STAT_CHART_OS_CIRCLE ?>
</p>
<center><div id="pie_chart1"></div></center>

<?php 
	
echo '<div style="text-align:left">
   <span class="break" style="color:white;background:'.$chartcolor[0].'"> Windows : <b>'.$windows.'</b></span>
  <span class="break" style="color:white;background:'.$chartcolor[1].'">  linux : <b>'.$linux.'</b></span>
     <span class="break"  style="background:'.$chartcolor[2].'"> mac :<b>'.$mac.'</b></span>
    <span class="break" style="color:white;background:'.$chartcolor[4].'">sunos :<b>'.$sunos.'</b></span>
	   <span class="break"  style="color:black;background:'.$chartcolor[6].'">'._OTHER.' :<b>'.$os_other.'</b></span><br></div>';

?>
</td>

<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>
<p>
<?PHP echo _STAT_CHART_BROWSERS_CIRCLE ?>
</p>
<center><div id="pie_chart2"></div></center>
<?php 
echo '<div style="text-align:left">
    <span class="break" style="color:white;background:'.$chartcolor[0].'">MS IE : <b>'.$msie.'</b></span>
    <span class="break" style="background:'.$chartcolor[2].'">Firefox : <b>'.$firefox.'</b></span>
    <span class="break"  style="color:white;background:'.$chartcolor[1].'">Google Chrome :<b>'.$Chrome.'</b></span>
    <span class="break" style="background:'.$chartcolor[3].'">Opera :<b>'.$opera.'</b></span>
    <span class="break" style="color:white;background:'.$chartcolor[5].'">'._ROBOTS.':<b>'.$bot.'</b></span>
    <span class="break"  style="color:black;background:'.$chartcolor[6].'">'._OTHER.' :<b>'.$b_other.'</b></span><br></div>';
?>    
 </td>

</tr>

<tr><td style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>

<p>
 <?PHP echo _STAT_CHART_SE_CIRCLE ?>: 
</p>
<center><div id="pie_chart3"></div></center>
<?php 

echo '<div style="text-align:left">
    <span class="break" style="color:white;background:'.$chartcolor[1].'">Google : <b>'.$google.'</b></span>
    <span class="break"  style="color:white;background:'.$chartcolor[2].'">yahoo :<b>'.$yahoo.'</b></span>
    <span class="break" style="color:black;background:'.$chartcolor[3].'">bing : <b>'.$bing.'</b></span>
    <span class="break"  style="background:'.$chartcolor[4].'">'._OTHER.' :<b>'.$se_other.'</b></span><br></div>';

?>
 </td>

<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br> 
<h3>
 <?PHP echo _OTHER ?>: 
</h3>
<?php

    echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\"><tr><td colspan=\"2\">\n";
    echo "<tr><td><img src=\"images/icon/user.png\" border=\"0\" alt=\"\">&nbsp;"._USERS." </td><td><b>".$GeneralStat[TotalUsers]."</b></td></tr>\n";
    echo "<tr><td><img src=\"images/icon/user_gray.png\" border=\"0\" alt=\"\">&nbsp;"._AUTHOR."</td><td><b>".$GeneralStat[TotalAuthors]."</b></td></tr>\n";
    echo "<tr><td><img src=\"images/icon/note.png\" border=\"0\" alt=\"\">&nbsp;"._ARTICLES."</td><td><b>".$GeneralStat[TotalStories]."</b></td></tr>\n";
    if (is_active("Topics")) {
	echo "<tr><td><img src=\"images/icon/note.png\" border=\"0\" alt=\"\">&nbsp;"._TOPICS."</td><td><b>".$GeneralStat[TotalTopics]."</b></td></tr>\n";
    }
    
    echo "<tr><td><img src=\"images/icon/tag_green.png\" border=\"0\" alt=\"\">&nbsp;"._KEYWORDS."</td><td><b>".$GeneralStat[TotalTags]."</b></td></tr>\n";
    echo "</table></td></tr></table>\n";

  
}
function chartDATA($chartTitle,$chartType,$chartValue){

	include 'includes/openChart/data.php';

	global $db,$prefix;

	$result = $db->sql_query("SELECT type, var, count from ".$prefix."_counter order by type desc");
	while ($row = $db->sql_fetchrow($result)) {
		$type = check_words(check_html($row['type'], "nohtml"));
		$var = check_words(check_html($row['var'], "nohtml"));
		$count = intval($row['count']);
		if(($type == "config") && ($var == "Synchronization")) {
			$Synchronization = $count;
		}elseif(($type == "total") && ($var == "visits")) {
			$totalVisits = $count;
		}
		elseif(($type == "total") && ($var == "pageviews")) {
			$totalPVisits = $count;
		} elseif($type == "browser") {
			if($var == "FireFox") {
				$firefox = $count;
			} elseif($var == "Chrome") {
				$Chrome = $count;
			} elseif($var == "MSIE") {
				$msie = $count;
			} elseif($var == "Konqueror") {
				$konqueror = $count;
			} elseif($var == "Opera") {
				$opera = $count;
			} elseif($var == "Lynx") {
				$lynx = $count;
			} elseif($var == "Bot") {
				$bot = $count;
			} elseif(($type == "browser") && ($var == "Other")) {
				$b_other = $count;
			}
		} elseif($type == "os") {
			if($var == "Windows") {
				$windows = $count;
			} elseif($var == "Mac") {
				$mac = $count;
			} elseif($var == "Linux") {
				$linux = $count;
			} elseif($var == "FreeBSD") {
				$freebsd = $count;
			} elseif($var == "SunOS") {
				$sunos = $count;
			} elseif($var == "IRIX") {
				$irix = $count;
			} elseif($var == "BeOS") {
				$beos = $count;
			} elseif($var == "OS/2") {
				$os2 = $count;
			} elseif($var == "AIX") {
				$aix = $count;
			} elseif(($type == "os") && ($var == "Other")) {
				$os_other = $count;
			}
		} elseif($type == "se") {
			if($var == "google") {
				$google = $count;
			} elseif($var == "yahoo") {
				$yahoo = $count;
			} elseif($var == "bing") {
				$bing = $count;
			} elseif(($type == "se") && ($var == "other")) {
				$se_other = $count;
			}
		}
	}

	$db->sql_freeresult($result);



	//Hamed: since the previous query wasn't working I came up with this one that makes less query(half the previous one) and yaay it's working.
	//fist we have to play a little bit with the date
	//Farshad : what about a better look at our query ?! :D



	$today = date('Y-m-d');
	$yesterday = date('Y-m-d',time()-(3600 *24));
	//this is the mighty query
	//SURE IT IS AND IT'S POWERED BY MINE :D
	$GeneralStat = $db->sql_fetchrow($db->sql_query("
		SELECT (SELECT COUNT(*) from ".$prefix."_users) TotalUsers,
       (SELECT COUNT(*) from  " . STORY_TABLE . ") TotalStories,
       (SELECT COUNT(*) from " . COMMENTS_TABLE . ") totalcomm,
       (SELECT COUNT(*) from " . DOWNLOAD_TABLE . ") totalfiles,
       (SELECT COUNT(*) from ".$prefix."_session) totalonlines,
       (SELECT `startdate` from `".$prefix."_config`) StartDate,
       (SELECT COUNT(*) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tuv,
       (SELECT COUNT(*) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM ".$prefix."_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yuv,
       (SELECT COUNT(*) from ".$prefix."_session WHERE session_user_id > 0 ) uonline,
       (SELECT COUNT(*) from ".$prefix."_session WHERE session_user_id = '0' ) gonline,
       (SELECT `count` from ".$prefix."_counter WHERE type = 'total' AND var = 'visits') totalVisits,
       (SELECT `count` from ".$prefix."_counter WHERE type = 'total' AND var = 'pageviews') totalPVisits,
       (SELECT COUNT(*) from ".$prefix."_authors ) TotalAuthors,
       (SELECT COUNT(*) from ".$prefix."_topics) TotalTopics,
       (SELECT COUNT(*) from ".$prefix."_tags) TotalTags;
  "));


	$tdy = $db->sql_fetchrow($sres);
	$TotalVisitsToday = $GeneralStat['tuv'];
	$TotalPVisitsToday = $GeneralStat['tv'];
	$TotalVisitsYesterday = $GeneralStat['yuv'];
	$TotalPVisitsYesterday = $GeneralStat['yv'];
	$TotalCrawlers = $GeneralStat['TotalCrawlers'];

	/// LIST ALL VISITS PER LISTENED DAYS
	$result = $db->sql_query("SELECT DATE(date_time) as date, COUNT(DISTINCT ip_address) AS TotalVisitsToday, COUNT(ip_address) AS TotalPVisitsToday  FROM ".$prefix."_iptracking GROUP BY date ORDER BY date_time ASC");
	$a =0 ;
	$array_chart_v = array();
	$array_chart_pv = array();
	$array_chart_d = array();
	while ($row = $db->sql_fetchrow($result)) {
		$a++;
		$date=$row['date'];


		$array_chart_v[] = intval($row['TotalVisitsToday']);
		$array_chart_d[] = intval($row['date']);
		$array_chart_pv[] = intval($row['TotalPVisitsToday']);


		$TotalVisitsTodaycount=$row['TotalVisitsToday'];
		$TotalPVisitsTodaycount=$row['TotalPVisitsToday'];

		$dateArr = explode(' ',$date);
		$comma = ($a==1) ? "" : ",";

		$visitLists .= "$comma$TotalVisitsTodaycount";
		$visitListsV .= "<img src='images/icon/time.png'>".hejridate($dateArr[0],1)."<img src='images/icon/bullet_orange.png'>[<b>".number_format($TotalVisitsTodaycount)."</b>]<br>";

		$HitsLists .= "$comma$TotalPVisitsTodaycount";
		$HitsListsV .= "<img src='images/icon/time.png'>".hejridate($dateArr[0],1)."<img src='images/icon/bullet_orange.png'>[<b>".number_format($TotalPVisitsTodaycount)."</b>]<br>";
	}

	$db->sql_freeresult($result);



	$chartArraySO = array(intval($windows),intval($linux),intval($mac),intval($freebsd),intval($sunos),intval($os2),intval($os_other));
	$chartArraySE = array(intval($bing),intval($google),intval($yahoo),intval($se_other));
	$chartArrayBS = array(intval($msie),intval($Chrome),intval($firefox),intval($opera),intval($Konqueror),intval($bot),intval($b_other));





	//$chartValue = ($chartValue=="array_chart_v") ? $array_chart_v : ($chartValue=="array_chart_pv") ? $array_chart_pv :  ($chartValue=="chartArraySE") ? array($chartArraySE) : ($chartValue=="chartArraySO") ? array($chartArraySO) : ($chartValue=="chartArrayBrowsers") ? array($chartArrayBrowsers) : "" ;

	if ($chartValue=="array_chart_v") {
		$chartValue = $array_chart_v ;
	}elseif ($chartValue=="array_chart_pv"){
		$chartValue = $array_chart_pv ;
	}
	elseif ($chartValue=="chartArraySE"){
		$chartValue = $chartArraySE ;
	}
	elseif ($chartValue=="chartArrayBS"){
		$chartValue = $chartArrayBS ;
	}
	elseif ($chartValue=="chartArraySO"){
		$chartValue = $chartArraySO;
	}else {
		$chartValue = "";
	}


	switch ($chartType){

		case "bar":

			// ----- BAR CHART ----------
			$bar = new bar_value(5);
			$bar->set_colour( '#900000' );
			$bar->set_tooltip( 'Hello<br>#val#' );
			$title = new title($chartTitle );
			$bar = new bar_3d();
			$bar->set_values( $chartValue );
			$bar->colour = '#D54C78';
			$x_axis = new x_axis();
			$x_axis->set_3d( 5 );
			$x_axis->colour = '#909090';
			$x_axis->set_labels( $chartValue );
			$y = new y_axis();
			$y->set_range( 0, 10000);
			$chart = new open_flash_chart();
			$chart->set_y_axis( $y );
			$chart->set_title( $title );
			$chart->add_element( $bar );
			$chart->set_x_axis( $x_axis );
			echo $chart->toPrettyString();



			break;

		case "pie":

			$pie = new pie();
			$pie->start_angle(35)
			->add_animation( new pie_fade() )
			->add_animation( new pie_bounce(8) )
			->label_colour('#000033') // <-- uncomment to see all labels set to blue
			//->gradient_fill()
			->tooltip( '#val# از #total#<br>#percent#' )
			->colours(
			array(
			'#00BAFF',    // <-- blue windows - bing - msie
			'#FF0600',    // <-- red  linux -  google - chrome
			'#FFD508',    // <-- yellow mac - yahoo - firefox
			'#52C230',    // <-- green freebsd - - opera
			'#B39C86',   // <-- brown sunos -konquer 
			'#6C6C6C',   // <-- gray other - bot
			'#F7F6EB'   // <-- other 
			));

			
			$pie->set_values( $chartValue );
			$chart = new open_flash_chart();
			$chart->add_element( $pie );
			echo $chart->toPrettyString();

		case "line":
			$default_dot = new dot();
			$default_dot->size(5)->colour('#DFC329');
			$line_dot = new line();
			$line_dot->set_default_dot_style($default_dot);
			$line_dot->set_width( 4 );
			$line_dot->set_colour( '#DFC329' );
			$line_dot->set_values( $chartValue );
			$line_dot->set_key( "$chartTitle", 10 );
			$y = new y_axis();
			$y->set_range( 0, 1000);
			$chart = new open_flash_chart();
			$chart->set_title( new title( $chartTitle ) );
			$chart->set_y_axis( $y );
			$chart->add_element( $line_dot );
			echo $chart->toPrettyString();

			break;


	}

}

switch($op) {


	default:
		StatMain();
		break;

	case "chartDATA":
		chartDATA($chartTitle,$chartType,$chartValue);
		break;


}


?>