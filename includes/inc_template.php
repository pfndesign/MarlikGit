<?php
/**
 *
 * @package Template Englin system
 * @version  inc_template.php $Id: 1.1.4 $Aneeshtan	7:08 PM 2/23/2011
 * @copyright (c)Marlik Group  http://www.nukelearn.com
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_template.php" )) {
	show_error ( HACKING_ATTEMPT );
}

/*\------------------[ VARS]-----------------------\*/
global
$userinfo,
$admin,
$ThemeSel,
$banners,
$slogan,
$anonymous,
$te_page,
$user,
$currentlang;

define("THEME_PATH","themes/$ThemeSel/") ;
$templateUrl = "themes/$ThemeSel";
define("RATING_INC",true);
define("TAGS_IN",true);
$theme_file_prefix = ((defined('THEME_FILES_PREFIX')) ? ".".THEME_FILES_PREFIX : ".html");
define("T_PREFIX","$theme_file_prefix");
if (RATING_INC == true) {
	include(MODS_PATH."rating/inc_ratings.php");
}

//===========================================
//Theme Engine Functions
//===========================================
function CheckThemeValidity(){
	global $ThemeSel;
	if (file_exists(THEME_PATH."table.inc") AND file_exists(THEME_PATH."theme.php") ) {
		show_error(_FUNCTION_MAIN_FILE_DUPLICATED."<br>"._THEME." : <b>$ThemeSel</b><br>"._FILE." : <b>table.inc</b><br>"._FILE." : <b>theme.php</b><br>");
	}
	if (!file_exists(THEME_PATH."table.inc") AND !file_exists(THEME_PATH."theme.php") ) {
		show_error(_FUNCTION_MAIN_FILE_NOT_EXISTS."<br>"._THEME." : <b>$ThemeSel</b><br>");
	}

	//===========================================
	//Theme Engine OLD table.inc FILE
	//===========================================
	if (!defined("ADMIN_FILE") AND !defined('FORUM_ADMIN')) {
		if (file_exists(THEME_PATH."table.inc")) {
			include_once(THEME_PATH."table.inc");
		}
	}

}
//===========================================
// CHECK VALIDITY OF A THEME
//===========================================
CheckThemeValidity();
// OUR MAIN GOAL IS TO HAVE A FULL CONTROL OVER OUR THEME. LETS SEE IF WE CAN DO SO .

//----------------//CAPTCHA SYSTEM//------------------------+
if (extension_loaded("gd") AND ($ya_config['usegfxcheck'] == 1 OR $ya_config['usegfxcheck'] == 3)) {
	$captcha = "<div>".show_captcha()."</div>";
}

$date = time();
$Miladidate = date(' jS \of F Y ');
$shamsidate = hejridate($date[0],1);
$SmartDate = ($currentlang == "persian") ? $shamsidate : $Miladidate;//SMART DATE
$mysitelogo = (file_exists($site_logo) ? $site_logo : THEME_PATH."logo.png" );//LOGO
$username = $userinfo[username];

if (is_user($user)) {
	$theuser = "<a href='modules.php?name=Your_Account&amp;op=userinfo&amp;username=$username' title='"._USERINFO."'>
	"._BWEL." <b>$username</b></a>";
}else {
	$theuser = " <a href=\"modules.php?app=mod&amp;name=navigation&amp;op=login\" class=\"colorbox\" title=\"\">"._LOGIN."</a>&nbsp;&nbsp;<a href=\"modules.php?name=Your_Account&amp;op=new_user\">"._BREG."</a>";
}
// Check new PM -------------------------------------
if (is_user($user))
{
	if (is_active('phpBB3')){

		$sql = "SELECT author_id  FROM ".$prefix."_bb3privmsgs_to WHERE user_id='".$userinfo['user_id']."' AND pm_unread='1' ";
		$result = $db->sql_query($sql);
		if ($db->sql_numrows($result) > 0)
		{
			$pm_notify="<div id='notify' ><img src='images/salert.png' title='"._ERROR."'><a href='messages.html'>"._NEWPM."</a></div>";
		}
		$db->sql_freeresult($result);
	}else

	// lets see if Mybb is installed

	if (file_exists("forums/inc/settings.php")) {

	 $result = $db->sql_query("SELECT `unreadpms` FROM `mybb_users` WHERE `username`='".$userinfo['username']."'");
        list($unreadpms) = $db->sql_fetchrow($result);
        if ($unreadpms > 0)
        {
            $pm_notify="<div id='notify' ><img src='images/icon/note.png' title='"._ERROR."'><a href='forums/private.php'>"._NEWPM."</a></div>";
        }
        $db->sql_freeresult($result);
	}

}
//--- BUILDING THEME ENGINE CORE STRUCTURE -------------
$te_page->Dir = THEME_PATH;
$te_page->name = $name;
$te_page->module = "modules.php?name=$name";
$te_page->captcha = $captcha;
$te_page->direction = langstyle(direction);
$te_page->align = langstyle(align);
$te_page->time = $SmartDate;
$te_page->sitelink = USV_DOMAIN;
$te_page->sitelogo = $mysitelogo;
$te_page->slogan = $slogan;
$te_page->sitename = $sitename;
$te_page->welcome = $theuser;
$te_page->PM = $pm_notify;

define("TEMPLATE_ENGINE_CONSTANTS_CORE",'Dir,name,captcha,module,direction,align,time,sitelink,sitelogo,sitename,slogan,sitelogo,welcome,PM,');


if (!empty($varnamelist)) {
	$vars_str = array();
	foreach ($varnamelist as $ct => $vl) {
		$te_page->$ct = $vl;$vars_str[] = $ct;
	}
	$vars_stri = implode(",", $vars_str);
	define("TEMPLATE_ENGINE_CONSTANTS_EX",','.$vars_stri.'');
}else {
	define("TEMPLATE_ENGINE_CONSTANTS_EX",'');
}

//===========================================
// BEGINING THEME FUNCTIONS
//===========================================
if (!function_exists(themeheader)) {
	function themeheader() {
		global $admin,$user,$banners, $sitename, $slogan, $db,$userinfo,$prefix,$site_logo, $anonymous,$name,$te_page,$currentlang;
		cookiedecode($user);

		$te_page->templatefile = THEME_PATH."header".T_PREFIX."";
		$te_page->public_msg = public_message();
		$te_page->ads_top = ads(0);
		$te_page->varnamelist = "".TEMPLATE_ENGINE_CONSTANTS_CORE."public_msg,ads_top".TEMPLATE_ENGINE_CONSTANTS_EX."";
		$te_page->displayContent($te_page->templatefile);

		if (file_exists(THEME_PATH."left_side".T_PREFIX."") && file_exists(THEME_PATH."left_side_end".T_PREFIX."")) {
			$tmpl_file = THEME_PATH."left_side".T_PREFIX."";
            $tmpl_file2 = THEME_PATH."left_side_end".T_PREFIX."";
			$thefile = implode("", file($tmpl_file));
            $thefile2 = implode("", file($tmpl_file2));
			$thefile = addslashes($thefile);
			$thefile = "\$r_file=\"".$thefile."\";";
			eval($thefile);
			print $r_file;
			if($name!=phpBB3 AND !defined("blocks_show")  AND !defined("hide_rside"))	{
				blocks(left);
			}
            print $thefile2;
		}else {
			?><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><?php
			if($name!=phpBB3 AND !defined("blocks_show")  AND !defined("hide_rside"))	{
				blocks(left);
			}
			?></td><td valign="top" width="100%"><?php
		}

	}
}
if (!function_exists(themesidebox)) {
	function themesidebox($title,$content,$side,$bid,$blockfile) {
		global $db,$prefix,$te_page;

		// CUSTOMIZE BLOCKS IF THERE IS A HTML VERSION
		$icb = empty($bid) ? $blockfile : $bid ;
		$filter = preg_replace("/block-/","", $blockfile);
		$filter = preg_replace("/.php/","", $filter);
		//LETS SEE IF THERE IS A HTML BLOCK FILE EQUAL TO THE BLOCK PHP FILE IN BLOCKS/
		if(file_exists(THEME_PATH."$filter.html")){
			$tmpl_file = THEME_PATH."$filter.html";
		}
		//LETS SEE IF BLOCKS' ID IS EQUAL TO THE ID OF THAT BLOCK/
		elseif(file_exists(THEME_PATH."$bid.html")){
			$tmpl_file = THEME_PATH."$bid.html";
		}
		// CUSTOMIZE SIDERS LEFT : RIGHT
		elseif($side=='l') {
			if (file_exists(THEME_PATH."right-blocks".T_PREFIX."")) {
				$tmpl_file = THEME_PATH."right-blocks".T_PREFIX."";
			}
		}elseif($side=='r') {
			if (file_exists(THEME_PATH."left-blocks".T_PREFIX."")) {
				$tmpl_file = THEME_PATH."left-blocks".T_PREFIX."";
			}
		}
		if (empty($tmpl_file)) {
			$tmpl_file = THEME_PATH."blocks".T_PREFIX."";
		}
		// SETTING TEMPLATE FILE
		$te_page->templatefile =  $tmpl_file ;
		$te_page->varnamelist = "".TEMPLATE_ENGINE_CONSTANTS_CORE."title,content,bid".TEMPLATE_ENGINE_CONSTANTS_EX."";
		$te_page->title = langit($title);
		$te_page->content = $content;
		$te_page->bid = $bid;
		$te_page->display($tmpl_file,$icb);
	}
}
if (!function_exists(themecenterbox)) {
	function themecenterbox($title, $content,$bid='',$blockfile='') {
		global $db,$prefix,$te_page;

		$filter = preg_replace("/block-/","", $blockfile);
		$filter = preg_replace("/.php/","", $filter);

		if (file_exists(THEME_PATH."$filter.html"))	{

			$tmpl_file = THEME_PATH."$filter.html";

		}elseif(file_exists(THEME_PATH."$bid.html")){

			$tmpl_file = THEME_PATH."$bid.html";

		}else{

			if (file_exists(THEME_PATH."center-blocks".T_PREFIX."")) {
				$tmpl_file = THEME_PATH."center-blocks".T_PREFIX."";
			}

		}

		if (!empty($tmpl_file)) {
			$icb = empty($bid) ? $blockfile : $bid ;
			$te_page->templatefile =  $tmpl_file ;
			$te_page->varnamelist = "".TEMPLATE_ENGINE_CONSTANTS_CORE."title,content,bid".TEMPLATE_ENGINE_CONSTANTS_EX."";
			$te_page->title = strip_tags(langit($title));
			$te_page->content = $content;
			$te_page->bid = $bid;
			$te_page->display($tmpl_file,$icb);
		}else {

			// IF THERE IS NO CENTER-BLOCKS ?! THEN WHAT ?! LET'S CHECK IT OUT...
			OpenTable();
			echo "<center><font class=\"option\"><b>".langit($title)."</b></font></center><br>".$content;
			CloseTable();
		}
	}
}
if (!function_exists(themeindex)) {
	function themeindex($sid,$aid,$catid,$informant,$time,$title,$counter,$hometext,$bodytext,$notes,$morelink,$cattitle,$topicname,$topicimage,$topictext,$tagsshow,$rating,$comment_num)
	{
		global $tipath,$db,$prefix,$currentlang,$te_page,$nextg;


		$informant = strip_tags($informant);
		$title = strip_tags($title);
		//------Fetch Author's name -------
		$author = (empty($informant)) ? $aid : $informant;
		$author = (!empty($author)) ? $author : $anonymous;
		//------More Link Image -------
		if (!empty($bodytext)) {
			$moreIMG = "<a href='modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."' class='button' target='_blank'>"._READMORE."</a>";
			$morelink = "<a href='modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."' target='_blank'>"._READMORE."</a>";
		}
		//------TOPIC IMG-------
		if (file_exists(THEME_PATH."images/topics/$topicimage")) {
			$t_image = THEME_PATH."images/topics/$topicimage";
		} else {
			$t_image = "$tipath$topicimage";
		}
		//------Date Conversion-------
		$datetime = hejridate($time);
		if ($currentlang == "persian"){$times="$datetime";}else {$times="$time";}
		if ($currentlang == "persian"){$d_break = hejridate($time,4,4);}else {$d_break = date("d m Y",strtotime($time));}

		$t_break = explode(" ",$d_break) ;
		$year = $t_break[2];
		$month = $t_break[1];
		$day = $t_break[0];
		//------Show Things up -------
		$posted .= "<img src=\"images/articles/category.gif\" title=\""._CATEGORY."\" width=\"17\" height=\"10\"  />$topicname ";
		$posted .= " <img src=\"images/articles/date.gif\" title=\"$times\" width=\"17\" height=\"10\"  />$times ";
		$posted .= " <img src=\"images/articles/clicks.gif\" title=\""._HITS.": $counter\" width=\"17\" height=\"10\"  />$counter";
		//------TEXT ATTRS : TITLE SLUG LINK -------
		$title_text = strip_tags($title);
		$title_slug = Slugit($title);
		$title_link = "modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."";
		$title = "<a href='$title_link'>$title</a>";
		$counter = intval($counter);

		//--TEXT COMMENTS --
		$comments_title = (empty($comment_num)) ? _COMMENTS : "".$comment_num._COMMENT."";
		$comments = "<a href='".$title_link."'>$comments_title</a>";

		if (empty($topicname)) {$topicname = _NO_TOPIC;}
		if (empty($tagsshow)) {$tagsshow = _NO_TAG;}

		$hometext = stripslashes($hometext);
		$bodytext = stripslashes($bodytext);

		//--TEXT CONTENT --
		$content = "<div style='direction:".langstyle("direction").";text-align:".langstyle("align")."'>$hometext</div>\n";
		//--PDF VERSION --
		$pdf_link = "<a href='modules.php?name=News&amp;file=pdf&amp;sid=$sid&amp;title=".Slugit($title)."'><img src='images/icon/pdf.png' title='"._PDF."' ></a>";


		//--SETTING TEMPLATE CONSTANTS AND ITS FILE OUT --
		$te_page->templatefile = THEME_PATH."story_home".T_PREFIX."";
		$te_page->varnamelist = "".TEMPLATE_ENGINE_CONSTANTS_CORE."title,content,post_info,time,writer,rating,tags,morelink,category,tid,more,counter,comments,PDF,year,month,day,topic_img,sid,title_text,title_link,title_slug,notes".TEMPLATE_ENGINE_CONSTANTS_EX."";

		$te_page->Dir = THEME_PATH;
		$te_page->name = $name;
		$te_page->content = $content;
		$te_page->post_info = $posted;
		$te_page->title = $title;
		$te_page->writer = $author;
		$te_page->time = $times;
		$te_page->category = $topicname;
		$te_page->tid = $catid;
		$te_page->rating = $rating;
		$te_page->tags = $tagsshow;
		$te_page->more = $moreIMG;
		$te_page->counter = $counter;
		$te_page->comments = $comments;
		$te_page->PDF = $pdf_link;
		$te_page->morelink = $morelink;
		$te_page->year = $year;
		$te_page->month = $month;
		$te_page->day = $day;
		$te_page->topic_img = $t_image;
		$te_page->sid = $sid;
		$te_page->title_text = $title_text;
		$te_page->title_link = $title_link;
		$te_page->title_slug = $title_slug;
		$te_page->notes = $notes;

		$te_page->display($te_page->templatefile,$sid);


	}
}
if (!function_exists(themearticle)) {
	function themearticle ($aid, $informant, $time, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
		global $admin,$currentlang,$storyinfo,$te_page,$tipath,$db,$nextg;



		$informant = strip_tags($informant);
		$title = strip_tags($title);


		if (file_exists(THEME_PATH."images/topics/$topicimage")) {
			$t_image = THEME_PATH."images/topics/$topicimage";
		} else {
			$t_image = "$tipath$topicimage";
		}
		$sid = $storyinfo['sid'];
		$posted = ""._POSTEDON." $datetime "._BY." ";
		$posted .= get_author($aid);
		//--FOOTNOTE OF THE TEXT --
		if (!empty($notes)) {
			$notes = "<br><br><b>"._NOTE."</b> <i>$notes</i>\n";
		}
		//--HOW TO PRESENT THE TEXT'S CONTENT --
		$content = "<div style='direction:".langstyle("direction")."';text-align:".langstyle("align")."'>$thetext</div>\n";

		// DATE OF THE TEXT -=================
		$datetime = hejridate($time);
		if ($currentlang == "persian"){$times="$datetime";}else {$times="$time";}

		//TAGS ===============================
		$tags_id = "".$storyinfo['tags']."";
		$tags = explode(" ",$tags_id);
		$c = count($tags);
		$tagsshow = '';
		for($i=1;$i<$c-1;$i++){
			list($tag,$tagslug) = $db->sql_fetchrow($db->sql_query('SELECT `tag`,`slug` FROM '.TAGS_TABLE.' WHERE `tid` = "'.$tags[$i].'" LIMIT 1'));
			$tagsshow .= '<a href="modules.php?name=News&amp;file=tags&amp;tag='.$tagslug.'">'.$tag.'</a>&nbsp;';
		}

		if (empty($topicname)) {$topicname = _NO_TOPIC;}
		if (empty($tagsshow)) {$tagsshow = _NO_TAG;}

		//------TEXT ATTRS : TITLE SLUG LINK -------
		$title_text = "$title";
		$title_slug = Slugit($title);
		$title_link = "modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."";
		$title = "<a href=\"$title_link\">$title</a>";

		$counter = intval($storyinfo['counter']);

		//--PDF VERSION --
		$pdf_link = "<a href='modules.php?name=News&amp;file=pdf&amp;sid=$sid&amp;title=".Slugit($title)."'><img src='images/icon/pdf.png' title='"._PDF."' ></a>";

		// LET'S DEFINE RATING OF THE TEXT
		$rating =  pullRating(1,$storyinfo[rate],$storyinfo[rates_count],$sid,true,true,true);

		//--TEXT COMMENTS --
		$comment_num = $db->sql_numrows($db->sql_query("SELECT `tid` FROM ".COMMENTS_TABLE." WHERE `sid`='$sid' LIMIT 1"));
		$comments_title = (empty($comment_num)) ? _COMMENTS : "".$comment_num._COMMENT."";
		$comments = "<a href='".$title_link."'>$comments_title</a>";
        //------Date Conversion-------
		$datetime = hejridate($time);
		if ($currentlang == "persian"){$times="$datetime";}else {$times="$time";}
		if ($currentlang == "persian"){$d_break = hejridate($time,4,4);}else {$d_break = date("d m Y",strtotime($time));}

		$t_break = explode(" ",$d_break) ;
		$year = $t_break[2];
		$month = $t_break[1];
		$day = $t_break[0];
		//--SETTING TEMPLATE CONSTANTS AND ITS FILE OUT --
		$te_page->templatefile = THEME_PATH."story_page".T_PREFIX."";
		$te_page->varnamelist = "".TEMPLATE_ENGINE_CONSTANTS_CORE."title,content,writer,year,month,day,time,category,rating,tags,counter,PDF,rating,topic_img,comments,sid,title_text,title_link,title_slug,source,source_link,notes".TEMPLATE_ENGINE_CONSTANTS_EX."";
		$te_page->Dir = THEME_PATH;
		$te_page->name = $name;
		$te_page->content = $content;
		$te_page->title = $title;
		$te_page->writer = $informant;
		$te_page->time = $datetime;
		$te_page->category = $topicname;
		$te_page->rating = $rating;
		$te_page->tags = $tagsshow;
		$te_page->counter = $counter;
		$te_page->PDF = $pdf_link;
		$te_page->rating = $rating;
		$te_page->topic_img = $t_image;
		$te_page->comments = $comments;
		$te_page->sid = $sid;
        $te_page->year = $year;
		$te_page->month = $month;
		$te_page->day = $day;
		$te_page->title_text = $title_text;
		$te_page->title_link = $title_link;
		$te_page->title_slug = $title_slug;
		$te_page->source = $storyinfo['newsref'];
		$te_page->source_link = $storyinfo['newsreflink'];
		$te_page->notes = $storyinfo['notes'];

		$te_page->display($te_page->templatefile,$sid);
	}
}
if (!function_exists(themefooter)) {
	function themefooter() {
		global $db,$name,$foot1, $foot2, $foot3, $foot4,$copyright,$te_page,$get_memory,$total_time, $start_time;


		//-- DO WE HAVE A RIGHT SIDER TO HAVE MORE FLEXIBLITY ?! --
		if (file_exists(THEME_PATH."right_side".T_PREFIX."") && file_exists(THEME_PATH."right_side_end".T_PREFIX."")) {
			$tmpl_file = THEME_PATH."right_side".T_PREFIX."";
            $tmpl_file2 = THEME_PATH."right_side_end".T_PREFIX."";
			$thefile = implode("", file($tmpl_file));
            $thefile2 = implode("", file($tmpl_file2));
			$thefile = addslashes($thefile);
			$thefile = "\$r_file=\"".$thefile."\";";
			eval($thefile);
			print $r_file;
			if($name!=phpBB3 AND !defined("blocks_show")  AND !defined("hide_lside"))	{
				blocks(right);
			}
            print $thefile2;
		}
		else {
			if($name!=phpBB3 AND !defined("blocks_show")  AND !defined("hide_lside") )	{
				?></td><td valign="top"><?php
				blocks(right);
			}
			?></td></tr></table><?php
		}

		//-- LETS DEFINE FOOTER MESSAGE AS A WHOLE ?! --
		$footer_message = "$copyright".(!empty($foot1)? "<br>$foot1" : "")."".(!empty($foot2)? "<br>$foot2" : "")."".(!empty($foot3)? "<br>$foot3" : "")."".(!empty($foot4)? "<br>$foot4" : "")."";

		//-- overall page load time ?! --
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$end_time = $mtime;
		$total_time = ($end_time - $start_time);
		$total_time = _PAGEGENERATION." ".substr($total_time,0,4)." "._SECONDS;

		//-- overall MEMORY USAGE ?! --
		if (function_exists("memory_get_usage")) {
			$memory_size = memory_get_usage(); // 36640
			$unit=array(''._BYTE.'',''._KB.'',''._MB.'',''._GB.'');
			$memory_usage = @round($memory_size/pow(1024,($i=floor(log($memory_size,1024)))),2).' '.$unit[$i];
		}
		$memoryInUse = ""._MEMORY_IN_USE .": " .$memory_usage;

		//-- overall querries running on this page ?! --
		$TOTAL_queries = $db->num_queries;
		$queries = ""._QUERIES .": " .intval($TOTAL_queries)."";
		$db->sql_freeresult($TOTAL_queries);

		$te_page->templatefile = THEME_PATH."footer".T_PREFIX."";
		$te_page->varnamelist = "".TEMPLATE_ENGINE_CONSTANTS_CORE."foot1,foot2,foot3,foot4,copyright,footer_message,total_time,total_query,memory,ads_down".TEMPLATE_ENGINE_CONSTANTS_EX."";
		$te_page->Dir = THEME_PATH;
		$te_page->name = $name;
		$te_page->foot1 = $foot1;
		$te_page->foot2 = $foot2;
		$te_page->foot3 = $foot3;
		$te_page->foot4 = $foot4;
		$te_page->footer_message = $footer_message;
		$te_page->copyright = $copyright;
		$te_page->total_time = $total_time;
		$te_page->total_query = $queries;
		$te_page->memory = $memoryInUse;
		$te_page->ads_down = ads(0);
		$te_page->displayContent($te_page->templatefile);


	}
}

//===========================================
//Theme PHPNUKE OLD SYSTEM FILE : GO TO HELL
//===========================================


?>