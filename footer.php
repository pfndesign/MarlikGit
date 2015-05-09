<?php
/**
*
* @package footer														
* @version $Id: footer.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


if (stristr(htmlentities($_SERVER['PHP_SELF']), "footer.php")) {
	Header("Location: index.php");
	die();
}

define('NUKE_FOOTER', true);


function footmsg() {
	global $foot1, $foot2, $foot3, $copyright, $total_time, $start_time, $commercial_license, $footmsg;
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$end_time = $mtime;
	$total_time = ($end_time - $start_time);
	$total_time = _PAGEGENERATION." ".substr($total_time,0,4)." "._SECONDS;
	$footmsg = "<span class=\"footmsg\">\n";
	if (!empty($foot1)) {
		$footmsg .= $foot1."<br>\n";
	}
	if (!empty($foot2)) {
		$footmsg .= $foot2."<br>\n";
	}
	if (!empty($foot3)) {
		$footmsg .= $foot3."<br>\n";
	}
	// DO NOT REMOVE THE FOLLOWING COPYRIGHT LINE. YOU'RE NOT ALLOWED TO REMOVE NOR EDIT THIS.
	// IF YOU REALLY NEED TO REMOVE IT AND HAVE MY WRITTEN AUTHORIZATION CHECK:
	// http://phpnuke.org/modules.php?name=Commercial_License
	// PLAY FAIR AND SUPPORT THE DEVELOPMENT, PLEASE!
	if ($commercial_license == 1) {
		$footmsg .= $total_time."<br>\n</span>\n";
	} else {
		$footmsg .= $copyright."<br>$total_time<br>\n</span>\n";
	}
	echo $footmsg;
}

function foot() {

	$fstart = benchGetTime();
	global $prefix, $user_prefix, $db, $index, $user, $cookie, $storynum, $user, $cookie, $Default_Theme, $foot1, $foot2, $foot3, $foot4, $home, $name, $admin, $commercial_license, $loading;
	if(defined('HOME_FILE')) {
		blocks("Down");
	}
	if (basename($_SERVER['PHP_SELF']) != "index.php" AND defined('MODULE_FILE') AND file_exists("modules/$name/copyright.php") && $commercial_license != 1) {
		$cpname = str_replace("_", " ", $name);
		echo "<div align=\"right\"><a href=\"javascript:openwindow()\">$cpname &copy;</a></div>";
	}
	if (basename($_SERVER['PHP_SELF']) != "index.php" AND defined('MODULE_FILE') AND (file_exists("modules/$name/admin/panel.php") && is_admin($admin))) {
		echo "<br>";
		OpenTable();
		include("modules/$name/admin/panel.php");
		CloseTable();
	}
	if (!defined("ADMIN_FILE")) {
		themefooter();
	}else {
		adminfooter();
	}
	if (file_exists("includes/custom_files/custom_footer.php")) {
		include_once("includes/custom_files/custom_footer.php");
	}
	//-- BenchMARK SYSTEM ----------------------------------------
	$fend = benchGetTime();
	if (BENCHMARK==true) {
		echo benchmark_overall($fstart,$fend,'FOOTER');
	}

	if ($loading == 1) {
		echo " <SCRIPT language=javascript> <!--
ap_showWaitMessage('waitDiv', 0); 
--> </SCRIPT> </body>\n</html>"; 
	}else{
		echo "</body>\n</html>";
	}


	//===================================================
	//GOOGLE TAP FEATURE
	//===================================================
	if (!defined("ADMIN_FILE")) {nextGenTap(0,1,0); }
	
	ob_end_flush();
	die();
}
//-- BenchMARK SYSTEM ----------------------------------------
$istart = benchGetTime();
include("includes/inc_counter.php");
$iend = benchGetTime();
if (BENCHMARK==true) {
	echo benchmark_overall($istart,$iend,'سیستم آمارگیر');
}
/*
foreach ($_REQUEST as $key => $value) {
    echo $key . ' has the value of ' . $value.'<br>';
}
*/
foot();



// Call this function to output everything as gzipped content.
print_gzipped_page();


?>