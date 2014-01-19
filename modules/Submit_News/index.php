<?php
if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}

require_once("mainfile.php");
define('blocks_show', true);
$module_name = basename(dirname(__FILE__));

get_lang($module_name);
$pagetitle = "- "._SUBMITNEWS."";

function defaultDisplay() {
	global $AllowableHTML, $prefix, $user, $cookie, $anonymous, $currentlang, $multilingual,$userinfo, $db, $module_name;
	include ('header.php');
	OpenTable();
	echo "<center><font class=\"title\"><b>"._SUBMITNEWS."</b></font><br><br>";
	echo "<font class=\"content\"><i>"._SUBMITADVICE."</i></font></center><br>";
	CloseTable();
	echo "<br>";
	OpenTable();
	if (is_user($user)) getusrinfo($user);
	echo "<p><form action=\"modules.php?name=$module_name\" method=\"post\">"
	."<b>"._YOURNAME.":</b> ";
	if (is_user($user)) {
		cookiedecode($user);
		echo "<a href=\"modules.php?name=Your_Account\">$cookie[1]</a> <font class=\"content\">[ <a href=\"modules.php?name=Your_Account&amp;op=logout\">"._LOGOUT."</a> ]</font>";
	} else {
		echo "$anonymous <font class=\"content\">[ <a href=\"modules.php?name=Your_Account\">"._NEWUSER."</a> ]</font>";
	}
	echo "<br><br>"
	."<b>"._SUBTITLE."</b> "
	."("._BEDESCRIPTIVE.")<br>"
	."<input type=\"text\" name=\"subject\" size=\"50\" maxlength=\"80\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(subject)><br><font class=\"content\">("._BADTITLES.")</font>"
	."<br><br>";

	
//*--------story category ------------------
define("TOPIC_TABLE","".$prefix."_topics");
require_once("includes/inc_menuBuilder.php");
$newscategory ="<br><b>"._TOPIC."</b>  ";
$menu = new MenuBuilder();
/*---------------MENU CONFIG -----------*/
$sql = 'select * from '.TOPIC_TABLE.' order by topicname,parent asc limit 500';
$column_ID = 'topicid';
$column_TITLE = 'topicname';
$column_parent = 'parent';
$ui_id = 'Scategories';
/*--------------------------------------*/
$newscategory  .= $menu->get_menu_data($sql,$link,$column_ID,$column_parent,$column_TITLE,$ui_id,'','checkbox');
$newscategory  .= $menu->get_menu_html(0);

	global $currentlang;
	echo  "\n".'<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview'.($currentlang=="persian" ? ".rtl" : "").'.css" />'. "\n";
?>	<script src="modules/Topics/includes/jquery.treeview.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#Scategories").treeview({
			animated: "fast",
			persist: "location",
			collapsed: true,
			unique: true
		});
	});
	</script>
<?php
	echo $newscategory;



	if ($multilingual == 1) {
		echo "<br><br><b>"._LANGUAGE.": </b>"
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
				if($languageslist[$i]==$currentlang) echo "selected";
				echo ">".ucfirst($languageslist[$i])."</option>\n";
			}
		}
		echo "</select>";
	} else {
		echo "<input type=\"hidden\" name=\"alanguage\" value=\"$language\">";
	}
	echo "<br><br>"
	."<b>"._STORYTEXT.":</b><br>";

	//"<textarea name=\"story\" cols=\"60\" rows=\"20\" style=\"width:100%\"></textarea>"
	wysiwyg_textarea('story', '', 'PHPNuke', '50', '12');

	echo "<br><br><br><br><br><b>"._EXTENDEDTEXT.":</b><br>";

	//."<textarea name=\"storyext\" cols=\"60\" rows=\"20\" style=\"width:100%\"></textarea>
	wysiwyg_textarea('storyext', '', 'PHPNuke', '50', '12');
		
	echo "<input type=\"hidden\" name=\"authorname\" value=\"".$userinfo[username]."\">";
	echo "<br><br><br>"
	."<font class=\"content\">("._AREYOUSURE.")<br><br>"
	."<br><br><input type=\"submit\" name=\"op\" value=\""._PREVIEW."\"><br>("._SUBPREVIEW.")</font></form>";


	CloseTable();
	include ('footer.php');
}

function PreviewStory($authorname, $address, $subject, $story, $storyext, $topic, $alanguage,$assotop) {
	global $user, $cookie,$anonymous,$userinfo, $prefix, $multilingual, $AllowableHTML, $db, $module_name,$gfx_chk;
	include ('header.php');
	$f_story = check_html($story, "");
	$f_storyext = check_html($storyext, "");
	$subject = check_words(check_html(addslashes(FixQuotes($subject)), "nohtml"));
	$story2 = "$f_story<br><br>$f_storyext";
	OpenTable();
	echo "<center><font class=\"title\"><b>"._NEWSUBPREVIEW."</b></font>";
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<center><i>"._STORYLOOK."</i></center><br><br>";
	echo "<table width=\"70%\"cellpadding=\"0\" cellspacing=\"1\" border=\"0\"align=\"center\"><tr><td>"
	."<table width=\"100%\" cellpadding=\"8\" cellspacing=\"1\" border=\"0\"><tr><td>";

	echo "<img src=\"images/topics/$topicimage\" border=\"0\" align=\"right\" alt=\"".$row['topictext']."\" title=\"".$row['topictext']."\">";
	themepreview($subject, $story2);
	echo "$warning"
	."</td></tr></table></td></tr></table>"
	."<br><br><center><font class=\"tiny\">"._CHECKSTORY."</font></center>";
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<p><form action=\"modules.php?name=$module_name\" method=\"post\">"
	."<b>"._YOURNAME.":</b> ";
	if (is_user($user)) {
		cookiedecode($user);
		echo "<a href=\"modules.php?name=Your_Account\">$cookie[1]</a> <font class=\"content\">[ <a href=\"modules.php?name=Your_Account&amp;op=logout\">"._LOGOUT."</a> ]</font>";
	} else {
		echo "$anonymous";
	}
	echo "<br><br><b>"._SUBTITLE.":</b><br>"
	."<input type=\"text\" name=\"subject\" size=\"50\" maxlength=\"80\" value=\"$subject\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(subject)>";


//*--------story category ------------------
define("TOPIC_TABLE","".$prefix."_topics");
for ($i=0; $i<sizeof($assotop); $i++) {
	$associated .= "".$assotop[$i]."-";
}
require_once("includes/inc_menuBuilder.php");
$newscategory ="<br><b>"._TOPIC."</b>  ";
$menu = new MenuBuilder();
/*---------------MENU CONFIG -----------*/
$sql = 'select * from '.TOPIC_TABLE.' order by topicname,parent asc limit 500';
$column_ID = 'topicid';
$column_TITLE = 'topicname';
$column_parent = 'parent';
$ui_id = 'Scategories';
/*--------------------------------------*/
$newscategory  .= $menu->get_menu_data($sql,$link,$column_ID,$column_parent,$column_TITLE,$ui_id,$associated,'checkbox');
$newscategory  .= $menu->get_menu_html(0);

	global $currentlang;
	echo  "\n".'<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview'.($currentlang=="persian" ? ".rtl" : "").'.css" />'. "\n";
?>	<script src="modules/Topics/includes/jquery.treeview.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#Scategories").treeview({
			animated: "fast",
			persist: "location",
			collapsed: true,
			unique: true
		});
	});
	</script>
<?php
	echo $newscategory;
	
	
	if ($multilingual == 1) {
		echo "<br><br><b>"._LANGUAGE.": </b>"
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
		echo "</select>";
	}
	echo "<br><br><b>"._STORYTEXT.":</b><br>";

	//."<textarea  name=\"story\" cols=\"60\" rows=\"15\" style=\"width:100%\">$f_story</textarea>"
	wysiwyg_textarea('story', $f_story, 'PHPNuke', '50', '12');

	echo "<br><br><br><br><b>"._EXTENDEDTEXT.":</b><br>";

	//."<textarea  name=\"storyext\" cols=\"60\" rows=\"40\" style=\"width:100%\">$f_storyext</textarea>"
	wysiwyg_textarea('storyext', $f_storyext, 'PHPNuke', '50', '12');


	if (extension_loaded("gd") AND ($gfx_chk == 7)) {
	echo show_captcha();
	}
	echo "<input type=\"hidden\" name=\"authorname\" value=\"".$userinfo[username]."\">";
	
	echo "<br><br><br><font class=\"content\">("._AREYOUSURE.")</font><br><br>"
	.""._HTMLNOTALLOWED.""
	."<br><br>"
	."<a href='modules.php?name=Submit_News'><img src='images/icon/arrow_undo.png'>لغو ارسال</a>&nbsp;&nbsp;"
	."<input type=\"submit\" name=\"op\" value=\""._OK."\"></form>";
	CloseTable();
	include ('footer.php');
}

function submitStory($authorname, $address, $subject, $story, $storyext, $topic, $alanguage,$assotop) {
	global $user,$EditedMessage, $cookie, $anonymous, $notify, $notify_email, $notify_subject, $notify_message, $notify_from, $prefix, $db,$gfx_chk;

		$userwaitingstory = $db->sql_numrows($db->sql_query("SELECT sid FROM ".$prefix."_stories WHERE approved = '2' AND informant='$authorname'"));

		if ($userwaitingstory > 5) {
			show_error("
			<div class='error'>
			شما بیش از 5 خبر منتظر تایید دارید . بهتر است صبور باشید و با مدیر سایت تماس بگیرید.
			</div>
			");
		}
		
	if (extension_loaded("gd") AND $gfx_chk == 7 AND !check_captcha()){
		$wrong_code = true;
        header('Location: modules.php?name=Submit_News');
        die();
		}
	
		
	if( (!count($_POST) > 0)){show_error(RU_ROBOT);}

	if (is_user($user)) {
		cookiedecode($user);
		$uid = $cookie[0];
		$authorname = $cookie[1];
	} else {
		$uid = 1;
		$authorname = "$anonymous";
	}

if (empty($subject) AND empty($story)  AND empty($storyext) ) {
	show_error("مقادیر اصلی را کامل پر کنید");
}
	$subject = check_words(check_html(sql_quote($subject), "nohtml"));
	$story = check_words(sql_quote($story), "nohtml");
	$storyext = check_words(sql_quote($storyext), "nohtml");

		for ($i=0; $i<sizeof($assotop); $i++) {
			$associated .= "$assotop[$i]-";
		}
		$associated = sql_quote($associated);
	/*\--------------[ BEGIN: USV-Admin Submissions ]---------------\*/
$result = $db->sql_query("INSERT INTO ".$prefix."_stories
(sid,catid,aid,title,time,hometext,bodytext,newsref,newsreflink,comments,counter,topic,informant,notes,ihome,alanguage,acomm,hotnews,haspoll,pollID,associated,tags,approved,section) VALUES (NULL, '$catid', '', '$subject', now(), '$story', '$storyext', '','', '0', '0', '$topic', '$authorname', '', '', '$alanguage', '', '', '0', '0', '$associated','','2','news')")or show_error(_ERROR);


/*\--------------[ END: USV-Admin Submissions ]---------------\*/
	if($notify) {
		$notify_message = "$notify_message\n\n\n========================================================\n$subject\n\n\n$story\n\n$storyext\n\n$authorname";
		
		$notify_message = Mail_AddStyle($notify_message);
		@mail($notify_email, $notify_subject, $notify_message, "From: $notify_from\nContent-Type: text/html; charset=utf-8");
		
	}
	include ('header.php');
	OpenTable();
	$waiting = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_stories WHERE approved = '2'"));
	echo "<center><div class='success'><font class=\"title\">"._SUBSENT."</font><br><br>"
	."<font class=\"content\"><b>"._THANKSSUB."</b><br><br>"
	.""._SUBTEXT.""
	."<br>"._WEHAVESUB." $waiting "._WAITING."</div></center>";
	CloseTable();
	include ('footer.php');
}

if (!isset($address)) { $address = ""; }
if (!isset($alanguage)) { $alanguage = ""; }
if (!isset($op)) { $op = ""; }
if (!isset($posttype)) { $posttype = ""; }

switch($op) {

	case ""._PREVIEW."":
		PreviewStory($authorname, $address, $subject, $story, $storyext, $topic, $alanguage,$assotop);
		break;

	case ""._OK."":
		SubmitStory($authorname, $address, $subject, $story, $storyext, $topic, $alanguage,$assotop);
		break;

	default:
		defaultDisplay();
		break;

}

?>