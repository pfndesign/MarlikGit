<?php

/**
 *
 * @package Jquery Survey system													
 * @version 1.0 Final $Aneeshtan  4:18 PM 2/10/2010	
 * @copyright (c)Nukelearn Group  http://www.nukelearn.com	Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)										
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix,$db,$multilingual, $currentlang, $userinfo;

require_once(MODS_PATH."poll/poll.php");

$content .='<div id="pollcontainer" >';

$currentDomain = getenv("HTTP_HOST");
if ($multilingual == 1) {
	$querylang = " `planguage`='$currentlang' AND `active`='1' ";
} else {
	$querylang = " `active`='1' ";
}
$sid = (!empty($_GET['sid']) ? sql_quote($_GET['sid']) : 0 );

if (!$_POST['voteID'] || !$_POST['pollid']) {
	 
	// check and find poll id  
	$result = $db->sql_query("SELECT  *  FROM " . $prefix . "_poll_desc WHERE $querylang AND `artid`= '".intval($sid)."'  AND active = '1'
	ORDER BY `artid` ASC,pollID DESC  LIMIT 1");
	$holdtitle = $db->sql_fetchrow($result);
	$pollID = $holdtitle['pollID'];
	if (empty($pollID)) {
		$content .=_NO_SURVEY_HAS_BEEN_SET;
	}
	$db->sql_freeresult($result);
	
	
	//lets check if you have already voted.
	$result = $db->sql_query("SELECT `ip` FROM " . $prefix . "_poll_check WHERE `ip`='" . getRealIpAddr() . "' AND `pollID`='$pollID' LIMIT 1 ");
	list($myIp) = $db->sql_fetchrow();
	$db->sql_freeresult($result);
	
	//if already voted or asked for result
	if ($_GET["result"] == 1 || ($_COOKIE["$currentDomain-poll" . $pollID] == 'yes') || !empty($myIp)) {
		$content .= "<b>$holdtitle[1]</b><br><br>";
		$content .= showresults($pollID);
	} else {

		//display options with radio buttons
		$content .= "<b>" . $holdtitle[1] . "</b><br><br>";
		$query = $db->sql_query("SELECT pollID, optionText,voteID FROM ".$prefix."_poll_data WHERE `pollID`='$pollID' AND optionText!=''");
		if ($db->sql_numrows($query)) {
			$content .= '<div id="formcontainer" ><form method="post" id="pollform" action="modules.php?app=mod&name=poll" >';
			$content .= '<input type="hidden" name="pollid" value="' . $pollID . '" />';
			while ($row = $db->sql_fetchrow($query)) {
				$content .= '<input type="radio" name="voteID" value="' . $row['voteID'] . '" id="option-' . $row['voteID'] . '" />
                <label for="option-' . $row['voteID'] . '" >' . $row['optionText'] . '</label><br>';
			}
			$content .= '<p><center><input type="submit" id="pollform"  value="' . _VOTE . '" /></center></p></form>';
			$content .= '<p><a href="modules.php?app=mod&name=poll&result=1&pollid='.$pollID.'" class="viewresult" id="'.$pollID.'"><img src="images/icon/hourglass.png"><b>' . _RESULTS . '</b></a></p></div>';
		}else {
			$content .=_NO_SURVEY_HAS_BEEN_SET;
		}
		$db->sql_freeresult($query);
	}
} else {
	
	
	if ($_COOKIE["$currentDomain-poll" . $_POST['pollid']] != 'yes') {
		list($myIp) = $db->sql_fetchrow($db->sql_query("SELECT `ip` FROM " . $prefix . "_poll_check WHERE `ip`='" . getRealIpAddr() . "' AND `pollID`='" . $_POST["pollid"] . "' LIMIT 1 "));
		if (!empty($myIp)) {
			die("<br><span style='color:red'><b><img src='images/icon/error.png'>" . _YOU_VOTED_BEFORE . "</b></span><br>
    "._IP.": <b>" . getRealIpAddr() . "</b>
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
			$content .=_SURVEY_NOSURVEYFULL;
		}

	} else {
		$content .=_SURVEY_NOSURVEYFULL;
	}

	//----------------------
	// This user had seen this survey or requested the result
	// lets show him the result
	//--------------------------
	$content .= showresults($_POST['pollid']);
}
	$content .='</div>';

?>