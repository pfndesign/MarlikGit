<?php
/*
* GregorianToJalali & JalaliToGregorian Converter
* GregorianToJalali Function source : http://www.farsiweb.info/jalali/jalali.phps
*
*
*	$test = new Converter;
*		$g2j = $test->GregorianToJalali('2000','10','10');
*			echo $g2j[0]." ".$g2j[1]." ".$g2j[2];
*		$j2g = $test->JalaliToGregorian('1386','12','26');
*			echo $j2g[0]." ".$j2g[1]." ".$j2g[2];
*
*/
class Converter {
	
var $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

function GregorianToJalali($g_y, $g_m, $g_d)
{
$g_days_in_month = $this->g_days_in_month;
$j_days_in_month = $this->j_days_in_month;
   
   $gy = $g_y-1600;
   $gm = $g_m-1;
   $gd = $g_d-1;

   $g_day_no = 365*$gy+$this->div($gy+3,4)-$this->div($gy+99,100)+$this->div($gy+399,400);

   for ($i=0; $i < $gm; ++$i)
      $g_day_no += $g_days_in_month[$i];
   if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
      /* leap and after Feb */
      ++$g_day_no;
   $g_day_no += $gd;

   $j_day_no = $g_day_no-79;

   $j_np = $this->div($j_day_no, 12053);
   $j_day_no %= 12053;

   $jy = 979+33*$j_np+4*$this->div($j_day_no,1461);

   $j_day_no %= 1461;

   if ($j_day_no >= 366) {
      $jy += $this->div($j_day_no-1, 365);
      $j_day_no = ($j_day_no-1)%365;
   }

   for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i) {
      $j_day_no -= $j_days_in_month[$i];
   }
   $jm = $i+1;
   $jd = $j_day_no+1;
	return array($jy, $jm, $jd);
}

function JalaliToGregorian($year,$month,$day)
{
$gDaysInMonth = $this->g_days_in_month;
$jDaysInMonth = $this->j_days_in_month;
$jy=$year-979;
$jm=$month-1;
$jd=$day-1;
$jDayNo=365*$jy + $this->div($jy,33)*8 + $this->div((($jy%33)+3),4);
	for ($i=0; $i < $jm; ++$i)  
	$jDayNo += $jDaysInMonth[$i];
$jDayNo +=$jd;
$gDayNo=$jDayNo + 79;
//146097=365*400 +400/4 - 400/100 +400/400
$gy=1600+400*$this->div($gDayNo,146097);
$gDayNo = $gDayNo%146097;
$leap=1;
if($gDayNo >= 36525)
{
	$gDayNo =$gDayNo-1;
	//36524 = 365*100 + 100/4 - 100/100
	$gy +=100* $this->div($gDayNo,36524);
	$gDayNo=$gDayNo % 36524;

	if($gDayNo>=365)
	$gDayNo = $gDayNo+1;
	else
	$leap=0;
}
//1461 = 365*4 + 4/4
$gy += 4*$this->div($gDayNo,1461);
$gDayNo %=1461;
if($gDayNo>=366)
{
	$leap=0;
	$gDayNo=$gDayNo-1;
	$gy += $this->div($gDayNo,365);
	$gDayNo=$gDayNo %365;
}
$i=0;
$tmp=0;
while ($gDayNo>= ($gDaysInMonth[$i]+$tmp))
{
    if($i==1 && $leap==1)
    $tmp=1;
    else
    $tmp=0;

    $gDayNo -= $gDaysInMonth[$i]+$tmp;
    $i=$i+1;
}
	$gm=$i+1;
	$gd=$gDayNo+1;
	return array($gy, $gm, $gd);
}


function div($a, $b) {
   return (int) ($a / $b);
}

}//Class END
?>