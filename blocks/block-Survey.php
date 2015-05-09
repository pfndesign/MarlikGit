<?php

/**
*
* @package Survey Block 												
* @version $Id:  11:02 AM 5/23/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
*
*/

if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $prefix, $multilingual, $currentlang, $db, $boxTitle, $pollcomm, $user, $cookie, $userinfo;


$pollarray = array();


if ($multilingual == 1) {
	$querylang = "AND `planguage`='$currentlang'";
} else {
	$querylang = "";
}

	$result = $db->sql_query("SELECT  *  FROM " . $prefix . "_poll_desc WHERE $querylang AND `artid`= '".intval($_GET['sid'])."'  AND active = '1'
	ORDER BY `artid` ASC,pollID DESC  LIMIT 1");
	list($pollID,$pollTitle,$voters) = $db->sql_fetchrow($result);
	if (empty($pollID)) {
	$result = $db->sql_query("SELECT pollID,pollTitle,voters FROM  " . $prefix . "_poll_desc WHERE $querylang AND `artid`= '0' 
	ORDER BY pollID DESC LIMIT 1");
	list($pollID,$pollTitle,$voters) = $db->sql_fetchrow($result);
	if (empty($pollID)) {
		$content .=_NO_SURVEY_HAS_BEEN_SET;
	}
	}
$db->sql_freeresult($result);

$q=$db->sql_query("select * from ".$prefix."_poll_data where pollID='$pollID'");

if($db->sql_numrows($q) === 0)
$content = "" . _SURVEY_NOSURVEYFULL . "";


//$pollArray = array();

$url = "modules.php?name=Surveys&amp;op=results&amp;pollID=".$pollID."";
$content .= "<div style='text-align:right;direction:rtl;'>
<form action=\"modules.php?name=Surveys\" method=\"post\">\n";
$content .= "<input type=\"hidden\" name=\"pollID\" value=\"".$pollID."\">\n";
$content .= "<input type=\"hidden\" name=\"forwarder\" value=\"".$url."\">\n";

$boxTitle = _SURVEY;
$content .= "<strong>$pollTitle</strong><br><br>\n";

while($arr=$db->sql_fetchrow($q))
{
	if (!empty($arr['optionText'])) {
		$content .= "<input type=\"radio\" name=\"voteID\" value=\"".$arr['voteID']."\">".$arr['optionText']."<br>\n";
	}
}
$db->sql_freeresult($q);

$content .= "<br><center><input type=\"submit\" value=\""._VOTE."\"><br>";
if (is_user($user)) {
	cookiedecode($user);
	getusrinfo($user);
}

if (!isset($mode) OR empty($mode)) {
	if(isset($userinfo['umode'])) {
		$mode = $userinfo['umode'];
	} else {
		$mode = "thread";
	}
}
if (!isset($order) OR empty($order)) {
	if(isset($userinfo['uorder'])) {
		$order = $userinfo['uorder'];
	} else {
		$order = 0;
	}
}
if (!isset($thold) OR empty($thold)) {
	if(isset($userinfo['thold'])) {
		$thold = $userinfo['thold'];
	} else {
		$thold = 0;
	}
}
$r_options = "";
$r_options .= "&amp;mode=".$mode;
$r_options .= "&amp;order=".$order;
$r_options .= "&amp;thold=".$thold;
$content .= "<br><span class=\"content\"><a href=\"modules.php?name=Surveys&amp;op=results&amp;pollID=".$pollID.$r_options."\"><strong>"._RESULTS."</strong></a><br><a href=\"modules.php?name=Surveys\"><strong>"._POLLS."</strong></a><br>";


$sum = $db->sql_query("Select pollID,SUM(optionCount) From ".$prefix."_poll_data WHERE pollID='$pollID'  GROUP BY pollID");

while($arr2=$db->sql_fetchrow($sum))
{
	if (!empty($arr2['SUM(optionCount)'])) {
	$content .= "<br>"._VOTES." <strong>".$arr2['SUM(optionCount)']."</strong>\n\n";
	}
}
$db->sql_freeresult($sum);

$content .= "</center></form></div>\n\n";

?>