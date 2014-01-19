<?php

/**
*
* @package IP Tracking SYSTEM														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $						
* @version  http://www.ierealtor.com - phpnuke id: scottr $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
*
*/


define("IPT_DIR","admin/modules/tracking/");
define("IPT_PATH","".ADMIN_OP."tracking");
require_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."tracking/config.php");

global $db,$prefix,$trackip,$pagetitle,$admin,$ipmax,$user,$cookie,$offset_hours,$ipdel, $numip, $ipaddr, $hostnm, $exclude_me;

//--  Status of Tracking system ------------

	

/* Get the Browser data */

if ((preg_match("/Nav/", $_SERVER["HTTP_USER_AGENT"])) || (preg_match("/Gold/", $_SERVER["HTTP_USER_AGENT"])) || (preg_match("/X11/", $_SERVER["HTTP_USER_AGENT"])) || (preg_match("/Mozilla/", $_SERVER["HTTP_USER_AGENT"])) || (preg_match("/Netscape/", $_SERVER["HTTP_USER_AGENT"])) AND (!preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) AND (!preg_match("/Konqueror/", $_SERVER["HTTP_USER_AGENT"])) AND (!preg_match("/Yahoo/", $_SERVER["HTTP_USER_AGENT"])) AND (!preg_match("/Firefox/", $_SERVER["HTTP_USER_AGENT"]))) $browser = "Chrome";
elseif(preg_match("/Firefox/", $_SERVER["HTTP_USER_AGENT"])) $browser = "FireFox";
elseif(preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) $browser = "MSIE";
elseif(preg_match("/Lynx/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Lynx";
elseif(preg_match("/Opera/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Opera";
elseif(preg_match("/WebTV/", $_SERVER["HTTP_USER_AGENT"])) $browser = "WebTV";
elseif(preg_match("/Chrome/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Chrome";
elseif(preg_match("/Konqueror/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Konqueror";
elseif(is_crawlers()) $browser = "Bot";
else $browser = "Other";

/* Get the Operating System data */

if(preg_match("/Win/", $_SERVER["HTTP_USER_AGENT"])) $os = "Windows";
elseif((preg_match("/Mac/", $_SERVER["HTTP_USER_AGENT"])) || (preg_match("/PPC/", $_SERVER["HTTP_USER_AGENT"]))) $os = "Mac";
elseif(preg_match("/Linux/", $_SERVER["HTTP_USER_AGENT"])) $os = "Linux";
elseif(preg_match("/FreeBSD/", $_SERVER["HTTP_USER_AGENT"])) $os = "FreeBSD";
elseif(preg_match("/SunOS/", $_SERVER["HTTP_USER_AGENT"])) $os = "SunOS";
elseif(preg_match("/IRIX/", $_SERVER["HTTP_USER_AGENT"])) $os = "IRIX";
elseif(preg_match("/BeOS/", $_SERVER["HTTP_USER_AGENT"])) $os = "BeOS";
elseif(preg_match("/AIX/", $_SERVER["HTTP_USER_AGENT"])) $os = "AIX";
else $os = "Other";

if(is_crawlers()){
if(preg_match("/Google/", $_SERVER['HTTP_USER_AGENT']) > 0) $se = "google";
elseif((preg_match("/Bing/", $_SERVER['HTTP_USER_AGENT']))  || (preg_match("/msnbot/", $_SERVER['HTTP_USER_AGENT']))) $se = "bing";
elseif((preg_match("/Yahoo/", $_SERVER['HTTP_USER_AGENT']))) $se = "yahoo";
else $se = "other";
}


/////////SAVE TODAY AND YESTERDAY COUNTS IN A SEPRATED TABLE-------
$CurrentIP = $_SERVER["REMOTE_ADDR"] ;
$today = date("Y-m-d");
$result = $db->sql_query("SELECT `var`,`count` FROM ".$prefix."_counter  WHERE `type`='total_today' ");
list($total_dtodayvisits,$total_ctodayvisits)= $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if ($total_dtodayvisits == $today) {
$result = $db->sql_query("UPDATE ".$prefix."_counter SET `count`= '".($total_ctodayvisits+1)."'  WHERE type='total_today'");
$db->sql_freeresult($result);
}else {
$result = $db->sql_query("UPDATE ".$prefix."_counter SET `var`='$total_dtodayvisits',count='$total_ctodayvisits' WHERE `type`='total_yesterday'");
$db->sql_freeresult($result);
$result = $db->sql_query("UPDATE ".$prefix."_counter SET `var`='$today',`count`='1'  WHERE `type`='total_today'");
$db->sql_freeresult($result);
}



// lets see if we have iptracking database to check current exsisiting ips ---
 if ($trackip == 1) {
$result = $db->sql_query("SELECT COUNT(*) FROM ".$prefix."_iptracking  WHERE ip_address='$CurrentIP' LIMIT 1");
list($UniqueIP) = $db->sql_fetchrow($result);
 $db->sql_freeresult($result);
 $pagevisits = (empty($UniqueIP)) ? "OR (type='total' AND var='visits')" : "";
 }
 


/* Save on the databases the obtained values */
$result = $db->sql_query("UPDATE ".$prefix."_counter SET count=count+1 WHERE (type='total' AND var='pageviews') $pagevisits
OR (var='$browser' AND type='browser') OR (var='$os' AND type='os') OR (var='$se' AND type='se')");
$db->sql_freeresult($result);


	# capture User, Timestamp, IP Address, Resolved IP Address, Web Page
	$dt = date("Y-m-d H:i:s", time() + ($offset_hours * 60 * 60)) ;
	$ipaddr = $_SERVER["REMOTE_ADDR"] ;
	$hostnm = $_SERVER["HTTP_HOST"] ;
	
	/*
	if(is_user($user)) {
		cookiedecode($user);
		$username=$cookie[1];
	}
	if(is_admin($admin)) {
		if(!is_array($admin)) {
			$admin = base64_decode($admin);
			$admin = explode(":", $admin);
			$username = $admin[0];
		} else {
			$username = $admin[0];
		}
	}

	$exclude_me=false;
	array_walk($exclude_ips, 'exclude_ip');
	if(!$exclude_me) array_walk($exclude_hosts, 'exclude_host');
	if (!$exclude_me) {
		# concatenate SCRIPT_NAME and QUERY_STRING since REQUEST_URI not used in Windows hosted sites.
		# $pg = getenv(REQUEST_URI);
		# $pg = getenv(SCRIPT_NAME);
		$pg = $_SERVER["SCRIPT_NAME"];
		# if ((getenv(QUERY_STRING)) != "") { $pg = $pg . "?" . getenv(QUERY_STRING) ; }
		if (($_SERVER["QUERY_STRING"]) != "") { $pg = $pg . "?" . $_SERVER["QUERY_STRING"] ; }
*/

//---FIND OUT REFERERS --------------
    if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    $referer = check_html($referer, "nohtml");
	if (stristr("nuke_", $referer) && stristr("into", $referer) && stristr("from", $referer)) {
	$referer = ""; 
	}
    }
    
    if (!empty($referer) && !stripos_clone($referer, "unknown") && !stripos_clone($referer, "bookmark") && !stripos_clone($referer, $_SERVER['HTTP_HOST'])) {
    $referer = sql_quote($referer);
    }else {
    $referer ="";
    }
    
    if ($trackip == 1) {
    
		if(empty($username)){
			# let the database insert a null into the username column
			$db->sql_query("insert into ".$prefix."_iptracking 
			(date_time, ip_address, hostname,referer, page , page_title) 
			values ('".sql_quote($dt)."', '".sql_quote($ipaddr)."', '".sql_quote($hostnm)."','$referer', '".sql_quote($pg)."', '".sql_quote($pagetitle)."')");
		} else {
			sql_query("insert into ".$prefix."_iptracking (username, date_time, ip_address, hostname,referer, page, page_title) 
			values ('".sql_quote($username)."', '".sql_quote($dt)."', '".sql_quote($ipaddr)."','".sql_quote($hostnm)."','$referer','".sql_quote($pg)."','".sql_quote($pagetitle)."')", $dbi);
		}
		# Delete from the iptracking table based on parameters set in tracking/config.php
		if ($ipmax > 0 and $ipdel > 0 and $ipmax >= $ipdel) {
			# replaced for speed v3.1.2
			#$tresult = sql_query("select * from ".$prefix."_iptracking", $dbi);
			#$numrows = sql_num_rows($tresult, $dbi);
			$tresult = sql_query("select count(*) from ".$prefix."_iptracking", $dbi);
			list($numrows) = sql_fetch_row($tresult, $dbi);
			if($numrows>=$ipmax) {
				# 'delete ... limit' not ready until mysql 4.0
				# sql_query("delete from ".$prefix."_iptracking order by date_time limit ".$ipdel, $dbi);
				$tresult = sql_query("select date_time from ".$prefix."_iptracking order by date_time limit " .$ipdel.",1", $dbi);
				list($date_time) = sql_fetch_row($tresult, $dbi);
				sql_query("delete from ".$prefix."_iptracking where date_time <= '".sql_quote($date_time)."'", $dbi);
			}   
		}   
	}
	
function exclude_ip($item) {
# this function checks if the ip address is in the list of ip addresses in the $exclude_ips array
# if it is, set global variable $exclude=true
# wildcard chars are allowed
	global $ipaddr, $exclude_me;
	if(preg_match("/$item/", $ipaddr)) $exclude_me=true;
}

function exclude_host($item) {
# this function checks if the hostname is in the list of hostnames in the $exclude_hosts array
# if it is, set global variable $exclude=true
# wildcard chars are allowed
	global $hostnm, $exclude_me;
	if(preg_match("/$item/", $hostnm)) $exclude_me=true;
}
?>