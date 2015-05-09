<?php
/**
 *
 * @package Shamsi Date Functions											
 * @version  inc_JalaliDate.php $Id: beta6  2:12 AM 12/25/2009						
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_JalaliDate.php" )) {
	show_error ( HACKING_ATTEMPT );
}

function formatTimestamp($time) {
	global $datetime, $locale;
	setlocale (LC_TIME, $locale);
    if (str_replace ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime)) {
	// We've got to use strftime to use the $locale var
        $datetime = hejridate($time, 4, 1);
    } else {
        $datetime = '';
    }
	return $datetime;
}

//Farsi Functions

//Part1 (Date convertor Functions)
//base function used in other functions
function div($a, $b)
{
   return (int) ($a / $b);
}

$hejri_error = ""._JDATE_ERROR."";
$g_month_name = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$g_month_short = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$j_month_name = array("",""._JDATE_FARVARDIN."",""._JDATE_ORDIBEHESHT."",""._JDATE_KHORDAD."",""._JDATE_TIR."",""._JDATE_MORDAD."",""._JDATE_SHAHRIVAR."",""._JDATE_MEHR."",""._JDATE_ABAN."",""._JDATE_AZAR."",""._JDATE_DEY."",""._JDATE_BAHMAN."",""._JDATE_ESFAND."");
$g_week_name = array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
$j_week_name = array("", ""._JDATE_SHANBE."", ""._JDATE_YEKSHANBE."", ""._JDATE_DOSHANBE."", ""._JDATE_SESHANBE."", ""._JDATE_CHAHARSHANBE."", ""._JDATE_PANJSHANBE."", ""._JDATE_JOME."");
$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

function gregorian_to_jalali($g_y, $g_m, $g_d)
{
   global $g_days_in_month;
   global $j_days_in_month;

   $gy = $g_y-1600;
   $gm = $g_m-1;
   $gd = $g_d-1;

   $g_day_no = 365*$gy+div($gy+3,4)-div($gy+99,100)+div($gy+399,400);

   for ($i=0; $i < $gm; ++$i)
      $g_day_no += $g_days_in_month[$i];
   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
      /* leap and after Feb */
      $g_day_no++;
   $g_day_no += $gd;

   $j_day_no = $g_day_no-79;

   $j_np = div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
   $j_day_no = $j_day_no % 12053;

   $jy = 979+33*$j_np+4*div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */

   $j_day_no %= 1461;

   if ($j_day_no >= 366) {
      $jy += div($j_day_no-1, 365);
      $j_day_no = ($j_day_no-1)%365;
   }

   for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
      $j_day_no -= $j_days_in_month[$i];
   $jm = $i+1;
   $jd = $j_day_no+1;

   return array($jy, $jm, $jd);
}

function jalali_to_gregorian($j_y, $j_m, $j_d)
{
   global $g_days_in_month;
   global $j_days_in_month;

   $jy = $j_y-979;
   $jm = $j_m-1;
   $jd = $j_d-1;

   $j_day_no = 365*$jy + div($jy, 33)*8 + div($jy%33+3, 4);
   for ($i=0; $i < $jm; ++$i)
      $j_day_no += $j_days_in_month[$i];

   $j_day_no += $jd;

   $g_day_no = $j_day_no+79;

   $gy = 1600 + 400*div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
   $g_day_no = $g_day_no % 146097;

   $leap = true;
   if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
   {
      $g_day_no--;
      $gy += 100*div($g_day_no,  36524); /* 36524 = 365*100 + 100/4 - 100/100 */
      $g_day_no = $g_day_no % 36524;

      if ($g_day_no >= 365)
         $g_day_no++;
      else
         $leap = false;
   }

   $gy += 4*div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
   $g_day_no %= 1461;

   if ($g_day_no >= 366) {
      $leap = false;

      $g_day_no--;
      $gy += div($g_day_no, 365);
      $g_day_no = $g_day_no % 365;
   }

   for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
      $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
   $gm = $i+1;
   $gd = $g_day_no+1;

   return array($gy, $gm, $gd);
}

function gregorian_week_day($g_y, $g_m, $g_d)
{
   global $g_days_in_month;

   $gy = $g_y-1600;
   $gm = $g_m-1;
   $gd = $g_d-1;

   $g_day_no = 365*$gy+div($gy+3,4)-div($gy+99,100)+div($gy+399,400);

   for ($i=0; $i < $gm; ++$i)
      $g_day_no += $g_days_in_month[$i];
   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
      /* leap and after Feb */
      ++$g_day_no;
   $g_day_no += $gd;

   return ($g_day_no + 5) % 7 + 1;
}

function jalali_week_day($j_y, $j_m, $j_d)
{
   global $j_days_in_month;

   $jy = $j_y-979;
   $jm = $j_m-1;
   $jd = $j_d-1;

   $j_day_no = 365*$jy + div($jy, 33)*8 + div($jy%33+3, 4);

   for ($i=0; $i < $jm; ++$i)
      $j_day_no += $j_days_in_month[$i];

   $j_day_no += $jd;

   return ($j_day_no + 2) % 7 + 1;
}

function jcheckdate($j_m, $j_d, $j_y)
{
   global $j_days_in_month;

   if ($j_y < 0 || $j_y > 32767 || $j_m < 1 || $j_m > 12 || $j_d < 1 || $j_d >
           ($j_days_in_month[$j_m-1] + ($j_m == 12 && !(($j_y-979)%33%4))))
       return false;
   return true;
}

//Base convertor
function hejridate ($date = NULL, $tinput = '4', $toutput = '1') {
        global $currentlang,$hejri_error, $j_month_name, $j_week_name, $locale, $datetime;
        if ($date == NULL) {
           $date = getdate();
           $date = $date['year']."-".$date['mon']."-".$date['mday']." ".$date['hours'].":".$date['minutes'].":".$date['seconds'];
           setlocale (LC_TIME, "$locale");
        }
        if ($currentlang == "persian") {
   
        switch ($tinput) {
           case '1':
                 $pattern = "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})";
                 $sort = 1;
                 break;
           case '2':
                 $pattern = "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})";
                 $sort = 2;
                 break;
           case '3':
                 $pattern = "([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})";
                 $sort = 3;
                 break;
           case '4':
                 $pattern = "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})";
                 $sort = 1;
                 break;
           case '5':
                 $pattern = "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})";
                 $sort = 1;
                 break;
           case '6':
                 $pattern = "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})";
                 $sort = 2;
                 break;
           case '7':
                 $pattern = "([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})";
                 $sort = 3;
                 break;
           case '8':
                 $pattern = "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})";
                 $sort = 1;
                 break;
         }
         if (preg_match("/$pattern/", $date, $datetime)) {
           switch ($sort) {
              case '1':
                    $year = $datetime[1];
                    $month = $datetime[2];
                    $day = $datetime[3];
                    break;
              case '2':
                    $year = $datetime[1];
                    $month = $datetime[3];
                    $day = $datetime[2];
                    break;
              case '3':
                    $year = $datetime[3];
                    $month = $datetime[2];
                    $day = $datetime[1];
                    break;
           }
           $hejriDate = gregorian_to_jalali($year,$month,$day);
           //if (!$datetime[4]) $datetime[4] = $datetime[5] = $datetime [6] = '00';
           $tep_hd = jalali_week_day($hejriDate[0],$hejriDate[1],$hejriDate[2]);
           switch ($toutput) {
              case '1':
                    $ehejri = $j_week_name[$tep_hd]."، ".$hejriDate[2]." ".$j_month_name[$hejriDate[1]]."، ".$hejriDate[0];
                    break;
              case '2':
                    $ehejri = $hejriDate[1]."-".$hejriDate[2]."-".$hejriDate[0];
                    break;
              case '3':
                    $ehejri = $hejriDate[0]."/".$hejriDate[1]."/".$hejriDate[2];
                    break;
              case '4':
                    $ehejri = $hejriDate[2]." ".$j_month_name[$hejriDate[1]]." ".$hejriDate[0];
                    break;
              case '5':
                    $ehejri = $j_week_name[$tep_hd]."، ".$hejriDate[2]." ".$j_month_name[$hejriDate[1]];
                    break;
              case '6':
                    $ehejri = $hejriDate[2]." ".$j_month_name[$hejriDate[1]]." ".$hejriDate[0]." @ ".$datetime[4].":".$datetime[5].":".$datetime[6];
                    break;
              case '7':
                    $ehejri = $j_week_name[$tep_hd]." ".$hejriDate[2]." ".$j_month_name[$hejriDate[1]]." ".$hejriDate[0]." ".$datetime[4].":".$datetime[5].":".$datetime[6];
                    break;
              case '8':
                    $ehejri = $hejriDate[0]."-".$hejriDate[1]."-".$hejriDate[2];
                    break;
              case '9':
                    $ehejri = $hejriDate[0]."-".$hejriDate[1]."-".$hejriDate[2]." ".$datetime[4].":".$datetime[5].":".$datetime[6];
                    break;
           }
           return $ehejri;
        } else {
           return $hejri_error;
        }
        }else {
           return $date;
        }
}

function hejriback ($date, $tinput = 1, $toutput = 2) {
        global $hejri_error;
        switch ($tinput) {
           case '1':
                 $pattern = "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})";
                 break;
           case '2':
                 $pattern = "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})";
                 break;
           case '3':
                 $pattern = "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})";
                 break;
           case '4':
                 $pattern = "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})";
                 break;
        }
         if (preg_match("/$pattern/", $date, $datetime)) {
           $gredate = jalali_to_gregorian($datetime[1],$datetime[2],$datetime[3]);
           if (!$datetime[4]) $datetime[4] = $datetime[5] = $datetime [6] = 0;
           switch ($toutput) {
              case '1':
                    $edate = sprintf("%02d",$gredate[0]) ."/". sprintf("%02d",$gredate[1]) ."/".$gredate[2];
                    break;
              case '2':
                    $edate = sprintf("%02d",$gredate[0]) ."-". sprintf("%02d",$gredate[1]) ."-".$gredate[2];
                    break;
              case '3':
                    $edate = sprintf("%02d",$gredate[0]) ."-". sprintf("%02d",$gredate[1]) ."-".$gredate[2]. " " . sprintf("%02d",$datetime[4]).":".sprintf("%02d",$datetime[5]).":".sprintf("%02d",$datetime[6]);
                    break;
           }
           return $edate;
        } else {
           return $hejri_error;
        }
}

//creates a pull_down list of hejri month
function get_hejri_month($name, $selected = '') {
        global $j_month_name;
        $menu = '<select name="' . $name . '">'. "\n" .'<option value="0">'._JDATE_SELECT.'</option>' . "\n";
        for ($i=1, $n=sizeof($j_month_name); $i<$n; $i++) {
             $menu .= '<option value="' . $i . '"';
             if ($i == $selected) $menu .= ' selected';
             $menu .= '>' . $j_month_name[$i] . '</option>' . "\n";
        }
        $menu .= '</select>' . "\n";
        return $menu;
}

//creates a pull_down list of month days
function get_hejri_day($month, $name, $selected = '') {
        global $j_days_in_month;
        $menu = '<select name="' . $name . '">'. "\n" .'<option value="1">01</option>' . "\n";
        $n = $j_days_in_month[$month-1];
        for ($i=2; $i<=$n; $i++) {
             $menu .= '<option value="' . $i . '"';
             if ($i == $selected) $menu .= ' selected';
             $menu .= '>' . sprintf("%02d",$i) . '</option>' . "\n";
        }
        $menu .= '</select>' . "\n";
        return $menu;
}

//get pm And am and return farsi values
function farsi_time ($time) {
        if ($time == 'pm' OR $time == 'PM') {
             $time = '"._JDATE_PM."';
        } elseif ($time == 'am' OR $time == 'AM') {
             $time = '"._JDATE_AM."';
        }
        return $time;
}

//get gregorian month name and return number of month
function month_number($name, $type = '1') {
        global $g_month_short, $g_month_name;
        if (!$type) $type = 1;
        switch ($type) {
             case '1' :
                   $month_array = $g_month_name;
                   break;
             case '2' :
                   $month_array = $g_month_short;
                   break;
        }
        for ($i=1; $i<sizeof($month_array); $i++) {
             if ($month_array[$i] == $name) {
                   $number = $i;
                   break;
             }
        }
        return $number;
}
//End of Part1


//Part3
function sttr($a, $b){
	return (int)($a / $b);
}

function m2sr ($g_y, $g_m, $g_d){
	$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
	$gy = $g_y-1600;
	$gm = $g_m-1;
	$gd = $g_d-1;
	$g_day_no = 365*$gy+sttr($gy+3,4)-sttr($gy+99,100)+sttr($gy+399,400);
	for ($i=0; $i < $gm; ++$i)
		$g_day_no += $g_days_in_month[$i];
	if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
		/* leap and after Feb */
		$g_day_no++;
	$g_day_no += $gd;

	$j_day_no = $g_day_no-79;

	$j_np = sttr($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
	$j_day_no = $j_day_no % 12053;

	$jy = 979+33*$j_np+4*sttr($j_day_no,1461); /* 1461 = 365*4 + 4/4 */

	$j_day_no %= 1461;

	if($j_day_no >= 366){
	$jy += sttr($j_day_no-1, 365);
	$j_day_no = ($j_day_no-1)%365;
}

for($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
	$j_day_no -= $j_days_in_month[$i];
	$jm = $i+1;
	$jd = $j_day_no+1;
	return array($jy, $jm, $jd);
}
$date_months = array(''._JDATE_FARVARDIN.'', ''._JDATE_ORDIBEHESHT.'', ''._JDATE_KHORDAD.'', ''._JDATE_TIR.'', ''._JDATE_MORDAD.'', ''._JDATE_SHAHRIVAR.'', ''._JDATE_MEHR.'', ''._JDATE_ABAN.'', ''._JDATE_AZAR.'', ''._JDATE_DEY.'', ''._JDATE_BAHMAN.'', ''._JDATE_ESFAND.'');

$date_days = array(''._JDATE_YEKSHANBE.'', ''._JDATE_DOSHANBE.'', ''._JDATE_SESHANBE.'', ''._JDATE_CHAHARSHANBE.'', ''._JDATE_PANJSHANBE.'', ''._JDATE_JOME.'', ''._JDATE_SHANBE.'');


function Convertnumber2farsi($srting) 
{
    $en_num = array("0","1","2","3","4","5","6","7","8","9");
    $fa_num = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
    return str_replace($en_num,$fa_num, $srting);

}///end conver to number in persian  
function remainOfTimeInWords($fromTime, $toTime = 0, $showLessThanAMinute = false) {
    $distanceInSeconds = round(abs($toTime - $fromTime));
    $distanceInMinutes = round($distanceInSeconds / 60);

        if ( $distanceInMinutes < 2880 ) {
            return 'فردا';
        }
        if ( $distanceInMinutes < 43200 ) {
            return '' . round(floatval($distanceInMinutes) / 1440) . ' روز دیگر ';
        }
        if ( $distanceInMinutes < 19600 ) {
            return 'هفته آینده';
        }

        if ( $distanceInMinutes < 86400 ) {
            return 'ماه دیگر';
        }
        if ( $distanceInMinutes < 525600 ) {
            return round(floatval($distanceInMinutes) / 43200) . ' ماه دیگر';
        }
        if ( $distanceInMinutes < 1051199 ) {
            return 'سال دیگر';
        }
       
}
function distanceOfTimeInWords($fromTime, $toTime = 0, $showLessThanAMinute = false) {
				$distanceInSeconds = round(abs($toTime - $fromTime));
				$distanceInMinutes = round($distanceInSeconds / 60);

				if ( $distanceInMinutes <= 1 ) {
					if ( !$showLessThanAMinute ) {
						return ($distanceInMinutes == 0) ? 'less than a minute' : '1 minute';
					} else {
						if ( $distanceInSeconds < 5 ) {
							return 'کمتر از 5 ثانیه';
						}
						if ( $distanceInSeconds < 10 ) {
							return 'کمتر از10 ثانیه';
						}
						if ( $distanceInSeconds < 20 ) {
							return 'کمتر از20 ثانیه';
						}
						if ( $distanceInSeconds < 40 ) {
							return 'حدود نیم دقیقه';
						}
						if ( $distanceInSeconds < 60 ) {
							return 'کمتر از 1 دقیقه';
						}

						return '1 دقیقه ';
					}
				}
				if ( $distanceInMinutes < 45 ) {
					return $distanceInMinutes . ' دقیقه پیش';
				}
				if ( $distanceInMinutes < 90 ) {
					return '1 ساعت پیش';
				}
				if ( $distanceInMinutes < 1440 ) {
					return '' . round(floatval($distanceInMinutes) / 60.0) . 'ساعت پیش';
				}
				if ( $distanceInMinutes < 2880 ) {
					return 'دیروز';
				}
				if ( $distanceInMinutes < 43200 ) {
					return '' . round(floatval($distanceInMinutes) / 1440) . ' روز پیش ';
				}
				if ( $distanceInMinutes < 19600 ) {
					return 'هفته گذشته';
				}

				if ( $distanceInMinutes < 86400 ) {
					return 'ماه پیش';
				}
				if ( $distanceInMinutes < 525600 ) {
					return round(floatval($distanceInMinutes) / 43200) . ' ماه پیش';
				}
				if ( $distanceInMinutes < 1051199 ) {
					return 'سال پیش';
				}

				return 'بیش از ' . round(floatval($distanceInMinutes) / 525600) . 'سال پیش';
			}
function zonedate($layout, $countryzone, $daylightsaving)
{
if ($daylightsaving){
$daylight_saving = date('I');
if ($daylight_saving){$zone=3600*($countryzone+1);}
}
else {
   if ($countryzone>>0){$zone=3600*$countryzone;}
       else {$zone=0;}
}
$date=gmdate($layout, time() + $zone);
return $date;
} 

	

?>