<?php
/*
* Armin Randjbar-Daemi <www.omnistream.co.uk>
* armin.randjbar AT gmail.com
*
* GNU General Public License <opensource.org/licenses/gpl-license.html>
* Demo: http://www.omnistream.co.uk/calendar/
* last modified: march 2008 <ver 1.0>
*/

global $currentlang;
if ($currentlang == "persian") {
	
	//Check if the month and year values exist
	if (isset ( $_GET ['m'], $_GET ['y'] )) {
		$month = intval ( $_GET ['m'] );
		$year = intval ( $_GET ['y'] );
		$Calendar->Calendar_OtherMonth ( $year, $month );
	} else {
		$gyear = date ( 'Y' );
		$gmonth = date ( 'n' );
		$gday = date ( 'j' );
		$ThisMonth = $Calendar->Calendar_ThisMonth ( $gyear, $gmonth, $gday );
		$year = $ThisMonth [0];
		$month = $ThisMonth [1];
	}
	//generate "next" and "prev" links
	if ($month != '12') {
		$next_month = "y=" . $year;
		$next_month .= "&amp;m=";
		$next_month .= $month + 1;
	} else {
		$next_month = "y=";
		$next_month .= $year + 1;
		$next_month .= "&amp;m=1";
	}
	if ($month != '1') {
		$prev_month = "y=" . $year;
		$prev_month .= "&amp;m=";
		$prev_month .= $month - 1;
	} else {
		$prev_month = "y=";
		$prev_month .= $year - 1;
		$prev_month .= "&amp;m=12";
	}
	?>
<table style="width: 350px; height: 230px;" dir="rtl" class="month">
	<tr>
		<th class="calendar-head"><span> <a
			href="<?php
	echo "modules.php?name=jCalendar&" . $prev_month;
	?>">قبلی</a>
		</span>
		
		
		</td>
		<td colspan="5" class="calendar-head"
			style="width: 248px; text-align: center;"><span>
			<?php
	echo $Calendar->shamsi_month_year;
	?>
		</span></td>
		<td class="calendar-head"><span> <a
			href="<?php
	echo "modules.php?name=jCalendar&" . $next_month;
	?>">بعدی</a>
		</span>
		
		
		</th>
	</tr>
	<tr>
		<td class="calendar-head"><span>شنبه</span></td>
		<td class="calendar-head"><span>يكشنبه</span></td>
		<td class="calendar-head"><span>دوشنبه</span></td>
		<td class="calendar-head"><span>سه‌شنبه</span></td>
		<td class="calendar-head"><span>چهارشنبه</span></td>
		<td class="calendar-head"><span>پنجشنبه</span></td>
		<td class="calendar-head"><span>جمعه</span></td>
	</tr>
<?php
	if ($Calendar->month_first_day == 6)
		$startdate = - $Calendar->month_first_day + 6;
	else
		$startdate = - $Calendar->month_first_day - 1;
	
	//Figure out how many rows we need.
	$numrows = ceil ( ($Calendar->month_total_days + $Calendar->month_first_day + 1) / 7 );
	//Let's make an appropriate number of rows...
	for($k = 1; $k <= $numrows; $k ++) {
		?><tr><?php
		//Use 7 columns (for 7 days)...
		for($i = 0; $i < 7; $i ++) {
			$startdate ++;
			$event = NULL;
			$holiday = NULL;
			$title = NULL;
			$linkstr = NULL;
			$tiptip_tag1 = NULL;
			$tiptip_tag2 = NULL;
			$this_day = $year . "-" . $month . "-" . $startdate;
			if ($EventsMatrix != NULL && in_array ( $this_day, $EventsMatrix ['day'], TRUE )) {
				$event = " event";
				global $db, $prefix;
				list ( $holiday, $title, $linkstr ) = $db->sql_fetchrow ( $db->sql_query ( 'SELECT `holiday`,`title`,`linkstr` FROM `' . $prefix . '_jcalendar_events` WHERE approved=1 AND `start_date` <= "' . $this_day . '" AND  `end_date` >= "' . $this_day . '" LIMIT 1' ) );
				if ($holiday == 'yes')
					$holiday = ' holiday';
				else
					$holiday = NULL;
				
				$tiptip_tag1 = '<a href="' . $linkstr . '"   title="' . $title . '"><b>';
				$tiptip_tag2 = '</a></b>';
			}
			
			if (($startdate <= 0) || ($startdate > $Calendar->month_total_days)) {
				//If we have a blank day in the calendar.
				?><td></td>
				<?php
			} elseif ($this_day == $Calendar->today) {
				?><td class="calendar-today <?php
				echo $this_day, $event, $holiday;
				?>"><?php
				echo $tiptip_tag1;
				echo farsinum ( $startdate );
				echo $tiptip_tag2;
				?></td><?php
			} else {
				?><td
			class="calendar-body <?php
				echo $this_day, ' ', $event, $holiday;
				?>"><?php
				echo $tiptip_tag1;
				echo farsinum ( $startdate );
				echo $tiptip_tag2;
				?></td><?php
			}
		}
		?></tr><?php
	}
	?>
</table>
<?php
} else {
	require_once 'modules/jCalendar/includes/ECalendar.php';
	$cal = new ECalendar ();
	
	if (isset ( $_GET ['m'], $_GET ['y'] )) {
		$month = intval ( $_GET ['m'] );
		$year = intval ( $_GET ['y'] );
		if ($year < 1900){
		$backtojeo = jalali_to_gregorian($year,$month,'1');
     	echo $cal->getMonthView($backtojeo[1], $backtojeo[0]);
		}else {
     	echo $cal->getMonthView($month, $year);	
		}
     	
	}else{
		echo $cal->getCurrentMonthView ();
	}
	
}
?>