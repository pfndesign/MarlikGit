<?php
/**
 *
 * @package Jquery Survey system                                                    
 * @version 1.0 Final $Aneeshtan  4:18 PM 2/10/2010    
 * @copyright (c)Marlik Group  http://www.MarlikCMS.com    Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)                                        
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */


require_once(MODS_PATH."poll/poll.php");

global $prefix,$sid,$db,$multilingual, $currentlang, $userinfo;

if ($multilingual == 1) {
	$querylang = "AND `planguage`='$currentlang'";
} else {
	$querylang = "";
}
$currentDomain = getenv("HTTP_HOST");


if ($_POST['voteID'] || $_POST['pollid']) {

	if ($_COOKIE["$currentDomain-poll" . $_POST['pollid']] != 'yes') {
		list($myIp) = $db->sql_fetchrow($db->sql_query("SELECT `ip` FROM " . $prefix . "_poll_check WHERE `ip`='" . getRealIpAddr() . "' AND `pollID`='" . $_POST["pollid"] . "' LIMIT 1 "));
		if (!empty($myIp)) {
			die("<br><span style='color:red'><b><img src='images/icon/error.png'>" . _YOU_VOTED_BEFORE . "</b></span><br>
    "._IP."<b>" . getRealIpAddr() . "</b>
    ");
		}
		if (!empty($_POST["voteID"])) {
			$zb = $db->sql_query("INSERT INTO ".$prefix."_poll_check (ip, time, pollID) VALUES('" . $_SERVER['REMOTE_ADDR'] . "', '" . date('Y-m-d H:i:s') . "','" . $_POST["pollid"] . "' )");
			if ($zb) {
				$db->sql_query("UPDATE " . $prefix . "_poll_data SET `optionCount`=`optionCount`+1 WHERE `pollID`='" . $_POST["pollid"] . "' AND `voteID`='" . $_POST["voteID"] . "'");
				$db->sql_query("UPDATE " . $prefix . "_poll_desc SET `voters`=`voters`+1 WHERE `pollID`='" . $_POST["pollid"] . "'");
				update_points(8);
				setcookie("$currentDomain-poll" . $_POST['pollid'], "yes-".intval($_POST["voteID"])."-".time()."", time() + 86400 * 300);
			}
		} else {
			die(_SURVEY_NOSURVEYFULL);
		}

	}

	//----------------------
	// This user had seen this survey or requested the result
	// lets show him the result
	//--------------------------
	echo showresults($_POST['pollid']);
}else {
	echo showresults($_GET['pollid']);
}