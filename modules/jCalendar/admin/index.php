<?php
global $admin_file,$currentlang;
if(!defined('ADMIN_FILE')) {
    Header("Location: ../../".$admin_file.".php");
    die();
}
require_once("modules/jCalendar/includes/Calendar.Class.php");
require_once("modules/jCalendar/language/lang-$currentlang.php");
$cl = new Calendar;
global $prefix;
define('EVENTS_TABLE',$prefix.'_jcalendar_events');
$do = $_REQUEST['do'];
function main_page(){
	global $db,$prefix,$cl;
	unset($sql);
	$sql = 'SELECT * FROM `'.EVENTS_TABLE.'` ORDER BY `eid` ASC';
	$result = $db->sql_query($sql);
	$num = $db->sql_numrows($result);

	echo "<h3>" . _jCalendar . "</h3><hr>";
	echo "<h3>" . _EVENTS_ADMIN . "</h3>";
	if (!empty($num)) {
		if ($num > 50 ) {
			$style = 'style="overflow:auto;height:600px"';
		}
		echo '<style type="text/css">
				#eventsc td,#events th{
					text-align:center;
				}
			 </style>';
		echo '<form name="events" id="events" method="post" action="'.ADMIN_OP.'jCalendar&do=remove">';
		echo '<div id="eventsc" '.$style.' >
				<table class="widefat comments fixed">
	  				<thead>';

		echo "		<tr>";
		echo "		<th scope='col' >"._EID."</th>\n";
		echo "		<th scope='col' >"._ENAME."</th>\n";
		echo "		<th scope='col' >"._DATE_FROM."</th>\n";
		echo "		<th scope='col' >"._DATE_TO."</th>\n";
		echo "		<th scope='col' >"._DAYS_COUNT."</th>\n";
		echo "		<th scope='col' >"._REPEATE_TYPE."</th>\n";
		echo "		<th scope='col' >"._APPROVE_STATUS."</th>\n";
		echo "		<th scope='col' >"._OPTIONS."</th>\n";
		echo '		<th scope="col" ><label for="checkall"><input id="checkall" type="checkbox" onclick="checkAll(document.getElementById(\'events\'), \'selectbox\', this.checked);" />'._SELECT.'</label></th>';
		echo "
					</tr>
					</thead>";
		echo "      <tfoot>";
		echo "		<tr>";
		echo "		<th scope='col' >"._EID."</th>\n";
		echo "		<th scope='col' >"._ENAME."</th>\n";
		echo "		<th scope='col' >"._DATE_FROM."</th>\n";
		echo "		<th scope='col' >"._DATE_TO."</th>\n";
		echo "		<th scope='col' >"._DAYS_COUNT."</th>\n";
		echo "		<th scope='col' >"._REPEATE_TYPE."</th>\n";
		echo "		<th scope='col' >"._APPROVE_STATUS."</th>\n";
		echo "		<th scope='col' >"._OPTIONS."</th>\n";
		echo '		<th scope="col" ><label for="checkall"><input id="checkall" type="checkbox" onclick="checkAll(document.getElementById(\'events\'), \'selectbox\', this.checked);" />'._SELECT.'</label></th>';
		echo "		</tr>
					</tfoot>";
		echo "<tbody>\n";


		while($row = $db->sql_fetchrow($result)){
			$days_count = $cl->jdate_diff($row['start_date'],$row['end_date']);
			echo '<tr>

			<td align="right">',$row['eid'],'</td>

			<td align="center"><a href="',$row['linkstr'],'">',$row['title'],'</a></td>

			<td >',$row['start_date'],'</td>
			<td >',$row['end_date'],'</td>
			<td >',$days_count,'</td>';
            if ($row['repeat_type'] == 'off')
            	echo '<td >-</td>';
            if ($row['repeat_type'] == 'daily')
            	echo '<td >',_DAILY,'</td>';
            if ($row['repeat_type'] == 'monthly')
            	echo '<td >',_MONTHLY,'</td>';
            if ($row['repeat_type'] == 'yearly')
            	echo '<td >',_YEARLY,'</td>';

            if ($row['approved'] == '1')
            	echo '<td >',_APPROVED_EVENT,'</td>';
            else
            	echo '<td style="color:red;">',_NOT_APPROVED_EVENT,'</td>';

			echo '<td style="text-align:center"><a href="'.ADMIN_OP.'jCalendar&do=edit&eid=',$row['eid'],'">
			<img src="images/icon/page_edit.png" title="',_EDIT,'" /></a><a href="'.ADMIN_OP.'jCalendar&do=delete&eid=',$row['eid'],'">
			<img src="images/delete.gif" title="',_REMOVE,'"/></a></td>
			<td ><input type="checkbox" name="event_ids[]" class="selectbox" value="',$row['eid'],'" /></td>
			</tr>';
		}
		echo ' </tbody></table></div><br>';

		echo '<input type="submit" value="',_REMOVE_SELECTED,'" /></form>';
	}else {
		echo _NO_EVENTS;
	}
	$db->sql_freeresult($result);
	add_event();
}

function add_event(){
	global $cl;
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
	echo '<br /><button onclick="show_add_event()">',_ADD_EVENT,'</button>
		<div id="add_event" style="display:none">
			<h3>',_ADD_EVENT,'</h3>

		<form action="'.ADMIN_OP.'jCalendar&do=save_event" method="post">
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
				<td>',_RELATED_LINK,'</td><td><input type="text" name="event_link" size="50" dir="ltr" /></td>
			</tr>
			<tr>
				<td><input type="submit" value="',_SUBMIT,'" /></td>
			</tr>
			</tbody>
		</table>
		<input type="hidden" name="mode" value="save" />
		</form>
		</div>';
}

function edit_event(){
	global $db;
	$eid = intval($_REQUEST['eid']);
	$sql = 'SELECT `title`,`start_date`,`end_date`,`repeat_type`,`approved`,`approved`,`holiday`,`linkstr` FROM `'.EVENTS_TABLE.'` WHERE `eid` = "'.$eid.'" LIMIT 1';
	list($title,$start_date,$end_date,$repeate_type,$approved,$approved,$holiday,$link) = $db->sql_fetchrow($db->sql_query($sql));
	echo mysql_error();
	$start_date = explode(" ",$start_date);
	$start_date = explode("-",$start_date[0]);
	$end_date = explode(" ",$end_date);
	$end_date = explode("-",$end_date[0]);
	echo '<div id="edit_event">
		<h3>',_EDIT_EVENT,'</h3>
		<form action="'.ADMIN_OP.'jCalendar&do=save_event" method="post">
		<table>
		<tbody>
			<tr>
				<td>',_EVENT_TITLE,'</td><td><input type="text" name="event_title" value="',$title,'" /></td>
			</tr>
			<tr>
				<td>',_START_DATE,'</td><td>',get_hejri_day(1,'start_day',intval($start_date[2])),' ',get_hejri_month('start_month',intval($start_date[1])),' <input type="text" name="start_year" value="',$start_date[0],'" size="8"/> </td>
			</tr>
			<tr>
				<td>',_END_DATE,'</td><td>',get_hejri_day(1,'end_day',intval($end_date[2])),' ',get_hejri_month('end_month',intval($end_date[1])),' <input type="text" name="end_year" value="',$end_date[0],'" size="8"/></td>
			</tr>
			<tr>
				<td>',_REPEATE_TYPE,'</td><td><select size="1" name="repeat_type">';
    if ($repeate_type == 'off')
    	echo '<option selected value="off"></option>';
    else
    	echo '<option value="off"></option>';
    if ($repeate_type == 'daily')
    	echo '<option selected value="daily">',_DAILY,'</option>';
    else
    	echo '<option value="daily">',_DAILY,'</option>';
    if ($repeate_type == 'monthly')
    	echo '<option selected value="monthly">',_MONTHLY,'</option>';
    else
    	echo '<option value="monthly">',_MONTHLY,'</option>';
    if ($repeate_type == 'yearly')
    	echo '<option selected value="yearly">',_YEARLY,'</option>';
    else
    	echo '<option value="yearly">',_YEARLY,'</option>';

	echo '		</select></td>
			</tr>';

	if($approved == '1'){
		echo '<tr>
				<td>',_IS_APPROVED,'</td><td><label><input type="radio" name="approved" value="1" CHECKED="true" />',_YES,'</label> <label><input type="radio" name="approved" value="0" />',_NO,'</label></td>
			</tr>';
	}else{
		echo '<tr>
				<td>',_IS_APPROVED,'</td><td><label><input type="radio" name="approved" value="1" />',_YES,'</label> <label><input type="radio" name="approved" value="0" CHECKED="true" />',_NO,'</label></td>
			</tr>';
	}

	if($holiday == 'yes'){
		echo '<tr>
				<td>',_IS_HOLIDAY,'</td><td><label><input type="radio" name="holiday" value="1" CHECKED="true" />',_YES,'</label> <label><input type="radio" name="holiday" value="0" />',_NO,'</label></td>
			</tr>';
	}else{
		echo '<tr>
				<td>',_IS_HOLIDAY,'</td><td><label><input type="radio" name="holiday" value="1" />',_YES,'</label> <label><input type="radio" name="holiday" value="0" CHECKED="true" />',_NO,'</label></td>
			</tr>';
	}

	echo '<tr>
		  	<td>',_RELATED_LINK,'</td><td><input type="text" name="event_link" value="',$link,'" size="50" dir="ltr" /></td>
		</tr>
		<tr>
			<td><input type="submit" value="',_SUBMIT,'" /></td>
		</tr>
		</tbody>
	</table>
	<input type="hidden" name="eid" value="',$eid,'" />
	<input type="hidden" name="mode" value="edit" />
	</form>
	</div>';
}

function save_event(){
	global $db;
	$mode = $_POST['mode'];
	switch($mode){
		case 'edit':
			$eid = intval($_POST['eid']);
			$title = mysql_real_escape_string($_POST['event_title']);
			$start_date = mysql_real_escape_string($_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day']).' 00:00:00';
			$end_date = mysql_real_escape_string($_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day']).' 00:00:00';
			$repeat_type = mysql_real_escape_string($_POST['repeat_type']);
			$event_link = mysql_real_escape_string($_POST['event_link']);
            if ($event_link<>'' AND stristr($event_link, 'http://') === FALSE) $event_link= "http://$event_link";
            $approved = intval($_POST['approved']);
			$holiday = intval($_POST['holiday']);
			if($holiday == 1)
				$holiday = 'yes';
			else
				$holiday = 'no';
			$sql = 'UPDATE `'.EVENTS_TABLE.'` SET `title` = "'.$title.'", `start_date` = "'.$start_date.'", `end_date` = "'.$end_date.'", `repeat_type` = "'.$repeat_type.'", `approved` = "'.$approved.'", `holiday` = "'.$holiday.'", `linkstr` = "'.$event_link.'" WHERE `eid` = "'.$eid.'" LIMIT 1';
			$result = $db->sql_query($sql);
			if(!$result){
				echo _FAIL;
				echo '<div style="text-align:left;direction:ltr">',mysql_error(),'</div>';
			}else{
				echo _DONE;
			}
		break;
		case 'save':
			$eid = intval($_POST['eid']);
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
			$sql = 'INSERT INTO `'.EVENTS_TABLE.'` (`title`,`start_date`,`end_date`,`repeat_type`,`approved`,`holiday`,`linkstr`) VALUES ("'.$title.'","'.$start_date.'","'.$end_date.'","'.$repeat_type.'",1,"'.$holiday.'","'.$event_link.'")';
			$result = $db->sql_query($sql);
			if(!$result){
				echo _FAIL;
				echo '<div style="text-align:left;direction:ltr">',mysql_error(),'</div>';
			}else{
				echo _DONE;
			}
			break;
		default:
			echo _UNAUTHORIZED_OPERATION;
			break;
	}
}

function delete_event(){
	global $db;
	$eid = intval($_REQUEST['eid']);
	unset($sql);
	$sql = 'DELETE FROM `'.EVENTS_TABLE.'` WHERE `eid` = "'.$eid.'" LIMIT 1';
	$result = $db->sql_query($sql);
	if(!$result){
		echo _FAIL;
		echo '<div style="text-align:left;direction:ltr">',mysql_error(),'</div>';
	}else{
		echo _DONE;
	}
}

function delete_events(){
	global $db;
	$eids = $_POST['event_ids'];
	$max = count($eids);
	for($i=0;$i<$max;$i++){
		$eid = intval($eids[$i]);
		if(!$db->sql_query('DELETE FROM `'.EVENTS_TABLE.'` WHERE `eid` = "'.$eid.'" LIMIT 1')){
			echo _FAIL;
			return 0;
		}
	}
	echo _DONE;
}

include('header.php');
GraphicAdmin();
OpenTable();
switch($do){
	default:
	case 'main':
		main_page();
		break;
	case 'edit':
		main_page();
		edit_event();
		break;
	case 'save_event':
		save_event();
		main_page();
		break;
	case 'delete':
		delete_event();
		main_page();
		break;
	case 'remove':
		delete_events();
		main_page();
		break;
}
CloseTable();
include('footer.php');
?>