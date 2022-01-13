<?php
/**
*
* @package Convert
* @copyright (c) Marlik Group  http://www.MarlikCMS.com $Aneeshtan
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
require_once("mainfile.php");
global $admin,$prefix,$USV_Version;
if (is_superadmin($admin)) {
	define("NL_VERSION",$USV_Version);
	?>
	<center>
	<div class="sidebox" style="background:#BCE1F6" >
	<span style='text-align:center;'>
	<p>برنامه تبدیل  سایر پرتال ها به پرتال نیوک لرن , نرم افزاری است که شما می توانید از طریق یک سیستم خودکار و هوشمند به پرتال نیوک لرن کوچ کنید 
	<br>
	کافی است که نام پرتال کنونی خود را از لیست زیر انتخاب کنید  و برنامه تبدیل پرتال را آغاز کنید 
	</p>
	</span>
	</center>
	<?php echo $pagetitle;
	$pagetitle = "برنامه تبدیل به پرتال نیوک لرن";
	title("$pagetitle");
	echo "<table align='center' border='0'>\n";
	echo "<form action='install.php' method='GET'>\n";
	echo "<tr><td align='center'><font color='red'>بهتر است اول از ديتابيس خود پشتيباني بگيريد</font><br>
       	<br></td></tr>\n";

	echo "<tr><td></td></tr>\n";
	echo "<tr><td align='center'>
       		<select id='act' name='act' style='width:200px;'>\n";
	echo "<option value='mt_convert'>تبدیل پرتال نیوک مشهدتیم</option>\n";
	echo "<option value='jm_convert'> تبدیل پرتال جوملا</option>\n";
	echo "<option value='dl_convert'>تبدیل دیتالایف </option>\n";
	echo "<option value='wp_convert'>تبدیل وردپرس  </option>\n";
	echo "</select> 
	<input type='hidden' name='convert' value='1'>
       		<input type='submit' value='انتخاب نوع پرتال'></td></tr>\n";
	echo "</form>";
	echo "</table>\n";
	
	
	switch($_GET['act']) {
		case "mt_convert":
		include("INSTALLATION/mt_convert.php");
		break;
		
		case "":
		break;
		
	}
} else {
	echo "<b><img src='images/icon/note.png'>تنها مدیرکل سایت امکان اجرای ارتقا سایت را دارد . <br>
	در صورتی که مدیر این سایت هستید . به بخش مدیریت خود وارد شوید و مجدد این بخش را اجرا کنید.<br><br><br>
	<img src='images/icon/user.png'><a href='install.php' class='button'>بازگشت به صفحه اول نصب کننده</a>
	</b>\n";
}
?>
	<p class="footmsg_l"><a href='http://www.MarlikCMS.com'>Powered By MarlikCMS</a><br></p>
	</div>