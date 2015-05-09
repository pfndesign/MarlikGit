<?php
/**
*
* @package Tigris 1.1.4														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $						
* @version  http://www.ierealtor.com - phpnuke id: scottr $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alikes
*
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
global $currentlang,$prefix;
define("IPT_DIR","admin/modules/tracking/");
define("IPT_PATH","".ADMIN_OP."tracking");
define("TRACKING_TABLE","".$prefix."_iptracking");
$numip = 100;
$show_hits = 0;
$offset_hours = 1;
$gridcolor = "#ff0000";
require_once(IPT_DIR."language/lang-$currentlang.php");
$pagetitle = "- "._IPTRACKING."";
$date = zonedate('Y-m-d H:i:s',+3.5,false,mktime(18,46,0,9,7,1986));
$shmasidate = hejridate($date,4,7,5);
function IPTrack() {
	global $prefix, $db, $now, $numip, $pagenum, $show_hits, $Version_Num, $showmodule;
	if (defined("USV_VERSION")) {
		include ("header.php");
		GraphicAdmin();
		title("$sitename "._IPTRACKING."");
		OpenTable();
		if (isset($_POST['banthisip'])) {
			global $ip1, $ip2, $ip3, $ip4, $reason;
			save_banned($ip1, $ip2, $ip3, $ip4, $reason);
		}
		if (isset($_POST['suspendthisuser'])) {
			global $username,$suspendreason;
			save_suspended($username,$suspendreason);
		}
		showIPStats();
		echo "<br><br>";
		CloseTable();
		if($show_hits==1) {
			$filter="where username is not null";
		} elseif($show_hits==2) {
			$filter="where username is null";
		} else {
			$filter="where 1=1";
		}
		if (preg_match("/All.*Modules/", $showmodule) || !$showmodule ) {
			$modfilter="";
		} else {
			$modfilter=" and page like '%name=$showmodule%'";
		}
		$res = $db->sql_query("select username, ip_address, hostname, max(date_time), count(*) "
				."from ".TRACKING_TABLE." $filter $modfilter group by 1,2,3");
		$numips = $db->sql_numrows($res);
		$res = $db->sql_query("select * from ".TRACKING_TABLE." where 1=1 $modfilter");
		$numhits = $db->sql_numrows($res);
		$numpages = ceil($numips / $numip);
		if ($numpages > 1) {
			echo "<br>";
			OpenTable();
			echo "<center>";
			echo "$numips "._IPADDRESSES." ($numhits "._HITS.", $numpages "._PAGES.", $numip "._PERPAGE.")<br>" ;
			# START Left Arrow
						if ($pagenum > 1) {
				$prevpage = $pagenum - 1 ;
				if(file_exists("images/download/left.gif")) {
					$leftarrow = "images/download/left.gif" ;
					# 5.x
				} else {
					$leftarrow = "images/left.gif" ;
					# 6.x+
				}
				if (preg_match("/All.*Modules/", $showmodule) || !$showmodule ) {
					echo "<a href=\"".IPT_PATH."&amp;pagenum=$prevpage\">";
				} else {
					echo "<a href=\"".IPT_PATH."&amp;showmodule=$showmodule&amp;pagenum=$prevpage\">";
				}
				echo "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
			}
			# END Left Arrow
						# START Page Numbers
						echo "[ " ;
			for ($i=1; $i < $numpages+1; $i++) {
				if ($i == $pagenum) {
					echo "<span style='padding:3px;background:#FF81BA;color:#fff'>$i</span>";
				} else {
					if (preg_match("/All.*Modules/", $showmodule) || !$showmodule ) {
						echo "<a href=\"".IPT_PATH."&amp;pagenum=$i\">
					<span style='padding:5px;background:#ABB2D1;color:#000'>$i</span></a>";
					} else {
						echo "<a href=\"".IPT_PATH."&amp;showmodule=$showmodule&amp;pagenum=$i\">
					<span style='padding:3px;background:#FF81BA;color:#fff'>$i</span></a>";
					}
				}
				if ($i < $numpages) {
					echo " | ";
				} else {
					echo " ]";
				}
			}
			# END Page Numbers
						# START Right Arrow
						if ($pagenum < $numpages) {
				$nextpage = $pagenum + 1 ;
				if(file_exists("images/download/right.gif")) {
					$rightarrow = "images/download/right.gif" ;
					# 5.x
				} else {
					$rightarrow = "images/right.gif" ;
					# 6.x+
				}
				if (preg_match("/All.*Modules/", $showmodule) || !$showmodule ) {
					echo "<a href=\"".IPT_PATH."&amp;pagenum=$nextpage\">";
				} else {
					echo "<a href=\"".IPT_PATH."&amp;showmodule=$showmodule&amp;pagenum=$nextpage\">";
				}
				echo "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
			}
			# END Right Arrow
						echo "</center>";
			CloseTable();
		}
	} else {
		die("This Plugin works only for Nukelearn CMS");
	}
	include ("footer.php");
}
function showIPStats() {
	if (defined("USV_VERSION")) {
		global $admin,$prefix,$db, $ThemeSel;
		global $trackip, $numip, $pagenum, $hide_ipseg, $hide_host,$ipmaskchar, $user, $orderby, $orderdir;
		global $show_hits,$Version_Num, $gridcolor, $updown_arrows, $showmodule;
		/*
		$l_size = getimagesize("themes/$ThemeSel/images/leftbar.gif");
		$m_size = getimagesize("themes/$ThemeSel/images/mainbar.gif");
		$r_size = getimagesize("themes/$ThemeSel/images/rightbar.gif");
		*/
		if ($numip == "") {
			$numip = 100 ;
		}
		# Default 100 per page
				if ($pagenum == "") {
			$pagenum = 1 ;
		}
		
		if ($trackip == 1) {
			$status = "<a href='".ADMIN_OP."tracking&op=trigger_status&status=0' style='color:red;font-weight:bold;'>"._DEACTIVATE."</a>";
			$actip = "<a href='".ADMIN_OP."tracking&op=trigger_status&status=0'>
							 <img src='images/Guardian/active.png' title='"._ACTIVATED."'></a>";
		} else {
			$status = "<a href='".ADMIN_OP."tracking&op=trigger_status&status=1' style='color:green;font-weight:bold;'>"._ACTIVATE."</a>";
			$actip = "<a href='".ADMIN_OP."tracking&op=trigger_status&status=1'>
					<img src='images/Guardian/inactive.png' title='"._NOTACTIVATED."'></a>";
		}
		
		echo "<center><h3>$actip&nbsp;"._IPTRACKINGINFO." [ $status ]</h3></center><br>";
		echo _ADMIN_TRACKING_VIEWIPS;
		# START Modules
				$content = "<center>";
		$content .= "<table cellspacing=\"10\" ><tr><td><form action=\"index.php\" method=\"get\">";
		$content .= "<select name=\"module\" onChange=\"top.location.href=this.options[this.selectedIndex].value\">";
		$handle=opendir('modules');
		while ($file = readdir($handle)) {
			if ( (!preg_match("/^[.]/",$file)) && !preg_match("/html$/", $file) ) {
				$moduleslist .= "$file ";
			}
		}
		closedir($handle);
		$moduleslist .= "&nbsp;All&nbsp;Modules";
		$moduleslist = explode(" ", $moduleslist);
		sort($moduleslist);
		for ($i=0; $i < sizeof($moduleslist); $i++) {
			if($moduleslist[$i]!="") {
				$content .= "<option value=\"".IPT_PATH."&amp;showmodule=$moduleslist[$i]\" ";
				if($showmodule==$moduleslist[$i]) $content .= " selected";
				$content .= ">".$moduleslist[$i]."</option>\n";
			}
		}
		$content .= "</select></td>";
		$content .= "</tr></table></form></center>";
		echo $content;
		# END Modules
				echo "<table align=\"center\"  class=\"widefat comments fixed\"><thead><tr>";
		# Online?
				echo "<th scope='col'>"._ONLINE."?</th>";
		# End Online?
				#START allow sorting by any column
				if ($updown_arrows) {
			$asc="<img src=\"images/up.gif\" border=\"0\">";
			$desc="<img src=\"images/down.gif\" border=\"0\">";
			$sep="";
		} else {
			$asc="<img src='images/up.gif' title='"._ASC."'>";
			$desc="<img src='images/down.gif' title='"._DESC."'>";
			$sep="/";
		}
		echo "<th scope='col'>"._USER;
		echo " <a href=\"".IPT_PATH."&amp;orderby=1&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;orderby=1&amp;orderdir=desc\">$desc</a></th>";
		echo "<th scope='col'>"._IPADDRESS;
		echo " <a href=\"".IPT_PATH."&amp;orderby=2&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;orderby=2&amp;orderdir=desc\">$desc</a></th>";
		echo "<th scope='col'>"._HOSTNAME;
		echo " <a href=\"".IPT_PATH."&amp;orderby=3&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;orderby=3&amp;orderdir=desc\">$desc</a></tg>";
		echo "<th scope='col'>"._LASTVIEWED;
		echo " <a href=\"".IPT_PATH."&amp;orderby=4&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;orderby=4&amp;orderdir=desc\">$desc</a></th>";
		echo "<th scope='col'>"._HITS;
		echo " <a href=\"".IPT_PATH."&amp;orderby=5&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;orderby=5&amp;orderdir=desc\">$desc</a></th>";
		echo "<th scope='col'>"._OPTIONS."</th></tr></thead>";
		# default values if none set
				if(!$orderby) $orderby="4";
		if(!$orderdir) $orderdir="desc";
		#END allow sorting by any column
				$offset = ($pagenum-1) * $numip ;
		if($show_hits==1) {
			$filter="where username is not null";
		} elseif($show_hits==2) {
			$filter="where username is null";
		} else {
			$filter="where 1=1";
		}
		if (preg_match("/All.*Modules/", $showmodule) || !$showmodule ) {
			$modfilter="";
		} else {
			$modfilter=" and page like '%name=$showmodule%'";
		}
		# if multiple Users share same IP Address, then you'll see multiple identical IP Addresses when not displaying User, that's ok .
				#
				# now that we can select a module, the number of hits will represent hits to the selected module
				# even though drilling down to display the page views will show all the hits by that IP Address.
				$result = $db->sql_query("select distinct username, ip_address, hostname, max(date_time), count(*), min(ipid) from ".TRACKING_TABLE." "
				."$filter $modfilter group by 1,2,3 order by $orderby $orderdir limit $offset, $numip");
		while (list($username,$ipaddr,$hostnm,$lastview,$hits,$ipid) = $db->sql_fetchrow($result)) {
			echo "<tr>";
			//--- Online CHECKER --------------------
			//--- Note: admins won't appear Online since they are not entered in the nuke_session table.
			list($session_user_id) = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$prefix."_users WHERE username='$username'"));
			$OnloneChecker =
						$db->sql_numrows(
						$db->sql_query(
						"SELECT * FROM ". $prefix ."_session WHERE session_time  > '".( time() - (2 * 60) )."'  AND  session_user_id = '$session_user_id' "));
			if (empty($OnloneChecker)) {
				echo "<td><img src='images/inactive.gif' title='"._INACTIVE."'></td>";
			} else {
				echo "<td align=\"center\"><img src='images/active.gif' title='"._ACTIVE."'></td>";
			}
			$db->sql_freeresult($OnloneChecker);
			# END Online?
						//---Check If is IP is banned OR NOT - - - -- - -
			list($thisip_id) = $db->sql_fetchrow($db->sql_query("SELECT id from ".$prefix."_banned_ip where ip_address='$ipaddr' "));
			if (empty($thisip_id)) {
				$BanIpLink = "<a href='".ADMIN_OP."ban_this_ip&my_ip=$ipaddr' class='colorbox'><img src='images/icon/stop.png' title='"._IPBan."'></a>";
			} else {
				$BanIpLink = "<a href='".ADMIN_OP."ipban_delete&id=$thisip_id' class='colorbox'><img src='images/check.png' title='"._UNBAN." "._IPBANNED." '></a>";
			}
			//-----------------
			//---CHECK IF AN USERNAME IS LOCKED OR NOT
			$numSUSPEND = $db->sql_numrows($db->sql_query("SELECT username FROM ".$prefix."_users WHERE username='$username'
	 AND user_level='0' AND user_active='0'"));
			if (!empty($username)) {
				if (empty($numSUSPEND)) {
					$SuspendLink = "<a href='".ADMIN_OP."suspend_this_user&username=$username' class='colorbox'>
				<img src='images/icon/lock_go.png' title='"._NOTIFYSUBMISSIONY."'></a>";
				} else {
					$SuspendLink = "<a href='".ADMIN_OP."unsuspend_user&username=$username' class='colorbox'>
				<img src='images/icon/lock_delete.png' title='"._UNBAN."  "._USER."'></a>";
				}
			}
			//-----------------
			if($username != "") {
			echo "<td><a href=\"modules.php?name=Your_Account&op=userinfo&username=$username\">$username</a></td>";
			} else {
				echo "<td> </td>";
			}
			echo "<td><a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid\"><span style='font-size:15px;color:#FF81BA'>$ipaddr</span></a></td>";
			if(!$hide_host) echo "<td>$hostnm</td>";
			echo "<td>".hejridate($lastview,4,7,5)."</td><td align=\"center\">$hits</td>
			<td>$BanIpLink&nbsp;&nbsp;&nbsp;&nbsp;$SuspendLink&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='".ADMIN_OP."tracking&op=moreinfo&my_ip=$ipaddr' class='colorbox'><img src='images/icon/information.png' id='moreinfo' title='"._DESCRIPTION."' ></a></td>
			</tr>
			";
		}
		$db->sql_freeresult($result);
		echo "</table>";
	} else {
		die("Only works with Nukelearn CMS");
	}
}
function PagesViewed() {
	global $hlpfile,$nowyear,$nowmonth,$nowdate,$nowhour, $sitename, $startdate, $db, $prefix, $now, $ipid, $numip, $pagenum, $Version_Num;
	include ("header.php");
	GraphicAdmin();
	title("$sitename "._IPTRACKING."");
	OpenTable();

	$result = $db->sql_query("select ip_address from ".TRACKING_TABLE." where ipid='$ipid'");
	list($ip_address) = $db->sql_fetchrow($result);
	echo "<br><h3><a href='".ADMIN_OP."tracking'>"._ACTIVITY_LIST."<span style='color:#FF81BA'>$ip_address</span></a>   <a class='button' href='".IPT_PATH."&op=delete_history&ipaddr=$ip_address'>"._ADMIN_TRACKING_DELETEALLUSERINFO." </a> </h3><br>";
	showPageStats();
	echo "<br><br><center>"._GOBACK."</center><br><br>";
	CloseTable();
	$res = $db->sql_query("select * from ".TRACKING_TABLE." where ip_address='$ip_address'");
	$numurls = $db->sql_numrows($res);
	$numpages = ceil($numurls / $numip);
	if ($numpages > 1) {
		echo "<br>";
		OpenTable();
		echo "<center>";
		echo "$numurls "._URLS." ($numpages "._PAGES.", $numip "._PERPAGE.")<br>" ;
		# START Left Arrow
				if ($pagenum > 1) {
			$prevpage = $pagenum - 1 ;
			if(file_exists("images/download/left.gif")) {
				$leftarrow = "images/download/left.gif" ;
				# 5.x
			} else {
				$leftarrow = "images/left.gif" ;
				# 6.x+
			}
			echo "<a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;pagenum=$prevpage\">";
			echo "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
		}
		# END Left Arrow
				# START Page Numbers
				echo "[ " ;
		for ($i=1; $i < $numpages+1; $i++) {
			if ($i == $pagenum) {
				echo "<span style='padding:5px;background:#FF81BA;color:#fff'>$i</span>";
			} else {
				echo "<a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;pagenum=$i\">
				<span style='padding:5px;background:#FF81BA;color:#fff'>$i</span></a>";
			}
			if ($i < $numpages) {
				echo " | ";
			} else {
				echo " ]";
			}
		}
		# END Page Numbers
				# START Right Arrow
				if ($pagenum < $numpages) {
			$nextpage = $pagenum + 1 ;
			if(file_exists("images/download/right.gif")) {
				$rightarrow = "images/download/right.gif" ;
				# 5.x
			} else {
				$rightarrow = "images/right.gif" ;
				# 6.x+
			}
			echo "<a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;pagenum=$nextpage\">";
			echo "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
		}
		# END Right Arrow
				echo "</center>";
		CloseTable();
	}
	include ("footer.php");
}
function showPageStats() {
	global $admin,$prefix,$bgcolor1,$bgcolor2,$db, $ThemeSel;
	global $numip, $pagenum, $ipid, $hide_host,$user, $orderby, $orderdir, $gridcolor, $updown_arrows;
	/* $l_size = getimagesize("themes/$ThemeSel/images/leftbar.gif");
	$m_size = getimagesize("themes/$ThemeSel/images/mainbar.gif");
	$r_size = getimagesize("themes/$ThemeSel/images/rightbar.gif");
	*/
	if ($numip == "") {
		$numip = 100 ;
	}
	# Default 100 per page
		if ($pagenum == "") {
		$pagenum = 1 ;
	}
	$offset = ($pagenum-1) * $numip ;
	$result = $db->sql_query("select ip_address from ".TRACKING_TABLE." where ipid='$ipid'");
	list($ip_address) = $db->sql_fetchrow($result);
	# default values if none set
		if(!$orderby) $orderby="2";
	if(!$orderdir) $orderdir="desc";
	$result = $db->sql_query("select page,page_title,date_time from ".TRACKING_TABLE." "
		."where ip_address = '$ip_address' "
		."order by $orderby $orderdir limit $offset, $numip ");
	echo "<center><b>"._PAGEVIEWINFO."<br>";
	# Admin always see info
		#if(is_admin($admin)) {
		echo "$ip_address";
		#if (is_admin($admin) or !$hide_host) echo " - " . gethostbyaddr($ip_address);
		if(!$hide_host) echo " - " . gethostbyaddr($ip_address);
		echo "</center></b><br>";
		echo "<table class=\"widefat comments fixed\"><thead><tr>";
		#START allow sorting by any column
			if ($updown_arrows) {
			$asc="<img src=\"images/up.gif\">";
			$desc="<img src=\"images/down.gif\">";
			$sep="";
		} else {
			$asc="<img src=\"images/up.gif\">";
			$desc="<img src=\"images/down.gif\">";
			$sep="/";
		}
		echo "<th scope='col'>"._PAGEVIEWED;
		echo " <a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;orderby=1&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;orderby=1&amp;orderdir=desc\">$desc</a></th>";
		echo "<th scope='col'>"._HITDATE;
		echo " <a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;orderby=2&amp;orderdir=asc\">$asc</a>$sep";
		echo  "<a href=\"".IPT_PATH."&amp;op=PagesViewed&amp;ipid=$ipid&amp;orderby=2&amp;orderdir=desc\">$desc</a></th></tr></thead>";
		#END allow sorting by any column
			while (list($page,$page_title,$date_time) = $db->sql_fetchrow($result)) {
			$date_time = hejridate($date,4,7,5);
			echo "<tr><td><a href=\"$page\">$page_title<br>$page</a></td><td>$date_time</td></tr>";
		}
		$db->sql_freeresult($result);
		echo "</table>";
	}
function mask_ip($ipaddr) {
		# IP Address Masking
			global $hide_ipseg, $ipmaskchar;
		if(in_array(TRUE, $hide_ipseg)) {
			$ipseg = explode(".", $ipaddr);
			for ($lcv=1; $lcv<=count($ipseg); $lcv++) {
				$seg=$lcv-1;
				# str_replace() didn't like $ipseg[$lcv-1] so had to make $seg
			if($hide_ipseg[$lcv]) $ipseg[$seg] = str_replace("[0-9]", "$ipmaskchar", "$ipseg[$seg]");
		}
		$ipaddr = implode(".",$ipseg);
	}
	return $ipaddr;
}
function delete_history($ipaddr){
	global $db; 
	$ipaddr = sql_quote($ipaddr);
	if (!empty($ipaddr)) {
		$db->sql_query("DELETE FROM ".TRACKING_TABLE." WHERE ip_address='$ipaddr'");
		header("Location: ".ADMIN_OP."tracking");
	}else {
		show_error("NO IP ADDRESS DEFINED TO BE REMOVED");
	}
}
//--suspend this USERNAME ---------------
function suspend_this_user($username) {
	global $db, $admin_file;
	$username = sql_quote($username);
	OpenTable();
	echo "<h3>معلق کردن کاربر <span  style='color:#E2007A;
				direction:ltr;
				' > $username </span> </h3>";
	echo "<form action='".ADMIN_OP."tracking' method='post'><center>";
	echo "<br><br><b>"._REASON."</b><br>
	<input type='text' name='suspendreason' size='50' maxlength='255'><br><br>
	<input type='hidden' name='username' value='$username'>
	<input type='hidden' name='op' value='IPTrack'>
	<input type='submit' name='suspendthisuser' value='"._SUSPEND_USER."'>
	<br><br></center>";
	echo "</form>";
	CloseTable();
}
function save_suspended($username,$suspendreason) {
	global $db,$prefix, $adminmail ,$sitename,$nukeurl, $admin_file;
	$username = sql_quote($username);
	if (empty($username) OR !$db->sql_numrows($db->sql_query("SELECT username FROM ".$prefix."_users WHERE username='$username'")) > 0){
		$output = ""._ADMIN_TRACKING_ERROR_USER_NOT_EXISTS."";
	}
	elseif ($db->sql_numrows($db->sql_query("SELECT username FROM ".$prefix."_users WHERE username='$username'
	 AND user_level='0' AND user_active='0'")) > 0){
	$output = ""._ADMIN_TRACKING_ERROR_USER_BANNED."";
	 }
	 else {
	 	$db->sql_query("UPDATE ".$prefix."_users SET user_level='0', user_active='0' WHERE username='$username'");
	 	$output = ""._ADMIN_TRACKING_BANNED_NOTIFIED."";
	 	if (function_exists("mail")) {
	 		list($email) = $db->sql_fetchrow($db->sql_query("SELECT user_email FROM ".$prefix."_users WHERE username='$username'"));
	 		$message = "<p align=\"center\">"._ADMIN_TRACKING_YOUAREBANNED."
	 		<br> "._USERNAME." : $username</p>";
	 		if (!empty($suspendreason)) {
	 			$suspendreason = stripslashes(sql_quote($suspendreason));
	 			$message .= "\r\n\r\n<p align=\"center\"> "._REASON." :\r\n$suspendreason:\r\n$nukeurl</p>";
	 		}
	 		$subject =  ""._ADMIN_TRACKING_SUSPENDED." - $sitename" ;
	 		$from  = "From: $adminmail\r\n";
	 		$from .= "Reply-To: $adminmail\r\n";
	 		$from .= "Return-Path: $adminmail\r\n";
	 		$message = FarsiMail($message);
	 		mail($email, $subject, $message, "From: \"$adminmail\" 
	 		<$adminmail>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nContent-transfer-encoding: 8bit");
	 	}
	 }
	 echo "<div id='info' class='notify' >$output</div>";
}
function unsuspend_user($username, $ok) {
	global $prefix, $db, $admin_file,$aid;
	if (is_superadmin($admin)) {
		$username = sql_quote($username);
		if (empty($ok)) {
			echo  "<center>"._ADMIN_TRACKING_UNBAN_Q."<br><br>
	<a href='".$admin_file.".php?op=unsuspend_user&username=".$username."&ok=1' class='button'>"._YES."</a>
	 | <a href='".$admin_file.".php?op=tracking' class='button'>"._NO."</a>";
		} elseif ($ok == 1) {
			$result = $db->sql_query("UPDATE ".$prefix."_users SET user_level='2', user_active='1' WHERE username='$username'");
			if (!$result) {
				show_error(_ERROR.mysql_error()."");
			}
			Header("Location: ".$admin_file.".php?op=tracking");
		}
	}else {
		show_error(HACKING_ATEMPT);
	}
}
//---IP BAN SYSTEM - --- -- - - --
function moreinfo($my_ip) {
	global $prefix, $db, $admin_file;
	$my_ip = sql_quote($my_ip);
	$output = "<h3>"._TRACKING." <span  style='color:#E2007A;
				direction:ltr;
				' > $my_ip </span> </h3>";
	$output .= "<div style='background:#EFEEE0'><h3>"._LATEST_VISITS."</h3> <br>";
	$input = "<div style='background:#F2E3CF'><h3>آخرین مسیرهای ورودی این آیپی</h3> <br>";
	$sql=$db->sql_query("SELECT referer,page,page_title FROM ".TRACKING_TABLE." WHERE ip_address='$my_ip' ORDER BY date_time LIMIT 0,15 ");
	while (list($referer,$page,$page_title)= $db->sql_fetchrow($sql)) {
	if (!empty($page)) {
	$output .= "<a href='$page'>$page_title</a><hr>";
	}
	if (!empty($referer)) {
	$input .= "<a href='$referer'>$referer</a><hr>";
	}
	}
	$output .= "</div>";
	$input  .= "</div>";
	OpenTable();
	echo $output;
	echo $input;
     include_once (IPT_DIR."get_by_ip.class.php");
        $ipdata=new get_by_ip($my_ip);
        echo '<pre>';
        echo $ipdata->host."<br>";
        echo $ipdata->netname."<br>";
        echo $ipdata->country."<br>";
        echo $ipdata->person."<br>";
        echo $ipdata->address."<br>";
        echo $ipdata->phone."<br>";
        echo $ipdata->email."<br>";
        echo '</pre>';
	CloseTable();
}
function ban_this_ip($my_ip) {
	global $prefix, $db, $admin_file;
	$my_ip = sql_quote($my_ip);
	OpenTable();
	echo "<h3>"._IPBANSYSTEM." <span  style='color:#E2007A;
				direction:ltr;
				' > $my_ip </span> </h3>";
	echo "<form action='".ADMIN_OP."tracking' method='post'><center>";
	if (!empty($my_ip)) {
		$ip = explode(".", $my_ip);
		echo "<div style='direction:ltr;
				'>
			<input type='text'  name='ip1' size='4' maxlength='3' value='$ip[0]'> .
			 <input type='text' name='ip2' size='4' maxlength='3' value='$ip[1]'> . 
			 <input type='text' name='ip3' size='4' maxlength='3' value='$ip[2]'> .
			 <input type='text' name='ip4' size='4' maxlength='3' value='$ip[3]'>
			 </div>";
	} else {
		echo "<div style='direction:ltr;
				'>
			<input type='text' name='ip1' size='4' maxlength='3'> .
			 <input type='text' name='ip2' size='4' maxlength='3'> . 
			 <input type='text' name='ip3' size='4' maxlength='3'> . 
			 <input type='text' name='ip4' size='4' maxlength='3'>
			 </div>";
	}
	echo "<br><br><b>"._REASON."</b><br>
	<input type='text' name='reason' size='50' maxlength='255'><br><br>
	<input type='hidden' name='op' value='IPTrack'>
	<input type='submit' name='banthisip' value='"._IPBan."'><br><br>"._BANCLASSC."</center>";
	echo "</form>";
	CloseTable();
	/*
	$numrows = $db->sql_numrows($db->sql_query("SELECT * from ".$prefix."_banned_ip"));
	if ($numrows != 0) {
	echo "<br>";
	OpenTable();
	echo "<center><font class=\"title\"><b>"._IPBANNED."</b></font><br><br></center>"
	."<table border=\"0\" align='center'>"
	."<tr><td  align='left'>&nbsp;<b><font class=\"content\">"._IPBANNED."</b>&nbsp;</td>"
	."<td  align='left'>&nbsp;<b><font class=\"content\">"._REASON."</b>&nbsp;</td>"
	."<td  align='center'><font class=\"content\">&nbsp;<b>"._BANDATE."</b>&nbsp;</td>"
	."<td  align='center'><font class=\"content\">&nbsp;<b>"._FUNCTIONS."</b>&nbsp;</td></tr>";
	$result = $db->sql_query("SELECT * from ".$prefix."_banned_ip ORDER by date DESC");
	while ($row = $db->sql_fetchrow($result)) {
	$row['reason'] = check_html($row['reason'], "nohtml");
	echo "<tr><td  align='left'>&nbsp;<font class=\"content\">".$row['ip_address']."</td>"
	."<td  align='center'><font class=\"content\">&nbsp;".$row['reason']."&nbsp;</td>"
	."<td  align='center' nowrap><font class=\"content\">&nbsp;".$row['date']."&nbsp;</td>"
	."<td  align='center'><font class=\"content\"><a href=\"".$admin_file.".php?op=ipban_delete&id=".intval($row['id'])."&ok=0\"><img src=\"images/unban.gif\" width=\"15\" height=\"15\" border=\"0\" alt=\""._UNBAN."\" title=\""._UNBAN."\"></a></td></tr>";
	}
	echo "</table>";
	CloseTable();
	}
	*/
}
function save_banned($ip1, $ip2, $ip3, $ip4, $reason) {
	global $prefix, $db;
	$my_ip = $_SERVER['REMOTE_ADDR'];
	if (substr($ip2, 0, 2) == 00) { $ip2 = str_replace("00", "", $ip2); }
	if (substr($ip3, 0, 2) == 00) { $ip3 = str_replace("00", "", $ip3); }
	if (substr($ip4, 0, 2) == 00) { $ip4 = str_replace("00", "", $ip4); }
	$ip = "$ip1.$ip2.$ip3.$ip4";
	if (empty($ip1) OR empty($ip2) OR empty($ip3) OR empty($ip4)) {
		$outputrez =  "<center><b>"._ERROR."</b> "._IPOUTRANGE."<br><br>"._IPENTERED." <b>".$ip."</b>";
	}
	elseif(!is_numeric($ip1) && !empty($ip1) OR !is_numeric($ip2) && !empty($ip2) OR !is_numeric($ip3) && !empty($ip3) OR !is_numeric($ip4) && !empty($ip4) && $ip4 != "*") {
		$outputrez = "<center><b>"._ERROR."</b> "._IPNUMERIC."<br><br>"._IPENTERED." <b>".$ip."</b>";
	}
	elseif ($ip1 > 255 OR $ip2 > 255 OR $ip3 > 255 OR $ip4 > 255 && $ip4 != "*") {
		$outputrez = "<center><b>"._ERROR."</b> "._IPOUTRANGE."<br><br>"._IPENTERED." <b>".$ip."</b>";
	}
	elseif (substr($ip1, 0, 1) == 0) {
		$outputrez = "<center><b>"._ERROR."</b> "._IPSTARTZERO."<br><br>"._IPENTERED." <b>".$ip."</b>";
	}
	elseif ($ip == "127.0.0.1") {
		$outputrez = "<center><b>"._ERROR."</b> "._IPLOCALHOST."<br><br>"._IPENTERED." <b>127.0.0.1</b>";
	}
	elseif ($ip == $my_ip) {
		$outputrez = "<center><b>"._ERROR."</b> "._IPYOURS."<br><br>"._IPENTERED." <b>".$ip."</b>";
	}
	elseif ($db->sql_numrows($db->sql_query("SELECT ip_address FROM ".$prefix."_banned_ip WHERE ip_address='$ip'")) > 0){
		$outputrez = "<center><b>"._ERROR."</b> "._THEIP." <b>".$ip."</b> "._ERROR_MYSQL." </b>";
	}
	else {
		$date = date("Y-m-d");
		$reason = addslashes(check_words(check_html($reason, "nohtml")));
		$db->sql_query("INSERT INTO ".$prefix."_banned_ip VALUES (NULL, '$ip', '$reason', '$date')");
		$outputrez = "<center><b>"._SUCCESS." </b>: "._THEIP." <b>".$ip."</b> "._HASBEENBANNED."</center>";
	}
	echo "<div id='info' class='notify' >$outputrez</div>";
}
function ipban_delete($id, $ok) {
	global $prefix, $db, $admin_file,$admin;
	if (is_superadmin($admin)) {
		//$id = intval(sql_quote($id));
		$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_banned_ip WHERE id='$id'"));
		if (empty($ok)) {
			echo  "<center>"._SURETOBANIP." <b>$row[ip_address]</b><br><br>
	<a href='".$admin_file.".php?op=ipban_delete&id=".$id."&ok=1' class='button'>"._YES."</a>
	 | <a href='".$admin_file.".php?op=tracking' class='button'>"._NO."</a>";
		} elseif ($ok == 1) {
			$result = $db->sql_query("DELETE FROM ".$prefix."_banned_ip WHERE id='$id' ");
			if (!$result) {
				show_error(" "._ERROR_MYSQL."<br>".mysql_error()."");
			}
			Header("Location: ".$admin_file.".php?op=tracking");
		}
	}else {
		show_error(HACKING_ATEMPT);
	}
}
//--------------------------------
//-- Turn off or On Tracking system ----------- ---
function trigger_status($status) {
	global $prefix,$db;
	$status = intval($status);
	switch ($status){
		case "0":
		$db -> sql_query("UPDATE ".$prefix."_config SET tracking = 0");
		header("Location: ".ADMIN_OP."tracking");
		break;
		
		case "1":
		$db -> sql_query("UPDATE ".$prefix."_config SET tracking = 1");
		header("Location: ".ADMIN_OP."tracking");
		break;
	}
}
switch($op) {
	default:
	case 'IPTrack':
		IPTrack();
		break;
	case "PagesViewed":
		PagesViewed();
		break;
	case "ban_this_ip":
		ban_this_ip($my_ip);
		break;
	case "suspend_this_user":
		suspend_this_user($username);
		break;
	case "save_banned":
		save_banned($ip1, $ip2, $ip3, $ip4, $reason);
		break;
	case "save_suspended":
		save_suspended($username,$suspendreason);
		break;
	case "ipban_delete":
		ipban_delete($id, $ok);
		break;
	case "unsuspend_user":
		unsuspend_user($username, $ok);
		break;
	case "trigger_status":
		trigger_status($status);
		break;
	case "delete_history":
		delete_history($ipaddr);
		break;
	case "moreinfo":
	moreinfo($my_ip);
	break;
}
?>