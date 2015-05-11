<?php
/**
*
* @package memberlist														
* @version $Id: 3:52 PM 7/18/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
*
* 
*/

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	header("Location: ../../../index.php");
	die ();
}
//_public_messages         <b>"._BROADCAST."</b><br><br>"._BROADCASTTEXT."<br><br>";
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
global $pagetitle,$db,$userinfo,$pagenum,$sitename;
$pagetitle = _MEMBERLIST;

addCSSToHead(INCLUDES_UCP."style/ucp.css");
include("header.php");
	


OpenTable();

echo "<h3>"._MEMBERLIST." $sitename</h3><br><center>
<table width='100%' align='center;'><tr>";
echo "<thead class='theadcp'>";
echo "<th width='48px;'>"._AVATAR."</th>";
echo "<th>"._USERNAME."</th>";
echo "<th>"._REGDATE."</th>";
echo "<th>"._GROUP."</th>";
echo "<th>"._POINTS."</th>";
echo "<th>"._LASTVISIT."</th>";
echo "<thead></tr>";


//NOW GET DATA FROM DB

$sql = "SELECT u.username,u.name AS rname,u.user_avatar,u.user_avatar_type,u.user_regdate,u.user_group_cp,u.points,u.user_lastvisit,g.name,g.color FROM ".__USER_TABLE." u LEFT JOIN ".__GROUP_TABLE." g ON 
u.user_group_cp = g.id WHERE u.user_active > 0 ";

$totalnum = $db->sql_numrows($db->sql_query($sql));
$ppage = 50;
$cpage = (empty($pagenum)) ? 1 : $pagenum;
$offset  = ($cpage * $ppage) - $ppage;

$sql .= " LIMIT $offset, $ppage";
$result = $db->sql_query($sql);
while ($row=$db->sql_fetchrow($result)) {
	if (empty($row['user_avatar'])) {
		if (file_exists("".INCLUDES_UCP."style/images/blank.gif")) {
			$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
		}
	}else {
		if ($row['user_avatar_type'] == "3") {
			if (file_exists("modules/Your_Account/images/".$row['user_avatar']."")) {
			$avatar_show = "modules/Your_Account/images/".$row['user_avatar']."";
			}else {
			$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
			}
		}else {
			$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
		}
	}
	$date_temp             = explode(" ",$row['user_regdate']);
	$date_temp[1]          = substr($date_temp[1], 0, 2);
	$date_temp[0]          = month_number($date_temp[0], 2);
	$owner['user_regdate'] = $date_temp[2] . "-" . $date_temp[0] . "-" . $date_temp[1];
	$regdateu              = hejridate($owner['user_regdate'], 1, 4);
	
		echo "<tr ".TableRow($cnt++,"tr_odd","tr_even")." style='text-align:center;vertical-align:center'>";
		echo "<td><img src='$avatar_show' style='border:2px solid white;width:48px;height:48px;'></td>";
		echo "<td><font color='$row[color]'><b>$row[username]</b></font><br>".langit($row[rname])."</td>";
		echo "<td>$regdateu</td>";
		echo "<td><font color='$row[color]'>".langit($row[name])."</font></td>";
		echo "<td><b>".number_format($row[points])."</b></td>";
		echo "<td>".(!empty($row['user_lastvisit']) ? hejridate(date("Y-m-d H:i:s",$row['user_lastvisit']), 4, 7) : "---")."</td></tr>";
	
} 

echo "</table>\n";
echo make_pagination(10,$totalnum,$ppage,$cpage,3,"modules.php?name=Your_Account&op=memberlist&pagenum",'');

CloseTable();
include("footer.php");

?>