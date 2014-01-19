<?php
/**
*
* @package Calendar Block														
* @version 9:26 PM 4/3/2010 James $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com	& Inspired By PHPBB3 Session Class										
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if(stripos($_SERVER['SCRIPT_NAME'],'block-Calendar.php')){
die("Illegal Access!");
}
define("CAL_PATH","modules/jCalendar/");
define("CALENDAR_TABLE","nuke_jcalendar_events");
$content .= '
<link href="modules/jCalendar/includes/style/Calendar.css" type="text/css" rel="stylesheet" />
<link href="'.SCRIPT_PLUGINS_PATH.'colortip/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="'.SCRIPT_PLUGINS_PATH.'colortip/script.js"></script>'."\n\r";
$content .= '<script type="text/javascript">
$(document).ready(function(){
	$(".caltitle").colorTip({color:\'yellow\'});
});</script>';
$content .= '<center><div class="jcal" style="text-align:'.langStyle(align).';margin:0px auto;width:99%">'."\n";

global $db,$currentlang,$prefix;
if ($currentlang == "persian") {
require_once (CAL_PATH.'includes/Calendar.Class.php');
$Calendar = new Calendar();
unset($sql);
$sql = 'SELECT * FROM `'.CALENDAR_TABLE.'`';
$result = $db->sql_query($sql);
$EventsMatrix = array();
$i = 0;
while($row = $db->sql_fetchrow($result)){
	$sdate = date_parse($row['start_date']);
	$edate = date_parse($row['end_date']);
	$EventsMatrix['day'][$i] = $sdate['year'].'-'.$sdate['month'].'-'.$sdate['day'];
	$EventsMatrix['content'][$i] = $row['title'];
	$EventsMatrix['holiday'][$i] = $row['holiday'];
	$date_diff = $Calendar->jdate_diff($row['start_date'],$row['end_date']);
	if($date_diff != 0){
		$ndate[0] = $sdate['year'];
		$ndate[1] = $sdate['month'];
		$ndate[2] = $sdate['day'];
		for($j=0;$j<$date_diff;$j++){
			$i++;
			$ndate = $Calendar->datepluse1($ndate);
			$EventsMatrix['day'][$i] = $ndate[0].'-'.$ndate[1].'-'.$ndate[2];
			$EventsMatrix['content'][$i] = $row['title'];
			$EventsMatrix['holiday'][$i] = $row['holiday'];
		}
	}
	$i++;
}
//print_r($EventsMatrix);
require_once (CAL_PATH.'includes/CalendarEvents.Class.php');
$CalendarEvents = new CalendarEvents($EventsMatrix);
$content .= $CalendarEvents->JSoutput;


//Check if the month and year values exist
if (isset($_GET['m'],$_GET['y'])) {
	$month = intval($_GET['m']);
	$year = intval($_GET['y']);
		$Calendar->Calendar_OtherMonth($year,$month);
} else {
	$gyear = date ('Y');
	$gmonth = date ('n');
	$gday = date ('j');
		$ThisMonth = $Calendar->Calendar_ThisMonth($gyear,$gmonth,$gday);
		$year = $ThisMonth[0];
		$month = $ThisMonth[1];
}
	//generate "next" and "prev" links
	if ($month!='12') {
		$next_month = "y=".$year; 
		$next_month .= "&amp;m=";
		$next_month .= $month+1;
	} else { 
		$next_month = "y=";
		$next_month .= $year+1;
		$next_month .= "&amp;m=1";
	}
	if ($month!='1') {
		$prev_month = "y=".$year;
		$prev_month .= "&amp;m=";
		$prev_month .= $month-1 ;
	} else {
		$prev_month = "y=";
		$prev_month .= $year-1;
		$prev_month .= "&amp;m=12";
	}
$content .='
<table class="month"  style="margin:0px auto;text-align:center;width:99%">
<tr>
<th colspan="7"><a href="modules.php?name=jCalendar&'.$prev_month.'"><img src="'.CAL_PATH.'includes/style/images/next.gif" alt="' . _PREV . '" title="' . _PREV . '"></a> 
 <a style="color:white" href="modules.php?name=jCalendar&y='.$year.'&amp;m='.$month.'" > '.$Calendar->shamsi_month_year.' </a>
 <a href="modules.php?name=jCalendar&'.$next_month.'"><img src="'.CAL_PATH.'includes/style/images/prev.gif" alt="' . _NEXT . '" title="' . _NEXT . '"></a></th></tr>
<tr class="days"><td>' . _CALENDER_SATUR . '</td><td>' . _CALENDER_SUN . '</td><td>' . _CALENDER_MON . '</td><td>' . _CALENDER_TUES . '</td><td>' . _CALENDER_WEDNES . '</td><td>' . _CALENDER_THURS . '</td><td>' . _CALENDER_FRI . '</td></tr>
';

if ($Calendar->month_first_day == 6)
		$startdate = - $Calendar->month_first_day + 6;
	else
		$startdate = - $Calendar->month_first_day - 1;
	
	//Figure out how many rows we need.
	$numrows = ceil ( ($Calendar->month_total_days + $Calendar->month_first_day + 1) / 7 );
	//Let's make an appropriate number of rows...
	for ($k = 1; $k <= $numrows; $k++)
	{
	$content .='<tr>';
		//Use 7 columns (for 7 days)...
		for ($i = 0; $i < 7; $i++)
		{
			$startdate++;
			$event = NULL;
			$holiday = NULL;
			$title = NULL;
			$linkstr = NULL;
			$tiptip_tag1 = NULL;
			$tiptip_tag2 = NULL;
			
			$this_day = $year."-".$month."-".$startdate;
			if ($EventsMatrix!=NULL && in_array($this_day,$EventsMatrix['day'],TRUE)){
				$event=" event";
				global $db,$prefix;
				list($holiday, $title, $linkstr) = $db->sql_fetchrow($db->sql_query('SELECT `holiday`,`title`,`linkstr` FROM `'.$prefix.'_jcalendar_events` WHERE `start_date` <= "'.$this_day.'" AND  `end_date` >= "'.$this_day.'" LIMIT 1'));
				if($holiday == 'yes') $holiday = ' holiday';
				else $holiday = NULL;
				$tiptip_tag1 = '<a href="' . $linkstr . '" class="caltitle" title="' . $title . '"><b>';
				$tiptip_tag2 = '</a></b>';
			}
			
			if (($startdate <= 0) || ($startdate > $Calendar->month_total_days))
			{
				//If we have a blank day in the calendar.
			$content .='<td></td>';
			} elseif ($this_day == $Calendar->today) {
			$content .='<td class="calendar-today '.$this_day.$event.$holiday.'" style="background:#F7E5B9"';
			$content .= '>'.$tiptip_tag1.farsinum($startdate).$tiptip_tag2.'</td>';	
			} else {
			$content .='<td class="calendar-body '.$this_day.$event.$holiday.'"';
			 $content .= '>'.$tiptip_tag1.farsinum($startdate).$tiptip_tag2.'</td>';
			}
		}
		 $content .='</tr>';
	}
 $content .='</table>';

 } else {
	require_once 'modules/jCalendar/includes/ECalendar.php';
	$cal = new ECalendar ();
	
	if (isset ( $_GET ['m'], $_GET ['y'] )) {
		$month = intval ( $_GET ['m'] );
		$year = intval ( $_GET ['y'] );
		$backtojeo = jalali_to_gregorian($year,$month,'1');
     	$content .= $cal->getMonthView($backtojeo[1], $backtojeo[0]);

	}else{
		// If no month/year set, use current month/year
 
$d = getdate ( time () );
		
		if ($month == "") {
			$month = $d ["mon"];
		}
		
		if ($year == "") {
			$year = $d ["year"];
		}
		
		$cal = new MyECalendar ();
		$content .= $cal->getMonthView ( $month, $year );
	}

}
 
$content .= '</div></center>';

?>