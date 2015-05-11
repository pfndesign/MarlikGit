<?php
/***********************************
 * Jalali Calendar v 1.0.0.0
 * for MarlikCMS USV v 1
 * written by James [Hamed]
 * developed by S.Amirhosein Nikookar Nooshabadi
 * thanks to Armin Randjbar-Daemi for his fantastic Jalali Calendar Class
 * you can find him here: http://www.phpclasses.org/browse/package/4457.html
 * *********************************/
if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}

define('INDEX_FILE', true);
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- "._EVENTS_OF;
include("header.php");
global $prefix;
define('EVENTS_TABLE',$prefix.'_jcalendar_events');

require_once ('includes/Calendar.Class.php');

function show_now_month_calendare(){
	global $db,$prefix,$pagetitle,$module_name;
	//You can get the Events from Database and put them in this Array
	/*$EventsMatrix = array(
						day=>array('1386-12-2','1386-12-7','1388-12-16','1386-12-29'),
						content=>array('دوم اسفند','هفتم اسفند','هیجدهم اسفند','روز ملی شدن صنعت نفت ایران')
						);*/
	$Calendar = new Calendar();
	unset($sql);
	$sql = 'SELECT * FROM '.$prefix.'_jcalendar_events WHERE `approved`=1';
	$result = $db->sql_query($sql);
	$EventsMatrix = array();
	$i = 0;
	while($row = $db->sql_fetchrow($result)){
		$sdate = date_parse($row['start_date']);
		$edate = date_parse($row['end_date']);
		$EventsMatrix['day'][$i] = $sdate['year'].'-'.$sdate['month'].'-'.$sdate['day'];
		$EventsMatrix['content'][$i] = $row['title'];
		$EventsMatrix['holiday'][$i] = $row['holiday'];
		$EventsMatrix['link'][$i] = $row['linkstr'];
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
				$EventsMatrix['link'][$i] = $row['linkstr'];
			}
		}
		$i++;
	}

	require_once ('includes/CalendarEvents.Class.php');
	$CalendarEvents = new CalendarEvents($EventsMatrix);
	echo $CalendarEvents->JSoutput;
	OpenTable();
	?>
	<div style="width:100%;text-align:center;" class="jcal">
		<div style="margin: auto; width: 350px;">
			<?php include('includes/Calendar.php'); ?>
		</div>
	</div>
	<?php
	echo '<br />'._MOUSE_OVER_TOOLTIP.'<br />';
	if ($EventsMatrix!=NULL){
		echo '<br /><br /><center><b>'._EVENTS_LIST.' '.$Calendar->shamsi_month_year.'</b></center><br />';
		$tmp_event = array();
		for ($i = 1; $i < 32; $i++){
			$tmp_date = $year."-".$month."-".$i;
			if (in_array($tmp_date,$EventsMatrix['day'],TRUE)){
	        	foreach ($EventsMatrix['day'] as $index => $date){
	        		if ($date == $tmp_date){
	        			$event_flag=true;
	        			if (!in_array($EventsMatrix['content'][$index],$tmp_event)){
	        				echo '- <a href="'.$EventsMatrix['link'][$index].'">'.$EventsMatrix['content'][$index].'</a><br />';
	        				array_push($tmp_event,$EventsMatrix['content'][$index]);
	        			}
	        		}
	        	}
			}
		}
	}
	if (!$event_flag)
		echo _NOT_IS_EVENTS;

	echo '<br /><br />';
	unset($CalendarEvents);
	echo '<center>';
    add_event();
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    	.'<a href="modules.php?name='.$module_name.'&op=show_all_events" class="button" style="color:black;">',_SHOW_ALL_EVENT,'</a>'
		.'</center>';
    CloseTable();
}

function add_event(){	
	global $module_name;
	$cl = new Calendar();
	$today = explode("-",$cl->find_today());
	echo '<script>
			function show_add_event(){
				$("#add_event").toggle("slow");
			}
			</script>
			<style>
			#add_event td{
				min-width:120px;
			}
			</style>';
	echo '<br /><button onclick="show_add_event()">',_OFFER_EVENT_BY_YOU,'</button>
		<div id="add_event" style="display:none"><br />

		<form action="modules.php?name='.$module_name.'&amp;op=save_offer" method="post">
		<table>
		<tbody>
			<tr>
				<td>',_EVENT_TITLE,'</td><td><input type="text" name="event_title" /></td>
			</tr>
			<tr>
				<td>',_START_DATE,'</td><td>',get_hejri_day(1,'start_day'),' ',get_hejri_month('start_month'),' <input type="text" name="start_year" value="',$today[0],'" size="8"/> </td>
			</tr>
			<tr>
				<td>',_END_DATE,'</td><td>',get_hejri_day(1,'end_day'),' ',get_hejri_month('end_month'),' <input type="text" name="end_year" value="',$today[0],'" size="8"/></td>
			</tr>
			<tr>
				<td>',_REPEATE_TYPE,'</td><td><select size="1" name="repeat_type"><option value="off"></option><option value="daily">',_DAILY,'</option><option value="monthly">',_MONTHLY,'</option><option value="yearly">',_YEARLY,'</option></select></td>
			</tr>
			<tr>
				<td>',_IS_HOLIDAY,'</td><td><label><input type="radio" name="holiday" value="1" />',_YES,'</label> <label><input type="radio" name="holiday" value="0" />',_NO,'</label></td>
			</tr>
			<tr>
				<td>',_RELATED_LINK,'</td><td><input type="text" name="event_link" size="30" dir="ltr" /></td>
			</tr>';
    if (extension_loaded("gd"))
    {
        echo '<tr>
				<td>&nbsp;</td><td><div class="single-field">' . show_captcha() . '</div></td>
			</tr>';
    }
	echo '	<tr>
				<td><input type="submit" value="',_SUBMIT,'" /></td>
			</tr>
			</tbody>
		</table>
		</form><br />
		</div>';
	unset($cl);
}

function SaveOffer(){
	global $db,$prefix;
	if (extension_loaded("gd") AND !check_captcha())
    {
    	OpenTable();
        echo '<div class="error" style="text-align:center;color:red;">',_WRONG_CODE,'<br /><br />'
			._GOBACK.'</div>';
			CloseTable();	
		return;
    }
	$title = mysql_real_escape_string($_POST['event_title']);
	$start_date = mysql_real_escape_string($_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day']).' 00:00:00';
	$end_date = mysql_real_escape_string($_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day']).' 00:00:00';
	$repeat_type = mysql_real_escape_string($_POST['repeat_type']);
	$event_link = mysql_real_escape_string($_POST['event_link']);
    if ($event_link<>'' AND stristr($event_link, 'http://') === FALSE) $event_link= "http://$event_link";
	if($holiday == 1)
		$holiday = 'yes';
	else
		$holiday = 'no';
	$sql = 'INSERT INTO `'.$prefix.'_jcalendar_events` (`title`,`start_date`,`end_date`,`repeat_type`,`approved`,`holiday`,`linkstr`) VALUES ("'.$title.'","'.$start_date.'","'.$end_date.'","'.$repeat_type.'",0,"'.$holiday.'","'.$event_link.'")';
	$result = $db->sql_query($sql);
	OpenTable();
	if(!$result){
		echo _FAIL;
		echo '<div class="error" style="text-align:left;direction:ltr">',mysql_error(),'</div>';
	}else{
		echo '<div class="success" style="text-align:center;">',_DONE_OFFER_EVENT,'<br /><br />'
			._GOBACK.'</div>';
	}
	CloseTable();
	$db->sql_freeresult($result);
}

function show_all_events(){    global $sitename, $db, $module_name;
   	$bgcolor1='#DBEADF';
	$bgcolor2='#BBCCDC';
	$bgcolor3='#FFFFFF';

	OpenTable();
    echo '<center><b>'._EVENTS_LIST.' '.$sitename.'</b></center><br />';
	unset($sql);
	$sql = 'SELECT * FROM `'.EVENTS_TABLE.'` WHERE approved=1 ORDER BY `start_date` ASC';
	$result = $db->sql_query($sql);
	$num = $db->sql_numrows($result);

	if (!empty($num)) {
		if ($num > 50 ) {
			$style = 'style="overflow:auto;height:600px"';
		}
		echo '<style type="text/css">
				#eventsc td,#events th{
					text-align:center;
				}
			 </style>';
		echo '<script type="text/javascript" src="modules/'.$module_name.'/includes/JQTable/jtable-1.0.min.js"></script>';
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				jTable("demo-table",{stripe:'#EED',over:'#FC0', out:'#FFF'});
			});
		</script>
		<?php
		echo '<div id="eventsc" '.$style.' >
    	  <table border="0" width="100%">
			<tr >
	  				<thead>';
		echo '		<tr style="height:30px;text-align:center;background-color: '.$bgcolor2.';">';
		echo "		<th scope='col' >"._RADIF."</th>\n";
		echo "		<th scope='col' >"._ENAME."</th>\n";
		echo "		<th scope='col' >"._DATE_FROM."</th>\n";
		echo "		<th scope='col' >"._DATE_TO."</th>\n";
		echo "		<th scope='col' >"._REPEATE_TYPE."</th>\n";
		echo "
					</tr>
					</thead>";
		echo "<tbody id='demo-table'>\n";
        $id=0;
		while($row = $db->sql_fetchrow($result)){
			$i=$i+1;
			if ($i % 2)
				$cellcolor=$bgcolor3;
			else
				$cellcolor=$bgcolor1;
			echo '<tr style="background-color: '.$cellcolor.';">
			<td>'.$i.'</td>
			<td><a href="',$row['linkstr'],'">',$row['title'],'</a></td>';
            if ($row['repeat_type']<>'off'){
				$tmpstartdate = explode('-',substr($row['start_date'],0,10));
				$tmpenddate = explode('-',substr($row['end_date'],0,10));
				echo '<td >'.farsiday($tmpstartdate[2]).' '.farsimonth($tmpstartdate[1]).'</td>';
				echo '<td >'.farsiday($tmpenddate[2]).' '.farsimonth($tmpenddate[1]).'</td>';
			}
			else{				echo '<td >'.substr($row['start_date'],0,10).'</td>';
				echo '<td >'.substr($row['end_date'],0,10).'</td>';
			}
            if ($row['repeat_type'] == 'off')
            	echo '<td >-</td>';
            if ($row['repeat_type'] == 'daily')
            	echo '<td >',_DAILY,'</td>';
            if ($row['repeat_type'] == 'monthly')
            	echo '<td >',_MONTHLY,'</td>';
            if ($row['repeat_type'] == 'yearly')
            	echo '<td >',_YEARLY,'</td>';
		}
		echo ' </tbody></table></div><br>';
	}else {
		echo _NO_EVENTS;
	}
	$db->sql_freeresult($result);
    add_event();
	CloseTable();
}

switch($op) {

    case "save_offer":
    	SaveOffer($cat,$page);
    	break;

    case "show_all_events":
    	show_all_events();
    	break;

    default:
    	show_now_month_calendare();
    	break;
}

include("footer.php");
?>