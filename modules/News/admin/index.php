<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV MarlikCMS PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.MarlikCMS.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|	* Copyright (c) 2005 - 2006 by http://www.irannuke.net										|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

include_once(MODULES_PATH."News/admin/includes/functions.php");	//-- general functions
include_once(MODULES_PATH."News/admin/includes/categories.php");	//-- categories functions

include_once(INCLUDES_PATH."inc_tags.php");
$tag = new Tags;

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='News'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
	if ($row2['name'] == "$admins[$i]" AND !empty($row['admins'])) {
		$auth_user = 1;
	}
}

if ($row2['radminsuper'] == 1) {
	$radminsuper = 1;
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {


	
	function deleteStory($qid) {
		global $prefix, $db, $admin_file;
		$qid = intval($qid);
		$result = $db->sql_query("delete from ".$prefix."_queue where qid='$qid'");
		if (!$result) {
			return;
		}
		Header("Location: ".$admin_file.".php?op=submissions");
	}

	function autodelete($anid) {
		global $prefix, $db, $admin_file;
		$anid = intval($anid);
		$db->sql_query("delete from ".$prefix."_autonews where anid='$anid'");
		Header("Location: ".$admin_file.".php?op=ShowNewsPanel");
	}

	function autoEdit($anid) {
		global $aid, $bgcolor1, $bgcolor2, $prefix, $db, $multilingual, $admin_file;
		$sid = intval($sid);
		$aid = substr("$aid", 0,25);
		$result = $db->sql_query("select radminsuper from ".$prefix."_authors where aid='$aid'");
		list($radminsuper) = $db->sql_fetchrow($result);
		$radminsuper = intval($radminsuper);
		$result = $db->sql_query("SELECT admins FROM ".$prefix."_modules WHERE title='News'");
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'"));
		while ($row = $db->sql_fetchrow($result)) {
			$admins = explode(",", $row['admins']);
			$auth_user = 0;
			for ($i=0; $i < sizeof($admins); $i++) {
				if ($row2['name'] == "$admins[$i]") {
					$auth_user = 1;
				}
			}
			if ($auth_user == 1) {
				$radminarticle = 1;
			}
		}
		$result2 = $db->sql_query("select aid from ".$prefix."_stories where sid='$sid'");
		list($aaid) = $db->sql_fetchrow($result2);
		$aaid = substr("$aaid", 0,25);
		if (($radminarticle==1) OR ($aid == $said) OR ($radminsuper==1)) { 
			include ("header.php");

			///usv tags
			$result = $db->sql_query("select catid, aid, title, time, hometext, bodytext, topic, informant, notes, ihome, alanguage, acomm, tags from ".$prefix."_autonews where anid='$anid'");
			list($catid, $aid, $title, $time, $hometext, $bodytext, $topic, $informant, $notes, $ihome, $alanguage, $acomm, $tags) =
			///
			$db->sql_fetchrow($result);
			$catid = intval($catid);
			$aid = substr("$aid", 0,25);
			$informant = substr("$informant", 0,25);
			$ihome = intval($ihome);
			$acomm = intval($acomm);
			if (ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime)) {
				$hejri_temp = $datetime[1] . "-" . $datetime[2] . "-" . $datetime[3];
				$hejri_temp = hejridate($hejri_temp, 1, 8);
				list($datetime[1], $datetime[2], $datetime[3]) = explode("-", $hejri_temp);
			} else {
				$datetime[1] = 0;
				$datetime[2] = 0;
				$datetime[3] = 1;
			}
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>"._ARTICLEADMIN."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			$today = getdate();
			$tday = $today[mday];
			if ($tday < 10){
				$tday = "0$tday";
			}
			$tmonth = $today[mon];
			$tyear = $today[year];
			$thour = $today[hours];
			if ($thour < 10){
				$thour = "0$thour";
			}
			$tmin = $today[minutes];
			if ($tmin < 10){
				$tmin = "0$tmin";
			}
			$tsec = $today[seconds];
			if ($tsec < 10){
				$tsec = "0$tsec";
			}
			$date = "$tyear-$tmonth-$tday $thour:$tmin:$tsec";
			$date = hejridate($date, 4, 7);
			echo "<center><font class=\"option\"><b>"._AUTOSTORYEDIT."</b></font></center><br><br>"
			."<form action=\"".$admin_file.".php\" method=\"post\">";
			$title = check_html($title, "nohtml");
			$hometext = stripslashes($hometext);

			$bodytext = stripslashes($bodytext);
			//@
			$newsrefrence = check_html($newsrefrence, "nohtml");
			$newsrefrencelink = check_html($newsrefrencelink, "nohtml");
			//@
			$notes = stripslashes($notes);
			$result=$db->sql_query("select topicimage from ".$prefix."_topics where topicid='$topic'");
			list($topicimage) = $db->sql_fetchrow($result);
			echo "<table border=\"0\" width=\"75%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"$bgcolor2\" align=\"center\"><tr><td>"
			."<table border=\"0\" width=\"100%\" cellpadding=\"8\" cellspacing=\"1\" bgcolor=\"$bgcolor1\"><tr><td>"
			."<img src=\"images/topics/$topicimage\" border=\"0\" align=\"right\">";
			//@			themepreview($title, $hometext, $bodytext);
			//@
			themepreview($title, $hometext, $bodytext, $newsrefrence, $newsrefrencelink, $notes);
			//@
			echo "</td></tr></table></td></tr></table>"
			."<br><br><b>"._TITLE."</b><br>"
			."<input type=\"text\" name=\"title\" size=\"50\" value=\"$title\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);><br><IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(title)><br><br>"
			."<b>"._TOPIC."</b> <select name=\"topic\">";
			$toplist = $db->sql_query("select topicid, topictext from ".$prefix."_topics order by topictext");
			echo "<option value=\"\">"._ALLTOPICS."</option>\n";
			while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
				$topicid = intval($topicid);
				$topics = check_html($topics, "nohtml");
				if ($topicid==$topic) { $sel = "selected "; }
				echo "<option $sel value=\"$topicid\">$topics</option>\n";
				$sel = "";
			}
			echo "</select><br><br>";
			$cat = $catid;
			SelectCategory($cat);
			echo "<br>";
			puthome($ihome, $acomm);
			if ($multilingual == 1) {
				echo "<br><b>"._LANGUAGE.": </b>"
				."<select name=\"alanguage\">";
				$handle=opendir('language');
				while ($file = readdir($handle)) {
					if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
						$langFound = $matches[1];
						$languageslist .= "$langFound ";
					}
				}
				closedir($handle);
				$languageslist = explode(" ", $languageslist);
				sort($languageslist);
				for ($i=0; $i < sizeof($languageslist); $i++) {
					if(!empty($languageslist[$i])) {
						echo "<option value=\"$languageslist[$i]\" ";
						if($languageslist[$i]==$alanguage) echo "selected";
						echo ">".ucfirst($languageslist[$i])."</option>\n";
					}
				}
				if (empty($alanguage)) {
					$sellang = "selected";
				} else {
					$sellang = "";
				}
				echo "<option value=\"\" $sellang>"._ALL."</option></select>";
			} else {
				echo "<input type=\"hidden\" name=\"alanguage\" value=\"\">";
			}
			echo "<br><br><b>"._STORYTEXT."</b><br>";
			#	."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"hometext\" id=\"ta\" style=\"width:100%\" ondblclick=\"initDocument();\">$hometext</textarea><br><br><br>"
			wysiwyg_textarea("hometext", "$hometext", "PHPNukeAdmin", "50", "20");
			echo "<b>"._EXTENDEDTEXT."</b><br>";
			#	."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"bodytext\" id=\"ta2\" style=\"width:100%\" ondblclick=\"initDocument();\">$bodytext</textarea><br><br>"
			wysiwyg_textarea("bodytext", "$bodytext", "PHPNukeAdmin", "50", "20");
			//@
			echo "<br><b>"._NEWSREFRENCE."</b><br>"
			."<input type=\"text\" name=\"newsrefrence\" size=\"50\" value=\"$newsrefrence\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);>&nbsp;<IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(newsprefrence)><br><br>"
			."<b>"._NEWSREFRENCELINK."</b><br>"
			."<input type=\"text\" name=\"newsrefrencelink\" size=\"50\" value=\"$newsrefrencelink\"><br><br>";
			//@
			echo "<font class=\"content\">"._ARESUREURL."</font><br><br>";
			if ($aid != $informant) {
				echo "<br><br><b>"._NOTES."</b><br>";
				#	<textarea wrap=\"virtual\" cols=\"100\" rows=\"10\" name=\"notes\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);>$notes</textarea><br><IMG src=\"images/fa.gif\" style=\"CURSOR: hand\" onclick=change(notes)><br><br>";
				wysiwyg_textarea("notes", "$notes", "PHPNuke", "50", "10");
			}

			// tagging system By James : input box USV
			echo '<script type="text/javascript" src="includes/javascript/jquery/plugins/autocomplete/jquery.autocomplete.min.js"></script>
			<script type="text/javascript">
			$().ready(function() {
			$("#tags").autocomplete(\''.ADMIN_OP.'Tags&act=query\',{
			multiple: true,
			minChars: 1});
			  });
			</script>
			<style>
			@import url(\'includes/javascript/jquery/plugins/autocomplete/jquery.autocomplete.css\');
			</style>';
			echo '<br />',_TAGS,': <input type="text" dir="rtl" name="tags" id="tags" size="50" value="" autocomplete="off" /><br /><br />';

			//---------------------------------------
			echo "<br><b>"._CHNGPROGRAMSTORY."</b><br><br>"
			.""._NOWIS.": $date<br><br>";

			$xday = 1;
			echo ""._DAY.": ";
			echo get_hejri_day($datetime[2], "day", $datetime[3]);
			$xmonth = 1;
			echo " "._UMONTH.": ";
			echo get_hejri_month("month", $datetime[2]);
			echo " "._YEAR.": <input type=\"text\" dir=\"ltr\" name=\"year\" value=\"$datetime[1]\" size=\"5\" maxlength=\"4\">";
			echo "<br>"._HOUR.": <select name=\"hour\">";
			$xhour = 0;
			$cero = "0";
			while ($xhour <= 23) {
				$dummy = $xhour;
				if ($xhour < 10) {
					$xhour = "$cero$xhour";
				}
				if ($xhour == $datetime[4]) {
					$sel = "selected";
				} else {
					$sel = "";
				}
				echo "<option name=\"hour\" $sel>$xhour</option>";
				$xhour = $dummy;
				$xhour++;
			}
			echo "</select>";
			echo ": <select name=\"min\">";
			$xmin = 0;
			while ($xmin <= 59) {
				if (($xmin == 0) OR ($xmin == 5)) {
					$xmin = "0$xmin";
				}
				if ($xmin == $datetime[5]) {
					$sel = "selected";
				} else {
					$sel = "";
				}
				echo "<option name=\"min\" $sel>$xmin</option>";
				$xmin = $xmin + 5;
			}
			echo "</select>";
			echo ": 00<br><br>
    <input type=\"hidden\" name=\"anid\" value=\"$anid\">
    <input type=\"hidden\" name=\"op\" value=\"autoSaveEdit\">
    <input type=\"submit\" value=\""._SAVECHANGES."\">
    </form>";
			CloseTable();
			include ('footer.php');
		} else {
			include ('header.php');
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>"._ARTICLEADMIN."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			echo "<center><b>"._NOTAUTHORIZED1."</b><br><br>"
			.""._NOTAUTHORIZED2."<br><br>"
			.""._GOBACK."";
			CloseTable();
			include("footer.php");
		}
	}

	function autoSaveEdit($anid, $year, $day, $month, $hour, $min, $title, $hometext, $bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm,$tags) {
		//@
		global $aid, $prefix, $db, $admin_file;
		$aid = substr("$aid", 0,25);
		$sid = intval($sid);
		$result = $db->sql_query("select radminsuper from ".$prefix."_authors where aid='$aid'");
		list($radminsuper) = $db->sql_fetchrow($result);
		$radminsuper = intval($radminsuper);
		$result = $db->sql_query("SELECT admins FROM ".$prefix."_modules WHERE title='News'");
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'"));
		while ($row = $db->sql_fetchrow($result)) {
			$admins = explode(",", $row['admins']);
			$auth_user = 0;
			for ($i=0; $i < sizeof($admins); $i++) {
				if ($row2['name'] == "$admins[$i]") {
					$auth_user = 1;
				}
			}
			if ($auth_user == 1) {
				$radminarticle = 1;
			}
		}
		$result2 = $db->sql_query("select aid from ".$prefix."_stories where sid='$sid'");
		list($aaid) = $db->sql_fetchrow($result2);
		$aaid = substr("$aaid", 0,25);
		if (($radminarticle==1) OR ($aid == $said) OR ($radminsuper==1)) { 
			if ($day < 10) {
				$day = "0$day";
			}
			if ($month < 10) {
				$month = "0$month";
			}
			$sec = "00";
			$hejri_temp = "$year-$month-$day";
			$hejri_temp = hejriback($hejri_temp, 2, 2);
			$date = "$hejri_temp $hour:$min:$sec";
			$title = check_words(check_html(addslashes($title), "nohtml"));
			$hometext = stripslashes(FixQuotes($hometext));

			$bodytext = stripslashes(FixQuotes($bodytext));
			//@
			$newsrefrence = check_words(check_html(addslashes($newsrefrence), "nohtml"));
			$newsrefrencelink = check_words(check_html(addslashes($newsrefrencelink), "nohtml"));
			//@
			$notes = stripslashes(FixQuotes($notes));


			// tagging system By James-- USV
			$tags = stripslashes(FixQuotes($tags));
			$notes = stripslashes(FixQuotes($notes));
			// -------------------------
			$result = $db->sql_query("update ".$prefix."_autonews set catid='$catid', title='$title', time='$date', hometext='$hometext', bodytext='$bodytext', topic='$topic', notes='$notes', ihome='$ihome', alanguage='$alanguage', acomm='$acomm', tags='$tags' where anid='$anid'");
			if (!$result) {
				exit();
			}
			
			Header("Location: ".$admin_file.".php?op=ShowNewsPanel");
		} else {
			include ('header.php');
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>"._ARTICLEADMIN."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			echo "<center><b>"._NOTAUTHORIZED1."</b><br><br>"
			.""._NOTAUTHORIZED2."<br><br>"
			.""._GOBACK."";
			CloseTable();
			include("footer.php");
		}
	}

	function displayStory($qid) {
		global $user, $subject, $story, $bgcolor1, $bgcolor2, $anonymous, $user_prefix, $prefix, $db, $multilingual, $admin_file;
		include ('header.php');
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._SUBMISSIONSADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		$today = getdate();
		$tday = $today[mday];
		if ($tday < 10){
			$tday = "0$tday";
		}
		$tmonth = $today[mon];
		$ttmon = $today[mon];
		if ($ttmon < 10){
			$ttmon = "0$ttmon";
		}
		$tyear = $today[year];
		$thour = $today[hours];
		if ($thour < 10){
			$thour = "0$thour";
		}
		$tmin = $today[minutes];
		if ($tmin < 10){
			$tmin = "0$tmin";
		}
		$tsec = $today[seconds];
		if ($tsec < 10){
			$tsec = "0$tsec";
		}
		$date = "$tyear-$tmonth-$tday $thour:$tmin:$tsec";
		$date = hejridate($date, 4, 7);
		$qid = intval($qid);
		$result = $db->sql_query("SELECT qid, uid, uname, subject,now(), story, storyext, topic, alanguage FROM ".$prefix."_queue where qid='$qid'");
		list($qid, $uid, $uname, $subject, $time, $story, $storyext, $topic, $alanguage) = $db->sql_fetchrow($result);
		$qid = intval($qid);
		$uid = intval($uid);
		$topic = intval($topic);
		$uname = check_html($uname, "nohtml");
		$subject = stripslashes(check_words(check_html($subject, "nohtml")));
		$story = stripslashes(check_words(check_html($story, "")));
		$storyext = stripslashes(check_words(check_html($storyext, "")));
		$story1 = eregi_replace("<a href=\"http://", "<a href=\"index.php?url=http://", $story);
		$storyext1 = eregi_replace("<a href=\"http://", "<a href=\"index.php?url=http://", $storyext);
		OpenTable();
		echo "<font class=\"content\">"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<b>"._NAME."</b><br>"
		."<input type=\"text\" NAME=\"author\" size=\"25\" value=\"$uname\">";
		if ($uname != $anonymous) {
			$res = $db->sql_query("select user_email from ".$user_prefix."_users where username='$uname'");
			list($email) = $db->sql_fetchrow($res);
			$email = check_html($email, "nohtml");
			echo "&nbsp;&nbsp;<font class=\"content\">[ <a href=\"mailto:$email?Subject=Re: $subject\">"._EMAILUSER."</a> | <a href='modules.php?name=Your_Account&op=userinfo&username=$uname'>"._USERPROFILE."</a> | <a href=\"modules.php?name=Private_Messages&amp;mode=post&amp;u=$uid\">"._SENDPM."</a> ]</font>";
		}
		echo "<br><br><b>"._TITLE."</b><br>"
		."<input type=\"text\" name=\"subject\" size=\"50\" value=\"$subject\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);><br><IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(subject)><br><br>";
		if(empty($topic)) {
			$topic = 1;
		}
		$result = $db->sql_query("select topicimage from ".$prefix."_topics where topicid='$topic'");
		list($topicimage) = $db->sql_fetchrow($result);
		echo "<table border=\"0\" width=\"70%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"$bgcolor2\" align=\"center\"><tr><td>"
		."<table border=\"0\" width=\"100%\" cellpadding=\"8\" cellspacing=\"1\" bgcolor=\"$bgcolor1\"><tr><td>"
		."<img src=\"images/topics/$topicimage\" border=\"0\" align=\"right\" alt=\"\">";
		$storypre = "$story1<br><br>$storyext1";
		themepreview($subject, $storypre);
		echo "</td></tr></table></td></tr></table>"
		."<br><b>"._TOPIC."</b> <select name=\"topic\">";
		$toplist = $db->sql_query("select topicid, topictext from ".$prefix."_topics order by topictext");
		echo "<option value=\"\">"._SELECTTOPIC."</option>\n";
		while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
			$topicid = intval($topicid);
			$topics = check_html($topics, "nohtml");
			if ($topicid==$topic) {
				$sel = "selected ";
			}
			echo "<option $sel value=\"$topicid\">$topics</option>\n";
			$sel = "";
		}
		echo "</select>";
		echo "<br><br>";
		echo "<table border='0' width='100%' cellspacing='0'><tr><td width='20%'><b>"._ASSOTOPIC."</b></td><td width='100%'>"
		."<table border='1' cellspacing='3' cellpadding='8'><tr>";
		$sql = "SELECT topicid, topictext FROM ".$prefix."_topics ORDER BY topictext";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$row['topicid'] = intval($row['topicid']);
			$row['topictext'] = check_html($row['topictext'], "nohtml");
			if ($a == 3) {
				echo "</tr><tr>";
				$a = 0;
			}
			echo "<td><input type='checkbox' name='assotop[]' value='".intval($row['topicid'])."'>".$row['topictext']."</td>";
			$a++;
		}
		echo "</tr></table></td></tr></table><br><br>";
		SelectCategory($cat);
		echo "<br>";
		puthome($ihome, $acomm);
		if ($multilingual == 1) {
			echo "<br><b>"._LANGUAGE.": </b>"
			."<select name=\"alanguage\">";
			$handle=opendir('language');
			$languageslist = "";
			while ($file = readdir($handle)) {
				if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
					$langFound = $matches[1];
					$languageslist .= "$langFound ";
				}
			}
			closedir($handle);
			$languageslist = explode(" ", $languageslist);
			sort($languageslist);
			for ($i=0; $i < sizeof($languageslist); $i++) {
				if(!empty($languageslist[$i])) {
					echo "<option value=\"$languageslist[$i]\" ";
					if($languageslist[$i]==$alanguage) echo "selected";
					echo ">".ucfirst($languageslist[$i])."</option>\n";
				}
			}
			if (empty($alanguage)) {
				$sellang = "selected";
			} else {
				$sellang = "";
			}
			echo "<option value=\"\" $sellang>"._ALL."</option></select>";
		} else {
			echo "<input type=\"hidden\" name=\"alanguage\" value=\"\">";
		}
		echo "<br><br><b>"._STORYTEXT."</b><br>";

		//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"hometext\" style=\"width:100%\">$story</textarea>"
		wysiwyg_textarea('hometext', "$story", 'PHPNukeAdmin', 50, 7);

		echo "<br><br><br><b>"._EXTENDEDTEXT."</b><br>";

		//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"bodytext\" style=\"width:100%\">$storyext</textarea>"
		wysiwyg_textarea('bodytext', "$storyext", 'PHPNukeAdmin', 50, 8);

		echo "<br><br><font class=\"content\">"._AREYOUSURE."</font><br><br>"
		."<b>"._NOTES."</b><br>";

		//."<textarea wrap=\"virtual\" cols=\"100\" rows=\"10\" name=\"notes\" style=\"width:100%\"></textarea>"
		wysiwyg_textarea('notes', '', 'PHPNuke', 50, 6);

		echo "<br><br><input type=\"hidden\" NAME=\"qid\" size=\"50\" value=\"$qid\">"
		."<input type=\"hidden\" NAME=\"uid\" size=\"50\" value=\"$uid\">"
		."<br><b>"._PROGRAMSTORY."</b>&nbsp;&nbsp;"
		."<input type=\"radio\" name=\"automated\" value=\"1\">"._YES." &nbsp;&nbsp;"
		."<input type=\"radio\" name=\"automated\" value=\"0\" checked>"._NO."<br><br>"
		.""._NOWIS.": $date<br><br>";
		// USV
		//$time = date("Y-m-d H:i:s");
		$ctime = explode("-",$time);
		$val1 = explode(" ",$ctime[2]);
		$val = explode(":",$val1[1]);
		$ctime = hejridate("$ctime[0]-$ctime[1]-$val1[0]",1,8);
		$ctime = explode("-",$ctime);
		$day = 1;
		$month = 1;
		echo ""._DAY." : ";
		echo get_hejri_day(intval($ctime[1]), "day", intval($ctime[2]));
		echo ""._UMONTH." : ";
		echo get_hejri_month("month", intval($ctime[1]));
		$date = date("Y-m-d");
		$date = hejridate($date, 1, 8);
		$date_temp = explode("-", $date);
		$year = $date_temp[0];
		echo ""._YEAR.": <input type=\"text\" dir=\"ltr\" name=\"year\" value=\"$year\" size=\"5\" maxlength=\"4\">"
		."<br>"._HOUR.": <select name=\"hour\">";
		$hour = 0;
		$cero = "0";
		while ($hour <= 23) {
			$dummy = $hour;
			if ($hour < 10) {
				$hour = "$cero$hour";
			}
			if($hour == $val[0]){
				$selected = "SELECTED";}else{$selected="";}
				echo "<option $selected name=\"hour\">$hour</option>";
				$hour = $dummy;
				$hour++;
		}
		echo "</select>"
		.": <select name=\"min\">";
		$min = 0;
		while ($min <= 59) {
			if (($min == 0) OR ($min == 5)) {
				$min = "0$min";
			}
			if($min == $val[1]){
				$selected = "SELECTED";}else{$selected="";}
				echo "<option $selected name=\"min\">$min</option>";
				$min++;
		}
		echo "</select>";
		echo ": 00<br><br>";
		// USV --
		echo "<select name=\"op\">"
		."<option value=\"DeleteStory\">"._DELETESTORY."</option>"
		."<option value=\"PreviewAgain\" selected>"._PREVIEWSTORY."</option>"
		."<option value=\"PostStory\">"._POSTSTORY."</option>"
		."</select>"
		."<input type=\"submit\" value=\""._OK."\">&nbsp;&nbsp;[ <a href=\"".$admin_file.".php?op=DeleteStory&qid=$qid\">"._DELETE."</a> ]";
		CloseTable();
		echo "<br>";
		putpoll($pollTitle, $optionText);
		echo "</form>";
		include ('footer.php');
	}

	function previewStory($year, $day, $month, $hour, $min,$sid, $uid, $author, $subject, $hometext, $bodytext, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop,$tags) {
		global $user, $boxstuff, $anonymous, $bgcolor1, $bgcolor2, $user_prefix, $prefix, $db, $multilingual, $admin_file;
		include ('header.php');
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._ARTICLEADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		$today = getdate();
		$tday = $today[mday];
		if ($tday < 10){
			$tday = "0$tday";
		}
		$tmonth = $today[mon];
		$tyear = $today[year];
		$thour = $today[hours];
		if ($thour < 10){
			$thour = "0$thour";
		}
		$tmin = $today[minutes];
		if ($tmin < 10){
			$tmin = "0$tmin";
		}
		$tsec = $today[seconds];
		if ($tsec < 10){
			$tsec = "0$tsec";
		}
		$date = "$tyear-$tmonth-$tday $thour:$tmin:$tsec";
		$date = hejridate($date, 4, 7);
		$subject = check_words(check_html($subject,"nohtml"));
		$hometext = check_words(check_html($hometext,""));
		$bodytext = check_words(check_html($bodytext,""));
		$hometext1 = eregi_replace("<a href=\"http://", "<a href=\"index.php?url=http://", $hometext);
		$bodytext1 = eregi_replace("<a href=\"http://", "<a href=\"index.php?url=http://", $bodytext);
		$notes = check_words(check_html($notes,""));
		OpenTable();
		echo "<font class=\"content\">"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<b>"._NAME."</b><br>"
		."<input type=\"text\" name=\"author\" size=\"25\" value=\"$author\">";
		if ($author != $anonymous) {
			$res = $db->sql_query("select user_id, user_email from ".$user_prefix."_users where username='$author'");
			list($pm_userid, $email) = $db->sql_fetchrow($res);
			$pm_userid = intval($pm_userid);
			echo "&nbsp;&nbsp;<font class=\"content\">[ <a href=\"mailto:$email?Subject=Re: $subject\">"._EMAILUSER."</a> | <a href='modules.php?name=Your_Account&op=userinfo&username=$author'>"._USERPROFILE."</a> | <a href=\"modules.php?name=Private_Messages&amp;mode=post&amp;u=$uid\">"._SENDPM."</a> ]</font>";
		}
		echo "<br><br><b>"._TITLE."</b><br>"
		."<input type=\"text\" name=\"subject\" size=\"50\" value=\"$subject\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);><br><IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(subject)><br><br>";
		$result = $db->sql_query("select topicimage from ".$prefix."_topics where topicid='$topic'");
		list($topicimage) = $db->sql_fetchrow($result);
		echo "<table width=\"70%\" bgcolor=\"$bgcolor2\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\"align=\"center\"><tr><td>"
		."<table width=\"100%\" bgcolor=\"$bgcolor1\" cellpadding=\"8\" cellspacing=\"1\" border=\"0\"><tr><td>"
		."<img src=\"images/topics/$topicimage\" border=\"0\" align=\"right\">";
		themepreview($subject, $hometext1, $bodytext1, $notes);
		echo "</td></tr></table></td></tr></table>"
		."<br><b>"._TOPIC."</b> <select name=\"topic\">";
		$toplist = $db->sql_query("select topicid, topictext from ".$prefix."_topics order by topictext");
		echo "<option value=\"\">"._ALLTOPICS."</option>\n";
		while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
			$topicid = intval($topicid);
			$topics = check_html($topics, "nohtml");
			if ($topicid==$topic) {
				$sel = "selected ";
			}
			echo "<option $sel value=\"$topicid\">$topics</option>\n";
			$sel = "";
		}
		echo "</select>";
		echo "<br><br>";
		$associated = "";
		for ($i=0; $i<sizeof($assotop); $i++) {
			$associated .= "$assotop[$i]-";
		}
		$asso_t = explode("-", $associated);
		echo "<table border='0' width='100%' cellspacing='0'><tr><td width='20%'><b>"._ASSOTOPIC."</b></td><td width='100%'>"
		."<table border='1' cellspacing='3' cellpadding='8'><tr>";
		$sql = "SELECT topicid, topictext FROM ".$prefix."_topics ORDER BY topictext";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) {
			$row['topicid'] = intval($row['topicid']);
			$row['topictext'] = check_html($row['topictext'], "nohtml");
			if ($a == 3) {
				echo "</tr><tr>";
				$a = 0;
			}
			$checked = "";
			for ($i=0; $i<sizeof($asso_t); $i++) {
				if ($asso_t[$i] == $row['topicid']) {
					$checked = "CHECKED";
					break;
				}
			}
			echo "<td><input type='checkbox' name='assotop[]' value='".intval($row['topicid'])."' $checked>".$row['topictext']."</td>";
			$a++;
		}
		echo "</tr></table></td></tr></table><br><br>";
		$cat = $catid;
		SelectCategory($cat);
		echo "<br>";
		puthome($ihome, $acomm);
		if ($multilingual == 1) {
			echo "<br><b>"._LANGUAGE.": </b>"
			."<select name=\"alanguage\">";
			$handle=opendir('language');
			$languageslist = "";
			while ($file = readdir($handle)) {
				if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
					$langFound = $matches[1];
					$languageslist .= "$langFound ";
				}
			}
			closedir($handle);
			$languageslist = explode(" ", $languageslist);
			sort($languageslist);
			for ($i=0; $i < sizeof($languageslist); $i++) {
				if(!empty($languageslist[$i])) {
					echo "<option value=\"$languageslist[$i]\" ";
					if($languageslist[$i]==$alanguage) echo "selected";
					echo ">".ucfirst($languageslist[$i])."</option>\n";
				}
			}
			if (empty($alanguage)) {
				$sellang = "selected";
			} else {
				$sellang = "";
			}
			echo "<option value=\"\" $sellang>"._ALL."</option></select>";
		} else {
			echo "<input type=\"hidden\" name=\"alanguage\" value=\"$language\">";
		}
		echo "<br><br><b>"._STORYTEXT."</b><br>";

		//echo "<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"hometext\" style=\"width:100%\">$hometext</textarea>"
		wysiwyg_textarea('hometext', "$hometext", 'PHPNukeAdmin', 50, 7);

		echo "<br><br><br><b>"._EXTENDEDTEXT."</b><br>";

		//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"bodytext\" style=\"width:100%\">$bodytext</textarea>"
		wysiwyg_textarea('bodytext', "$bodytext", 'PHPNukeAdmin', 50, 10);

		echo "<br><br><font class=\"content\">"._AREYOUSURE."</font><br><br>"
		."<b>"._NOTES."</b><br>";

		//."<textarea wrap=\"virtual\" cols=\"100\" rows=\"10\" name=\"notes\" style=\"width:100%\">$notes</textarea>"
		wysiwyg_textarea('notes', "$notes", 'PHPNukeAdmin', 50, 6);
		// tagging system By James
		echo '<script type="text/javascript" src="includes/javascript/jquery/plugins/autocomplete/jquery.autocomplete.min.js"></script>
<script>
$().ready(function() {
$("#tags").autocomplete(\''.ADMIN_OP.'Tags&act=query\',{
multiple: true,
minChars: 1});
  });
</script>
<style>
@import url(\'includes/javascript/jquery/plugins/autocomplete/jquery.autocomplete.css\');
</style>';
		echo '<br />',_TAGS,': <input type="text" dir="rtl" name="tags" id="tags" size="50" value="" autocomplete="off" /><br /><br />';

		echo "<br><br><input type=\"hidden\" NAME=\"qid\" size=\"50\" value=\"$qid\">"
		."<input type=\"hidden\" NAME=\"uid\" size=\"50\" value=\"$uid\">";
		if ($automated == 1) {
			$sel1 = "checked";
			$sel2 = "";
		} else {
			$sel1 = "";
			$sel2 = "checked";
		}
		echo "<b>"._PROGRAMSTORY."</b>&nbsp;&nbsp;"
		."<input type=\"radio\" name=\"automated\" value=\"1\" $sel1>"._YES." &nbsp;&nbsp;"
		."<input type=\"radio\" name=\"automated\" value=\"0\" $sel2>"._NO."<br><br>"
		.""._NOWIS.": $date<br><br>";
		$xday = 1;
		echo ""._DAY." : ";
		if (!$month) $month = 1;
		echo get_hejri_day($month, "day", $day);
		$xmonth = 1;
		echo ""._UMONTH." : ";
		echo get_hejri_month("month", $month);
		echo ""._YEAR.": <input type=\"text\" dir=\"ltr\" name=\"year\" value=\"$year\" size=\"5\" maxlength=\"4\">";
		echo "<br>"._HOUR.": <select name=\"hour\">";
		$xhour = 0;
		$cero = "0";
		while ($xhour <= 23) {
			$dummy = $xhour;
			if ($xhour < 10) {
				$xhour = "$cero$xhour";
			}
			if ($xhour == $hour) {
				$sel = "selected";
			} else {
				$sel = "";
			}
			echo "<option name=\"hour\" $sel>$xhour</option>";
			$xhour = $dummy;
			$xhour++;
		}
		echo "</select>";
		echo ": <select name=\"min\">";
		$xmin = 0;
		while ($xmin <= 59) {
			if ($xmin == $min) {
				$sel = "SELECTED";
			} else {
				$sel = "";
			}
			if ($xmin < 10) {
				$xmin = "0$xmin";
			}

			echo "<option name=\"min\" $sel>$xmin</option>";
			$xmin++;
		}
		echo "</select>";
		echo ": 00<br><br>"
		."<select name=\"op\">"
		."<option value=\"DeleteStory\">"._DELETESTORY."</option>"
		."<option value=\"PreviewAgain\" selected>"._PREVIEWSTORY."</option>"
		."<option value=\"ChangeStory\">"._POSTSTORY."</option>"
		."</select>"
		."<input type=\"submit\" value=\""._OK."\">";
		CloseTable();
		echo "<br>";
		putpoll($pollTitle, $optionText);
		echo "</form>";
		include ('footer.php');
	}

	function postStory($automated, $year, $day, $month, $hour, $min, $qid, $uid, $author, $subject, $hometext, $bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop,$tags) {
		//@
		global $aid, $ultramode, $prefix, $db, $user_prefix, $admin_file,$tag;
		for ($i=0; $i<sizeof($assotop); $i++) {
			$associated .= "$assotop[$i]-";
		}
		// USV BUILD 5 -- Altering Automated News -- BEGIN Sun 01 Nov 2009 07:35:18 PM IRST
		if ($automated == 1) {
			if ($day < 10) {
				$day = "0$day";
			}
			if ($month < 10) {
				$month = "0$month";
			}
			$sec = "00";
			$hejri_temp = "$year-$month-$day";
			$hejri_temp = hejriback($hejri_temp, 2, 2);
			$date = "$hejri_temp $hour:$min:$sec";
		} else {
			$date = date("Y-m-j H:i-1:s");
		}
		// USV BUILD 5 -- Altering Automated News -- End
		if ($uid == 1) $author = "";
		if ($hometext == $bodytext) $bodytext = "";
		$subject = check_words(check_html(addslashes($subject), "nohtml"));
		$hometext = stripslashes(FixQuotes($hometext));

		$bodytext = stripslashes(FixQuotes($bodytext));
		//@
		$newsrefrence = check_words(check_html(addslashes($newsrefrence), "nohtml"));
		$newsrefrencelink = check_words(check_html(addslashes($newsrefrencelink), "nohtml"));
		//@
		$notes = stripslashes(FixQuotes($notes));
		if ((!empty($pollTitle)) AND (!empty($optionText[1])) AND (!empty($optionText[2]))) {
			$haspoll = 1;
			$timeStamp = time();
			$pollTitle = check_words(check_html(addslashes($pollTitle), "nohtml"));
			if(!$db->sql_query("INSERT INTO ".$prefix."_poll_desc VALUES (NULL, '$pollTitle', '$timeStamp', '0', '$alanguage', '0', '0')")) {
				return;
			}
			$object = $db->sql_fetchrow($db->sql_query("SELECT pollID FROM ".$prefix."_poll_desc WHERE pollTitle='$pollTitle'"));
			$id = $object['pollID'];
			$id = intval($id);
			for($i = 1; $i <= sizeof($optionText); $i++) {
				if(!empty($optionText[$i])) {
					$optionText[$i] = check_words(check_html(addslashes($optionText[$i]), "nohtml"));
				}
				if(!$db->sql_query("INSERT INTO ".$prefix."_poll_data (pollID, optionText, optionCount, voteID) VALUES ('$id', '$optionText[$i]', '0', '$i')")) {
					return;
				}
			}
		} else {
			$haspoll = 0;
			$id = 0;
		}
		// USV BUILD 9 -- Tags -- This is the power of OOP
		$tag->add_tags($tags);
		$tag_ids = $tag->get_tag_ids($tags);

		$result = $db->sql_query("insert into ".$prefix."_stories values (NULL, '$catid', '$aid', '$subject', '$date', '$hometext', '$bodytext', '0', '0', '$topic', '$author', '$notes', '$ihome', '$alanguage', '$acomm', '$haspoll', '$id', '$associated','$tag_ids','1','$section')");
		$result = $db->sql_query("select sid from ".$prefix."_stories WHERE title='$subject' order by time DESC limit 0,1");

		list($artid) = $db->sql_fetchrow($result);
		$artid = intval($artid);
		$db->sql_query("UPDATE ".$prefix."_poll_desc SET artid='$artid' WHERE pollID='$id'");
		if (!$result) {
			return;
		}
		if ($uid != 1) {
			$row = $db->sql_fetchrow($db->sql_query("SELECT points FROM ".$prefix."_groups_points WHERE id='4'"));
			$db->sql_query("UPDATE ".$user_prefix."_users SET points=points+".intval($row['points'])." where user_id='$uid'");
			$db->sql_query("update ".$user_prefix."_users set counter=counter+1 where user_id='$uid'");
		}
		$db->sql_query("update ".$prefix."_authors set counter=counter+1 where aid='$aid'");

		deleteStory($qid);

	}

	function removeStory($sid, $ok=0) {
		//@		global $ultramode, $aid, $prefix, $db, $admin_file;
		//@
		global $aid, $prefix, $db, $admin_file, $module_name,$tag;
		//@
		$aid = substr("$aid", 0,25);
		$result = $db->sql_query("select counter, radminsuper from ".$prefix."_authors where aid='$aid'");
		list($counter, $radminsuper) = $db->sql_fetchrow($result);
		$radminsuper = intval($radminsuper);
		$counter = intval($counter);
		$sid = intval($sid);
		$result = $db->sql_query("SELECT admins FROM ".$prefix."_modules WHERE title='News'");
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'"));
		$adminarticle = 0;
		while ($row = $db->sql_fetchrow($result)) {
			$admins = explode(",", $row['admins']);
			$auth_user = 0;
			for ($i=0; $i < sizeof($admins); $i++) {
				if ($row2['name'] == "$admins[$i]") {
					$auth_user = 1;
				}
			}
			if ($auth_user == 1) {
				$radminarticle = 1;
			}
		}
		$result2 = $db->sql_query("select aid,tags from ".$prefix."_stories where sid='$sid'");
		list($aaid,$tags) = $db->sql_fetchrow($result2);
		$aaid = substr("$aaid", 0,25);
		if (($radminarticle==1) OR ($aid == $said) OR ($radminsuper==1)) { 
			if($ok) {
				$counter--;

				$db->sql_query("DELETE FROM ".$prefix."_stories where sid='$sid'");
				$db->sql_query("DELETE FROM ".$prefix."_comments where sid='$sid'");
				$db->sql_query("update ".$prefix."_poll_desc set artid='0' where artid='$sid'");
				// this is where we decrease the tags' count to ensure statistic certainty
				$tags = $tag->get_tag_by_ids($tags);
				$tag->countdown(explode(",",$tags));
				$result = $db->sql_query("update ".$prefix."_authors set counter='$counter' where aid='$aid'");

				Header("Location: ".$admin_file.".php");
			} else {
				include("header.php");
				GraphicAdmin();
				OpenTable();
				echo "<center><font class=\"title\"><b>"._ARTICLEADMIN."</b></font></center>";
				CloseTable();
				echo "<br>";
				OpenTable();
				echo "<center>"._REMOVESTORY." $sid "._ANDCOMMENTS."";
				echo "<br><br>[ <a href=\"".$admin_file.".php\">"._NO."</a> | <a href=\"".$admin_file.".php?op=RemoveStory&amp;sid=$sid&amp;ok=1\">"._YES."</a> ]</center>";
				CloseTable();
				include("footer.php");
			}
		} else {
			include ('header.php');
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>"._ARTICLEADMIN."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			echo "<center><b>"._NOTAUTHORIZED1."</b><br><br>"
			.""._NOTAUTHORIZED2."<br><br>"
			.""._GOBACK."";
			CloseTable();
			include("footer.php");
		}
	}

	function changeStory($automated, $year, $day, $month, $hour, $min,$sid, $subject, $hometext,$bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $hotnews, $assotop,$tags,$section) {
		//@
		global $aid, $ultramode, $prefix, $db, $admin_file,$tag;
		for ($i=0; $i<sizeof($assotop); $i++) {
			$associated .= "$assotop[$i]-";
		}
		
		if ($automated == 1) {
			if ($day < 10) {
				$day = "0$day";
			}
			if ($month < 10) {
				$month = "0$month";
			}
			$sec = "00";
			$hejri_temp = "$year-$month-$day";
			$hejri_temp = hejriback($hejri_temp, 2, 2);
			$date = "$hejri_temp $hour:$min:$sec";
			$timeSave = "`time` ='$date',";
		}else {
			$timeSave = "";
		}

		
		$sid = intval($sid);
		$aid = substr("$aid", 0,25);
		$result = $db->sql_query("select radminsuper from ".$prefix."_authors where aid='$aid'");
		list($radminsuper) = $db->sql_fetchrow($result);
		$radminsuper = intval($radminsuper);
		$result = $db->sql_query("SELECT admins FROM ".$prefix."_modules WHERE title='News'");
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'"));
		while ($row = $db->sql_fetchrow($result)) {
			$admins = explode(",", $row['admins']);
			$auth_user = 0;
			for ($i=0; $i < sizeof($admins); $i++) {
				if ($row2['name'] == "$admins[$i]") {
					$auth_user = 1;
				}
			}
			if ($auth_user == 1) {
				$radminarticle = 1;
			}
		}
		$result2 = $db->sql_query("select aid  from ".$prefix."_stories where sid='$sid'");
		list($aaid) = $db->sql_fetchrow($result2);
		//list($time) = $db->sql_fetchrow($db->sql_query("select time from ".$prefix."_stories where sid='$sid'"));
		$aaid = substr("$aaid", 0,25);
		if (($radminarticle==1) OR ($aid == $said) OR ($radminsuper==1)) { 
			$catid = intval($catid);
			$subject = strip_tags($subject);
			$hometext = addslashes($hometext);
			$bodytext = addslashes($bodytext);
			//@
			// tagging system By James
			$tags = strip_tags($tags);
	
			//------------------------

			$newsrefrence = strip_tags($newsrefrence);
			$newsrefrencelink = strip_tags($newsrefrencelink);
			//@
			$topic = intval($topic);
			$notes = addslashes(check_words(check_html($notes, "html")));
			$ihome = intval($ihome);
			$alanguage = strip_tags($alanguage);
			$acomm = intval($acomm);
			//@
			$hotnews = intval($hotnews);

			//@
			$associated = strip_tags($associated);

			if (empty($tags) AND empty($hometext) AND empty($bodytext)) {
			$result = $db->sql_query("update `".$prefix."_stories` set `catid`='$catid', `title`='$subject',`newsref`='$newsrefrence', `newsreflink`='$newsrefrencelink', `topic`='$topic', `notes`='$notes', `ihome`='$ihome', `alanguage`='$alanguage', `acomm`='$acomm', `hotnews`='$hotnews', `associated`='$associated',`section`='$section'  where `sid`='$sid'");
			echo mysql_error();
			}else {
			
			$tag->change_story_tags($tags,$sid);
			$tag_ids = $tag->get_tag_ids($tags);
			$result = $db->sql_query("update ".$prefix."_stories set catid='$catid', title='$subject' , hometext='$hometext', bodytext='$bodytext',`newsref`='$newsrefrence', `newsreflink`='$newsrefrencelink', topic='$topic', notes='$notes', ihome='$ihome', alanguage='$alanguage', acomm='$acomm', `hotnews`='$hotnews', associated='$associated',tags='$tag_ids',approved='1',section='$section' where sid='$sid'");
			if(!$result) die(mysql_error());
		
			}


			Header("Location: ".$admin_file.".php?op=ShowNewsPanel");
		}
	}

	function postAdminStory($story_id,$automated, $year, $day, $month, $hour, $min, $subject, $hometext,$bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $hotnews, $pollTitle, $optionText, $assotop,$tags,$section) {
		global $aid, $prefix, $db, $admin_file, $module_name,$tag;
		//@
		for ($i=0; $i<sizeof($assotop); $i++) {
			$associated .= "$assotop[$i]-";
		}
		if ($automated == 1) {
			if ($day < 10) {
				$day = "0$day";
			}
			if ($month < 10) {
				$month = "0$month";
			}
			$sec = "00";
			$hejri_temp = "$year-$month-$day";
			$hejri_temp = hejriback($hejri_temp, 2, 2);
			$date = "$hejri_temp $hour:$min:$sec";
		} else {
			$date = date("Y-m-j H:i:s");
		}
		$catid = intval($catid);
		$subject = strip_tags($subject);
		
		$hometext = addslashes($hometext);
		$bodytext = addslashes($bodytext);
		//@
		$newsrefrence = strip_tags($newsrefrence);
		$newsrefrencelink = strip_tags($newsrefrencelink);
		//@
		$topic = intval($topic);
		// tagging system By James
		$tags = strip_tags($tags);
		//------------------------
		$notes = addslashes(check_words(check_html($notes, "nohtml")));
		$ihome = intval($ihome);
		$alanguage = check_html($alanguage, "nohtml");
		$acomm = intval($acomm);
		//@
		$hotnews = intval($hotnews);
		//@
		$associated = check_html($associated, "nohtml");
		if ((!empty($pollTitle)) AND (!empty($optionText[1])) AND (!empty($optionText[2]))) {
			$haspoll = 1;
			$timeStamp = time();
			$pollTitle = check_words(check_html(addslashes($pollTitle), "nohtml"));
			$db->sql_query("INSERT INTO ".$prefix."_poll_desc (`pollID`,`pollTitle`,`timeStamp`,`voters`,`planguage`,`artid`,`comments`,`active`) VALUES (NULL, '$pollTitle', '$timeStamp', '0', '$alanguage', '0', '0','1')")or die(mysql_error());
			list($id) = $db->sql_fetchrow($db->sql_query("SELECT pollID FROM ".$prefix."_poll_desc WHERE pollTitle='$pollTitle'"));
			$id = intval($id);
			for($i = 1; $i <= sizeof($optionText); $i++) {
				if(!empty($optionText[$i])) {
					$optionText[$i] = FixQuotes($optionText[$i]);
				}
$db->sql_query("INSERT INTO ".$prefix."_poll_data (pollID, optionText, optionCount, voteID) VALUES ('$id', '$optionText[$i]', '0', '$i')")or die(mysql_error());
			}
		} else {
			$haspoll = 0;
			$id = 0;
		}

// USV BUILD 9 -- Tags -- This is the power of OOP
		$tag->add_tags($tags);
		$tag_ids = $tag->get_tag_ids($tags);

		
//-------------Draft Check : if exists just update it
		

if (!empty($story_id)) {
$result = $db->sql_query("update ".$prefix."_stories set catid='$catid', aid='$aid', title='$subject', time='$date', hometext='$hometext', bodytext='$bodytext', newsref='$newsrefrence', newsreflink='$newsrefrencelink', topic='$topic',informant='$aid',notes='$notes', ihome='$ihome', alanguage='$alanguage', acomm='$acomm', associated='$associated',tags='$tag_ids',approved='1',section='$section' where sid='$story_id'");
if (!$result) {show_error("Problem in publishing draft post : <br> It may bacause of MYSQL ERROR <br>".mysql_error()." ");
}
}else {
$result = $db->sql_query("insert into ".$prefix."_stories values (NULL, '$catid', '$aid', '$subject', '$date', '$hometext', '$bodytext', '$newsrefrence', '$newsrefrencelink', '0', '0', '$topic', '$aid', '$notes', '$ihome', '$alanguage', '$acomm', '$hotnews', '$haspoll', '$id', '$associated','$tag_ids','1','$section')");
}		

		//@
		$result = $db->sql_query("select sid from ".$prefix."_stories WHERE title='$subject' order by time DESC limit 0,1");
		list($artid) = $db->sql_fetchrow($result);
		$artid = intval($artid);
		$db->sql_query("UPDATE ".$prefix."_poll_desc SET artid='$artid' WHERE pollID='$id'");
		if (!$result) {
			exit();
		}
		$result = $db->sql_query("update ".$prefix."_authors set counter=counter+1 where aid='$aid'");
	
		Header("Location: ".$admin_file.".php?op=ShowNewsPanel");

	}



	function subdelete() {
		global $prefix, $db, $admin_file;
		$db->sql_query("delete from ".$prefix."_queue");
		Header("Location: ".$admin_file.".php?op=ShowNewsPanel");
	}

	//@

	if (!isset($ok)) { $ok = ""; }
	if (!isset($sid)) { $sid = ""; }
	if (!isset($assotop)) { $assotop = Array(); }


	switch($op) {

		case "subdelete":
			subdelete();
			break;
	
		case "DisplayStory":
			displayStory($qid);
			break;

		case "PreviewAgain":
			previewStory($automated, $year, $day, $month, $hour, $min, $qid, $uid, $author, $subject, $hometext, $bodytext, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop,$tags,$section);
			break;

		case "PostStory":
			postStory($automated, $year, $day, $month, $hour, $min, $qid, $uid, $author, $subject, $hometext, $bodytext, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $pollTitle, $optionText, $assotop,$tags,$section);
			break;

		case "RemoveStory":
			removeStory($sid, $ok);
			break;

		case "ChangeStory":
			changeStory($automated, $year, $day, $month, $hour, $min,$sid, $subject, $hometext, $bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $hotnews, $assotop,$tags,$section);
			break;

		case "DeleteStory":
			deleteStory($qid);
			break;

		case "PostAdminStory":
		if($_POST['PreviewAdminStory']){
			previewAdminStory($automated, $year, $day, $month, $hour, $min, $subject, $hometext, $bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $hotnews, $pollTitle, $optionText, $assotop,$tags,$section);}else{
			postAdminStory($story_id,$automated, $year, $day, $month, $hour, $min, $subject, $hometext,  $bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm, $hotnews, $pollTitle, $optionText, $assotop,$tags,$section);}
			break;

		case "autoDelete":
			autodelete($anid);
			break;

		case "autoEdit":
			autoEdit($anid);
			break;

		case "autoSaveEdit":
			autoSaveEdit($anid, $year, $day, $month, $hour, $min, $title, $hometext,  $bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $catid, $ihome, $alanguage, $acomm);

			break;


		case "multi_task":
			include_once("modules/News/admin/includes/multi_tasks.php");
			break;
			
		case "adminStory":
			include_once("modules/News/admin/includes/adminstory.php");
			break;
						
		case "q_editstory":
			include_once("modules/News/admin/includes/quickedit.php");
			break;
						
		case "EditStory":
			include_once("modules/News/admin/includes/editstory.php");
			break;
			
		case "submissions":
			include_once("modules/News/admin/includes/submission.php");
			break;

		case "ShowNewsPanel":
			include_once("modules/News/admin/includes/newspanel.php");
			break;
			
		case "autosave":
			global $tag ; 
			include_once("modules/News/admin/includes/autosave.php");
			break;
			
		case "save_q_t_a":
			save_q_t_a ();
			break;
	}

} else {

	show_error("You do not have administration permission for module $module_name");
}

?>