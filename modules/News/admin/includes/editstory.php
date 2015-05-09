<?php

/**
*
* @package Admin_Story														
* @version $Id: adminstory.php beta0.5   12/24/2009  5:51 PM  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
$sid = sql_quote(intval($sid));
if (!empty($sid)) {	
	
		global $user,$aid, $prefix, $db, $multilingual, $admin_file, $module_name;
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
			include ('header.php');
			GraphicAdmin();
			echo "<center><h2><b>"._ARTICLEADMIN."&nbsp;--&nbsp;"._EDITARTICLE."</b></h2></center>";
			//@
			$result = $db->sql_query("SELECT catid, title,time, hometext,bodytext, newsref, newsreflink, topic, notes, ihome, alanguage, acomm, hotnews, tags,section,associated FROM ".$prefix."_stories where sid='$sid'");
			list($catid, $subject,$time, $hometext,$bodytext, $newsref, $newsreflink, $topic, $notes, $ihome, $alanguage, $acomm,$hotnews,$tags,$section,$associated) = $db->sql_fetchrow($result);
			//@
			$catid = intval($catid);
			$subject = stripslashes(check_words(check_html($subject, "nohtml")));
			
			$hometext = stripslashes(check_words($hometext));
			$bodytext = stripslashes(check_words($bodytext));
			
			//@
			$newsrefrence = stripslashes(check_words(check_html($newsref, "nohtml")));
			$newsrefrencelink = stripslashes(check_words(check_html($newsreflink, "nohtml")));
			//@
			$topic = intval($topic);
			$subject = check_html($subject, "nohtml");
			//@

			$notes = stripslashes($notes);
			$ihome = intval($ihome);
			$acomm = intval($acomm);
			//@
			$hotnews = intval($hotnews);
			//@
			/*$result2=$db->sql_query("select topicimage from ".$prefix."_topics where topicid='$topic'");
			list($topicimage) = $db->sql_fetchrow($result2);
			OpenTable();
			echo "<div style='height:230px;overflow:auto;text-align:center;'>
			<table width=\"80%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"$bgcolor2\" ><tr><td>"
			."<table width=\"100%\" border=\"0\" cellpadding=\"8\" cellspacing=\"1\" bgcolor=\"$bgcolor1\"><tr><td>"
			."<img src=\"images/topics/$topicimage\" border=\"0\" align=\"right\">";

			themepreview($subject, $hometext,$bodytext, $newsrefrence, $newsrefrencelink, $notes);
			echo "</td></tr></table></td></tr></table></div><br><br>";

			CloseTable();
			**/
			
			echo "<table width='100%'><tr><td style='width:70%;vertical-align:top;padding:5px;'>";

			//*--------story validation ------------------
			validate_field('news','subject',_ARTICLE_TITLE_EMPTY);
			//---
			
			OpenTable();
			echo"<form name=\"news\" onSubmit=\"return validateForm(news);\" action=\"".$admin_file.".php\" method=\"post\" style='padding:8px;'>";


			//*--------story textareas ------------------
			echo"<b>"._TITLE."</b><br>"
			."<input type=\"text\" name=\"subject\" size=\"50\" 
			style='font-size:17px;font-family:arial;padding:4px;width:500px;border:1px solid #fff'
			value=\"$subject\" ><br><br>"
			. "<br><br><b>"._STORYTEXT."</b><br>";
			//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"hometext\" style=\"width:100%\"></textarea>"
			wysiwyg_textarea("hometext", "$hometext", "PHPNukeAdmin", "50", "20");

			echo "<br><br><b>"._EXTENDEDTEXT."</b><br>";
			//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"bodytext\" style=\"width:100%\"></textarea>"
			wysiwyg_textarea("bodytext", "$bodytext", "PHPNukeAdmin", "50", "20");

			comments_moderated("0",$sid);

			//*--------story category ------------------
		
			define("TOPIC_TABLE","".$prefix."_topics");
			require_once("includes/inc_menuBuilder.php");
			$newscategory ="<br><b>"._TOPIC."</b>  ";
			$menu = new MenuBuilder();
			/*---------------MENU CONFIG -----------*/
			$sql = 'select * from '.TOPIC_TABLE.' order by topicname,parent asc';
			$conndition = "WHERE sid='$sid'";
			$column_ID = 'topicid';
			$column_TITLE = 'topicname';
			$column_parent = 'parent';
			$ui_id = 'categories';

			/*--------------------------------------*/
			$newscategory  .= $menu->get_menu_data($sql,$link,$column_ID,$column_parent,$column_TITLE,$ui_id,$associated,'checkbox');
			$newscategory  .= $menu->get_menu_html(0);
		?>
		<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview.rtl.css" />
	<script src="modules/Topics/includes/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="modules/Topics/includes/jquery.treeview.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#categories").treeview({
			animated: "fast",
			persist: "location",
			collapsed: true,
			unique: true
		});
	});
	</script>
		<?php

		$newscategory .= "<br><a href='javascript:#add_topic_' onclick='document.getElementById(\"add_box\").style.display= \"\";'>
		<img src='images/add.gif' alt='"._ADDTOPIC."'  title='"._ADDTOPIC."'> + "._ADDTOPIC."
		</a>
		<div id='add_box' style='display:none' ><br>".quick_topic_add()."</div>";


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




			//*--------story tags ------------------


			$tag = new Tags;
			$newstags = ""._TAGS."".$tag->input_tags('tags',$tags);
			

			//*--------Progamming Story ------------------
			$programstory ="<b>"._PROGRAMSTORY."</b><br>";

			
			$date = date("Y-m-d g:i:s");

			if ($time < $date) {
			$not_prochecked = 'checked="checked"';$display_none='style="display:none"';
			}else {
			$prochecked = 'checked="checked"';
			}
			$Nowdate = hejridate($date, 4, 6);    			
			$date = hejridate($date, 1, 8);    			
			
 $programstory .='<input name="automated" type="radio" value="1" onclick="document.getElementById(\'prost\').style.display= \'\';" '.$prochecked.'/>'._YES.'
  <input name="automated" type="radio" value="0" onclick="document.getElementById(\'prost\').style.display= \'none\';" '.$not_prochecked.' />'._NO.'<br>';
 

    		$programstory .="<span id='prost' $display_none>"._NOWIS.": $Nowdate<br><br>";			
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
			$programstory .= ": 00<br><br></span>";


			//*--------Choosing Section ------------------

			if ($section == "news") {
			$SelSec = "selected";
			$SelSec2 = "";
			}elseif ($section == "message"){
			$SelSec2 = "selected";
			$SelSec = "";
			}else {
			$SelSec = "";
			}
			$storysection = "<br><br>"._STORY_SECTION_SELECT." : "
			."<select  name=\"section\">
			<option value=\"news\" $SelSec >"._STORY_NEWS."</option>
			<option value=\"message\" $SelSec2>"._STORY_ADMIN_MESSAGE."</option>
			</select><br><br>";

			//*--------Story Notes ------------------
			$newsnotes = "<b>"._NOTES."</b><br>"
			."<textarea  name=\"notes\" wrap=\"virtual\" cols=\"40\" rows=\"3\" >$notes</textarea>";


			//*--------Publishing Setting ------------------
			$publishnews ="<div style='text-align:center;'>"
			."<input type=\"hidden\" NAME=\"sid\" size=\"50\" value=\"$sid\">"
			."<input type=\"hidden\" name=\"op\" value=\"ChangeStory\"><div>"
			."<input type=\"submit\" value=\""._SAVECHANGES."\"></div>";


			CloseTable();


			//-------- sider for plugins -----------//

			echo "</td><td style='width:25%;vertical-align:top;'>";


			OpenTable();
			puthome($ihome, $acomm, $hotnews);
			admin_block($storysection);
			admin_block($programstory);			
			admin_block($publishnews);
			//SelectCategory($cat);
			admin_block($newscategory);
			admin_block($newslanguage);
			admin_block($newstags);
			admin_block($reference);
			admin_block($newsnotes);


			CloseTable();

			echo "</dt></tr></table>";
			echo "<br></form>";
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
	}else {
		show_error(HACKING_ATTEMPT);
	}
	
			
?>