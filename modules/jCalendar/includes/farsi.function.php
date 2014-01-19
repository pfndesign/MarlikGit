<?php
function farsinum($str)
{
  if (strlen($str) == 1)
      $str = "0".$str;
  $out = "";
  for ($i = 0; $i < strlen($str); ++$i) {
    $c = substr($str, $i, 1);
    $out .= pack("C*", 0xDB, 0xB0 + $c);
  }
  return $out;
}

function farsimonth($jmonth)
{
    switch ($jmonth) {
        case "01":
            return "فروردین";
        case "02":
            return "اردیبهشت";
        case "03":
            return "خرداد";
        case "04":
            return "تیر";
        case "05":
            return "مرداد";
        case "06":
            return "شهریور";
        case "07":
            return "مهر";
        case "08":
            return "آبان";
        case "09":
            return "آذر";
        case "10":
            return "دی";
        case "11":
            return "بهمن";
        case "12":
			return "اسفند";
	}
}

function farsiday($jday)
{
    switch ($jday) {
        case "01":
            return "اول";
        case "02":
            return "دوم";
        case "03":
            return "سوم";
        case "04":
            return "چهارم";
        case "05":
            return "پنجم";
        case "06":
            return "ششم";
        case "07":
            return "هفتم";
        case "08":
            return "هشتم";
        case "09":
            return "نهم";
        case "10":
            return "دهم";
        case "11":
            return "يازدهم";
        case "12":
			return "دوازدهم";
        case "13":
			return "سيزدهم";
        case "14":
			return "چهاردهم";
        case "15":
			return "پانزدهم";
        case "16":
			return "شانزدهم";
        case "17":
			return "هفدهم";
        case "18":
			return "هجدهم";
        case "19":
			return "نوزدهم";
        case "20":
			return "بيستم";
        case "21":
			return "بيست و يکم";
        case "22":
			return "بيست و دوم";
        case "23":
			return "بيست و سوم";
        case "24":
			return "بيست و چهارم";
        case "25":
			return "بيست و پنجم";
        case "26":
			return "بيست و ششم";
        case "27":
			return "بيست و هفتم";
        case "28":
			return "بيست و هشتم";
        case "29":
			return "بيست و نهم";
        case "30":
			return "سي ام";
        case "31":
			return "سي و يکم";
	}
}
?>