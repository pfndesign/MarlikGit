<?php
/*
* Armin Randjbar-Daemi <www.omnistream.co.uk>
* armin.randjbar AT gmail.com
*
* GNU General Public License <opensource.org/licenses/gpl-license.html>
* Demo: http://www.omnistream.co.uk/calendar/
* last modified: march 2008 <ver 1.0>
*/

//include farsinum($str); & farsimonth($jmonth); Functions
require_once ('farsi.function.php');

//GregorianToJalali & JalaliToGregorian Converter
require_once ('Converter.Class.php');

class Calendar extends Converter {

//we show it on Calendar's head
var $shamsi_month_year;

//show today on calendar
var $today;

//we need 2 variables to create the month
var $month_first_day;
var $month_total_days;

//We get Gregorian date from server, and find "first day" & "total days" of Jalali month
//Also returns an array, to create "prev" & "next" links, and show Today.
function Calendar_ThisMonth($year,$month,$day)
{
	list($jyear,$jmonth,$jday) = Converter::GregorianToJalali($year,$month,$day);
	$this->shamsi_month_year = farsimonth($jmonth)."&nbsp;".farsinum($jyear);
	
	$this->month_first_day = $this->find_first_day($jmonth,$jyear);
	$this->month_total_days = $this->find_total_days($jmonth,$jyear);
	$this->today = $jyear."-".$jmonth."-".$jday;
	
	return array($jyear,$jmonth);
}

//We get Jalali "Year" & "Month" from $_GET[] and find "first day" & "total days" of Jalali month.
function Calendar_OtherMonth($jyear,$jmonth)
{
	$this->shamsi_month_year = farsimonth($jmonth)."&nbsp;".farsinum($jyear);
	$this->month_first_day = $this->find_first_day($jmonth,$jyear);
	$this->month_total_days = $this->find_total_days($jmonth,$jyear);
	$this->today = $this->find_today();
}

function find_first_day($jmonth,$jyear)
{
	list($gyear,$gmonth,$gday) = Converter::JalaliToGregorian($jyear,$jmonth,'1');
	return date('w', mktime(0, 0, 0, $gmonth, $gday, $gyear));
}

function find_total_days($jmonth,$jyear)
{
	if($jmonth!=12) {
		return $this->j_days_in_month[$jmonth-1];
	} else {
		//I don't like this part of the code :|
		$temp1 = Converter::JalaliToGregorian($jyear,'12','29');
		$temp2 = Converter::JalaliToGregorian($jyear+1,'1','1');
		if ($temp2[2]-$temp1[2]==2) return 30;
		else return 29;
	}
}

function find_today()
{
	$gyear = date('Y');
	$gmonth = date('n');
	$gday = date('j');
	list($jyear,$jmonth,$jday) = Converter::GregorianToJalali($gyear,$gmonth,$gday);
	return $jyear."-".$jmonth."-".$jday;
}
/*
 * This part is added by me (Hamed)
 * let's mark it my initials
 * [H.M] Begins
 * */
function howmanydays($date){
	define('GENESIS',1300);
	$days = 0;
	$days = ($date[0] - GENESIS) * 365;
	$months = array(31,31,31,31,31,31,30,30,30,30,30,29);
	for($i=0;$i<$date[1];$i++){
		$days += $months[$i];
	}
	$days += intval($date[2]);
	$j=0;
	for($i=$date[2];$i>=GENESIS;$i--){
		if((($i % 4 == 0) && ($i % 100 != 0)) OR $i % 400 == 0){
			$j++;
		}
	}
	return $days+$j;
}
function jdate_diff($start_date,$end_date){
	$start_date = explode(' ',$start_date);
	$stime = explode(":",$start_date[1]);
	$sdate = explode("-",$start_date[0]);
	$end_date = explode(' ',$end_date);
	$etime = explode(":",$end_date[1]);
	$edate = explode("-",$end_date[0]);
	return $this->howmanydays($edate) - $this->howmanydays($sdate);
}
function datepluse1($date){
	$date[0] = intval($date[0]);
	$months = array(31,31,31,31,31,31,30,30,30,30,30,29);
	$date[2]++;
	if($date[2] > $months[intval($date[1])-1]){
		$date[1]++;
		$date[2] = 1;
	}
	if($date[1] > 12){
		$date[0]++;
		$date[1] = 1;
		$date[2] = 1;
	}
	return $date;
}
// [H.M] Ends
}//Class END
?>