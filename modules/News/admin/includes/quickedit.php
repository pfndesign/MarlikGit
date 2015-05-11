<?php

/**
*
* @package Admin_Story														
* @version $Id: adminstory.php beta0.5   12/24/2009  5:51 PM  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
$sid = sql_quote(intval($sid));
if (!empty($sid)) {	
	

		//@
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

			

			//@
			$result = $db->sql_query("SELECT catid, title,time, hometext,bodytext, newsref, newsreflink, topic, notes, ihome, alanguage, acomm, hotnews,section FROM ".$prefix."_stories where sid='$sid'");
			list($catid, $subject,$time, $hometext,$bodytext, $newsrefrence, $newsrefrencelink, $topic, $notes, $ihome, $alanguage, $acomm, $hotnews,$section) = $db->sql_fetchrow($result);
			//@
			$catid = intval($catid);
			$subject = stripslashes(check_words(check_html($subject, "nohtml")));

			
			$newsrefrence = stripslashes(check_words(check_html($newsrefrence, "nohtml")));
			$newsrefrencelink = stripslashes(check_words(check_html($newsrefrencelink, "nohtml")));

			$topic = intval($topic);
			$subject = check_html($subject, "nohtml");
			$hometext = stripslashes($hometext);


			$newsrefrence = check_html($newsrefrence, "nohtml");
			$newsrefrencelink = check_html($newsrefrencelink, "nohtml");

			$notes = stripslashes($notes);
			$ihome = intval($ihome);
			$acomm = intval($acomm);

			$hotnews = intval($hotnews);

			$result2=$db->sql_query("select topicimage from ".$prefix."_topics where topicid='$topic'");
			list($topicimage) = $db->sql_fetchrow($result2);



			//*--------story category ------------------

			$newscategory ="<br><b>"._TOPIC."</b>  ";
			/*$toplist = $db->sql_query("select topicid, topicname from ".$prefix."_topics order by topictext");
			$newscategory .= "<select name=\"topic\">"
			. "<option value=\"\">"._ALLTOPICS."</option>\n";
			while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
				$topicid = intval($topicid);
				$topics = check_html($topics, "nohtml");
				if ($topicid==$topic) { $sel = "selected "; }
				$newscategory .= "<option $sel value=\"$topicid\">$topics</option>\n";
				$sel = "";
			}
			$newscategory .= "</select> <a href='$admin_file.php?op=topicsmanager'><img src='images/add.gif' alt='Add Topic'  title='Add Topic'></a> <br>";
			*/
			$asql = "SELECT associated FROM ".$prefix."_stories WHERE sid='$sid'";
			$aresult = $db->sql_query($asql);			
			$arow = $db->sql_fetchrow($aresult);
			$asso_t = explode("-", $arow[associated]);

			$sql = "SELECT topicid, topicname FROM ".$prefix."_topics ORDER BY topictext";
			$result = $db->sql_query($sql);
			
			$numcat = $db->sql_numrows($result);
			if ($numcat >5) {
			$overflow =  "height:170px;overflow:auto";
			}
		
			$newscategory .= "<b>"._ASSOTOPIC."</b><br><div style='$overflow;direction:rtl;text-align:right;color:black;padding:10px;'>";

			
			while ($row = $db->sql_fetchrow($result)) {
				$row['topicid'] = intval($row['topicid']);
				$row['topicname'] = check_html($row['topicname'], "nohtml");
				if ($a == 1) {
					$newscategory .= "<br>";
					$a = 0;
				}
				for ($i=0; $i<sizeof($asso_t); $i++) {
					if ($asso_t[$i] == $row['topicid']) {
						$checked = "CHECKED";
						break;
					}
				}

	$newscategory .= "<div id=\"display\"></div>";
				$newscategory .= "<input type='checkbox' name='assotop[]' value='".intval($row['topicid'])."' $checked>".$row['topicname']."";
				$checked = "";
				$a++;

			}
			$newscategory .= "<br></div>";
			$cat = $catid;

			//*--------language ------------------

			if ($multilingual == 1) {
				$newslanguage = "<br><b>"._LANGUAGE.":</b>&nbsp;"
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
						$newslanguage .= "<option name=\"alanguage\" value=\"$languageslist[$i]\" ";
						if($languageslist[$i]==$alanguage) $newslanguage .= "selected";
						$newslanguage .= ">".ucfirst($languageslist[$i])."\n</option>";
					}
				}
				if (empty($alanguage)) {
					$sellang = "selected";
				} else {
					$sellang = "";
				}
				$newslanguage .= "<option value=\"\" $sellang>"._ALL."</option></select>";
			} else {
				$newslanguage .= "<input type=\"hidden\" name=\"alanguage\" value=\"\">";
			}


			//*--------story reference ------------------

			$reference = "<b>"._NEWSREFRENCE."</b><br>"
			."<input type=\"text\" name=\"newsrefrence\" size=\"50\"  value=\"$newsrefrence\"><br><br>"
			."<b>"._NEWSREFRENCELINK."</b><br>"
			."<input dir='ltr' type=\"text\" name=\"newsrefrencelink\" size=\"50\"  value=\"$newsrefrencelink\">";


			//*--------Progamming Story ------------------
			$programstory ="<b>"._PROGRAMSTORY."</b><br>";

			
		    $date = date("Y-m-j H:i:s");

			
			if ($time > $date) {
			$prochecked = 'checked="checked"';
			}else {
			$not_prochecked = 'checked="checked"';
			$display_none='style="display:none"';
			}

			
 $programstory .='<input name="automated" type="radio" value="1" onclick="document.getElementById(\'prost\').style.display= \'\';" '.$prochecked.'/>'._YES.'
  <input name="automated" type="radio" value="0" onclick="document.getElementById(\'prost\').style.display= \'none\';" '.$not_prochecked.' />'._NO.'<br>';
 

    		$programstory .="<span id='prost' $display_none>"._NOWIS.": ".hejridate($date, 4, 7)."<br><br>";	
    		$date = hejridate($date, 1, 8);    				
			$ctime = explode("-",$time);
			$val1 = explode(" ",$ctime[2]);
			$val = explode(":",$val1[1]);
			$ctime = hejridate("$ctime[0]-$ctime[1]-$val1[0]",1,8);
			$ctime = explode("-",$ctime);
			$day = 1;
			$month = 1;
			$programstory .= ""._DAY." : ";
			$programstory .= get_hejri_day(intval($ctime[1]), "day", intval($ctime[2]));
			$programstory .= ""._UMONTH." : ";
			$programstory .= get_hejri_month("month", intval($ctime[1]));
			$date_temp = explode("-", $date);
			$year = $date_temp[0];
			$programstory .= ""._YEAR.": <input type=\"text\" dir=\"ltr\" name=\"year\" value=\"$year\" size=\"5\" maxlength=\"4\">"
			."<br><br>"._HOUR.": <select name=\"hour\">";
			$hour = 0;
			$cero = "0";
			while ($hour <= 23) {
				$dummy = $hour;
				if ($hour < 10) {
					$hour = "$cero$hour";
				}
				if($hour == $val[0]){
					$selected = "SELECTED";}else{$selected="";}
					$programstory .= "<option $selected name=\"hour\">$hour</option>";
					$hour = $dummy;
					$hour++;
			}
			$programstory .= "</select>"
			.": <select name=\"min\">";
			$min = 0;
			while ($min <= 59) {
				if (($min == 0) OR ($min == 5)) {
					$min = "0$min";
				}
				if($min <= $val[1] && $min+5 > $val[1]){
					$selected = "SELECTED";}else{$selected="";}
					$programstory .= "<option $selected name=\"min\">$min</option>";
					$min+=5;
			}
			$programstory .= "</select>";
			$programstory .= ": 00<br><br>";

			//*--------Choosing Section ------------------

			if ($section = "news") {
			$optionvalue ="<option value=\"news\">"._STORY_NEWS."</option><option value=\"message\">"._STORY_ADMIN_MESSAGE."</option>";
			}else {
			$optionvalue ="<option value=\"message\">"._STORY_ADMIN_MESSAGE."</option><option value=\"news\">"._STORY_NEWS."</option>";
			}

			$storysection = ""._STORY_SECTION_SELECT." : "
			."<select  name=\"section\">"
			."$optionvalue"
			."</select><br><br>";
			//*--------Story Notes ------------------
			$newsnotes = "<b>"._NOTES."</b><br>"
			."<textarea  name=\"notes\" wrap=\"virtual\" cols=\"50\" rows=\"3\" >$notes</textarea>";


			//*--------Publishing Setting ------------------
			$publishnews ="<div style='text-align:center;'>
			<input type='hidden' name='sid'  value='$sid'>
			<input type='hidden' name='op' value='ChangeStory'>
			<input type='submit' value='"._SAVECHANGES."'></div>";


			echo "<table width='900px' height='200px' align='center'><tr><td style='width:30%;vertical-align:top;padding:5px;'>";


			validate_field('news','subject','عنوان خبر را فراموش کردید !');
			//validate_field('news','hometext','متن خبر خود را فراموش کردید');
			//---
			
			echo"<form name='news' onSubmit=\"return validateForm(news);\" action=\"".$admin_file.".php\" method=\"post\" style='padding:8px;'>";

			OpenTable();
			

			
			echo"<b>"._TITLE."</b><br>"
			."<input type=\"text\" name=\"subject\" size=\"40\" value=\"$subject\" ><br>";
			
			admin_block($newsnotes);
			admin_block($programstory);		
			//admin_block($newslanguage);
			
			echo "</td><td style='width:35%;vertical-align:top;'>";

			//SelectCategory($cat);
			admin_block($newscategory);

			echo "</td><td style='width:35%;vertical-align:top;'>";
			
			puthome($ihome, $acomm, $hotnews);
			admin_block($storysection.'<br>'.$publishnews);
			//admin_block($reference);


			
			echo "</td>";

			echo "</dt></tr></table>";

			echo "<br></form>";

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
	}else {
		show_error(HACKING_ATTEMPT);
	}
	
			
?>