<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2005 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
if ($row['radminsuper'] == 1) {

	function main_ban($ip=0) {
		global $prefix, $db, $bgcolor2, $admin_file;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._IPBANSYSTEM."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><b>"._BANNEWIP."</b><br><br>";
		echo "<form action='".$admin_file.".php' method='post'>";
		if ($ip != 0) {
			$ip = explode(".", $ip);
			echo "<div  style='direction:ltr'><input type='text' name='ip1' size='4' maxlength='3' value='$ip[0]'> . <input type='text' name='ip2' size='4' maxlength='3' value='$ip[1]'> . <input type='text' name='ip3' size='4' maxlength='3' value='$ip[2]'> . <input type='text' name='ip4' size='4' maxlength='3' value='$ip[3]'>";
		} else {
			echo "<input type='text' name='ip1' size='4' maxlength='3'> . <input type='text' name='ip2' size='4' maxlength='3'> . <input type='text' name='ip3' size='4' maxlength='3'> . <input type='text' name='ip4' size='4' maxlength='3'>";
		}
		echo "</div><br><br><b>"._REASON."</b><br><input type='text' name='reason' size='50' maxlength='255'><br><br><input type='hidden' name='op' value='save_banned'><input type='submit' value='"._BANTHIS."'><br><br><span style='direction:".langstyle('direction')."'>"._BANCLASSC."</span></center>";
		echo "</form>";
		CloseTable();
		$numrows = $db->sql_numrows($db->sql_query("SELECT * from ".$prefix."_banned_ip"));
		if ($numrows != 0) {
			echo "<br>";
			OpenTable();
			echo "<center><font class=\"title\"><b>"._IPBANNED."</b></font><br><br></center>"
			.'<table class="widefat comments fixed" style="width:80%;margin:0px auto;text-align:center;">'
			."<thead>
			<tr>
			<th  align='left'>&nbsp;<b><font class=\"content\">"._IPBANNED."</b>&nbsp;</th>"
			."<th  align='left'>&nbsp;<b><font class=\"content\">"._REASON."</b>&nbsp;</th>"
			."<th  align='center'><font class=\"content\">&nbsp;<b>"._BANDATE."</b>&nbsp;</th>"
			."<th  align='center'><font class=\"content\">&nbsp;<b>"._FUNCTIONS."</b>&nbsp;</th></tr>
			</thead>
			";
			$result = $db->sql_query("SELECT * from ".$prefix."_banned_ip ORDER by date DESC");
			while ($row = $db->sql_fetchrow($result)) {
				$row['reason'] = check_html($row['reason'], "nohtml");
				echo "<tr><td  align='left'>&nbsp;<font class=\"content\"><big><b>".$row['ip_address']."</b></big></td>"
				."<td  align='center'><font class=\"content\">&nbsp;".$row['reason']."&nbsp;</td>"
				."<td  align='center' nowrap><font class=\"content\">&nbsp;".hejridate(date("Y-m-d h:i:s", mktime($row['date'])),4,7,5)."&nbsp;</td>"
				."<td  align='center'><font class=\"content\"><a href=\"".$admin_file.".php?op=ipban_delete&id=".intval($row['id'])."&ok=0\"><img src=\"images/icon/cross.png\" width=\"15\" height=\"15\" border=\"0\" alt=\""._UNBAN."\" title=\""._UNBAN."\"></a></td></tr>";
			}
			echo "</table>";
			CloseTable();
		}
		include("footer.php");
	}

	function save_banned($ip1, $ip2, $ip3, $ip4, $reason) {
		global $prefix, $db;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._IPBANSYSTEM."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		if (substr($ip2, 0, 2) == 00) { $ip2 = preg_replace("/00/", "", $ip2); }
		if (substr($ip3, 0, 2) == 00) { $ip3 = preg_replace("/00/", "", $ip3); }
		if (substr($ip4, 0, 2) == 00) { $ip4 = preg_replace("/00/", "", $ip4); }
		$ip = "$ip1.$ip2.$ip3.$ip4";
		if (empty($ip1) OR empty($ip2) OR empty($ip3) OR empty($ip4)) {
			echo "<center><b>"._ERROR."</b> "._IPOUTRANGE."<br><br>"._IPENTERED." <b>".$ip."</b><br><br>"._GOBACK."</center>";
			CloseTable();
			include("footer.php");
			die();
		}
		if (!is_numeric($ip1) && !empty($ip1) OR !is_numeric($ip2) && !empty($ip2) OR !is_numeric($ip3) && !empty($ip3) OR !is_numeric($ip4) && !empty($ip4) && $ip4 != "*") {
			echo "<center><b>"._ERROR."</b> "._IPNUMERIC."<br><br>"._IPENTERED." <b>".$ip."</b><br><br>"._GOBACK."</center>";
			CloseTable();
			include("footer.php");
			die();
		}
		if ($ip1 > 255 OR $ip2 > 255 OR $ip3 > 255 OR $ip4 > 255 && $ip4 != "*") {
			echo "<center><b>"._ERROR."</b> "._IPOUTRANGE."<br><br>"._IPENTERED." <b>".$ip."</b><br><br>"._GOBACK."</center>";
			CloseTable();
			include("footer.php");
			die();
		}
		if (substr($ip1, 0, 1) == 0) {
			echo "<center><b>"._ERROR."</b> "._IPSTARTZERO."<br><br>"._IPENTERED." <b>".$ip."</b><br><br>"._GOBACK."</center>";
			CloseTable();
			include("footer.php");
			die();
		}
		if ($ip == "127.0.0.1") {
			echo "<center><b>"._ERROR."</b> "._IPLOCALHOST."<br><br>"._IPENTERED." <b>127.0.0.1</b><br><br>"._GOBACK."</center>";
			CloseTable();
			include("footer.php");
			die();
		}
		$my_ip = $_SERVER['REMOTE_ADDR'];
		if ($ip == $my_ip) {
			echo "<center><b>"._ERROR."</b> "._IPYOURS."<br><br>"._IPENTERED." <b>".$ip."</b><br><br>"._GOBACK."</center>";
			CloseTable();
			include("footer.php");
			die();
		}
		$date = date("Y-m-d");
		$reason = addslashes(check_words(check_html($reason, "nohtml")));
		$db->sql_query("INSERT INTO ".$prefix."_banned_ip VALUES (NULL, '$ip', '$reason', '$date')");
		echo "<center>"._SUCCESS."<br><br>"._THEIP." <b>".$ip."</b> "._HASBEENBANNED."</center>";
		CloseTable();
		include("footer.php");
	}

	function ipban_delete($id, $ok) {
		global $prefix, $db, $admin_file;
                $id = intval($id);
		$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_banned_ip WHERE id=".$id));
		if ($ok == 0) {
			include ("header.php");
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>"._IPBANSYSTEM."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			echo "<center>"._SURETOBANIP." <b>$row[ip_address]</b><br><br>[ <a href='".$admin_file.".php?op=ipban_delete&id=".$id."&ok=1'>"._YES."</a> | <a href='".$admin_file.".php?op=ipban'>"._NO."</a> ]";
			CloseTable();
			include("footer.php");
		} elseif ($ok == 1) {
			$db->sql_query("DELETE FROM ".$prefix."_banned_ip WHERE id=".$id);
			Header("Location: ".$admin_file.".php?op=ipban");
		}
	}

	switch($op) {

		case "ipban":
		main_ban($ip);
		break;

		case "save_banned":
		save_banned($ip1, $ip2, $ip3, $ip4, $reason);
		break;

		case "ipban_delete":
		ipban_delete($id, $ok);
		break;

	}

} else {
	echo "Access Denied";
}

?>