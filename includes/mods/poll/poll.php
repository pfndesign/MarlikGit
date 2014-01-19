<?php
/**
 *
 * @package Jquery Survey system													
 * @version 1.0 Final $Aneeshtan  4:18 PM 2/10/2010	
 * @copyright (c)Nukelearn Group  http://www.nukelearn.com	Copyright (c) 2009 Anant Garg (anantgarg.com | inscripts.com)										
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".MODS_PATH."poll/styles.css\" />
<script type=\"text/javascript\" src=\"".MODS_PATH."poll/poll.js\"></script>";

function showresults($pollID)
{
	global $prefix, $db, $userinfo;

	$pollID = intval($pollID);
	if (empty($pollID)){
		$pollID = 1;
	}

	/* select next vote option */
	$result  = $db->sql_query("SELECT SUM(`optionCount`) AS sumoption FROM  " . $prefix . "_poll_data WHERE `pollID`='$pollID' AND  `optionText`<>''");
	list($sumipoll) = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	
	$result  = $db->sql_query("
	SELECT `pollID`, `optionText`,`optionCount`,`voteID`
	FROM  " . $prefix . "_poll_data WHERE `pollID`='$pollID' AND  `optionText`<>''
	");
		

		
		while ($row3= $db->sql_fetchrow($result)) {
		$optionText  = $row3['optionText'];
		$optionCount = $row3['optionCount'];
		if($optionCount==0){
		$percent = 0;
		}else{
		$percent = intval(round(($optionCount * 100) / $sumipoll));
		}

		$cookiepoll = explode("-",$_COOKIE[getenv("HTTP_HOST")."-poll".$row3['pollID'].""]."");
		
		$voteClass = (($_POST["voteID"] == $row3['pollID'] OR  $cookiepoll[1]== $row3['voteID']) ? "poll_yourvote" : "poll_bar");

		$showrez .= '<div class="poll_option" >&nbsp;' . $optionText . ' &nbsp;&nbsp;<small>&nbsp;' . $percent . '%&nbsp; - ' . $optionCount  . ''._VOTES.'</small><br>';
		$showrez .= '<div class="' . $voteClass . '" style="width:' . $percent . '%;"></div><br>
        </div>';
	
		}
	$showrez .= "<p><center><img src='images/icon/chart_bar.png'>&nbsp;<b>" . _VOTE_COUNT . ": $sumipoll </b></center></p>";
	$showrez .= "<p><center><a href='modules.php?name=Surveys&op=results&pollID=$pollID'><img src='images/icon/comment_add.png'>&nbsp;<b>" . _COMMENTS . "</b></a></center></p>";
	
	if ($db->sql_numrows($result)>0) {
		return $showrez;
	}else {
		return _SURVEY_NOSURVEYFULL;
	}
	$db->sql_freeresult($result);

}

?>