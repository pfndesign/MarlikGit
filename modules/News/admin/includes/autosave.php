<?php

/**
*
* @package News Auto Save  														
* @version $Id: autosave.php beta0.5   1:09 PM 1/25/2010  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $tag;
if($_POST){
	
			$story_id = intval($_POST['story_id']);
			$catid = intval($_POST['catid']);
			$subject = addslashes(check_words(check_html($_POST['title'], "nohtml")));

			$hometext = unescape($_POST['hometext']);
			$bodytext = unescape($_POST['bodytext']);
			
			$hometext = addslashes(check_html($hometext,"html"));
			$bodytext = addslashes(check_html($bodytext,"html"));
			
/*

			$tags = addslashes(check_words(check_html($_POST['tags'], "")));
			$tag->add_tags($tags);
			$tag_ids = $tag->get_tag_ids($tags);
*/
			$newsrefrence = addslashes(check_words(check_html($_POST['newsrefrence'], "nohtml")));
			$newsrefrencelink = addslashes(check_words(check_html($_POST['newsrefrencelink'], "nohtml")));

			$topic = intval($_POST['topic']);
			$notes = addslashes(check_words(check_html($_POST['notes'], "")));
			
			$language = addslashes(check_words(check_html($_POST['notes'], "")));

			$associated = check_html($_POST['associated'], "nohtml");
			$date = date("Y-m-j H:i:s");
			$time = date("D H:i:s");
			
			//$time = zonedate("G:i:s", '0330' , false); 
			
//Update SQL
$result = $db->sql_query("update ".$prefix."_stories set catid='$catid',aid='$aid',title='$title', time='$date', hometext='$hometext',
 bodytext='$bodytext',newsref='$newsrefrence',newsreflink='$newsrefrencelink',comments='0',counter='0', topic='$topic', informant='$aid',
 notes='$notes', ihome='1', alanguage='$alanguage',approved='3',section='news' where sid='$story_id'");

 		
//output timestamp
if ($result) {
echo '<div class="notify">پیش نویس ذخیره شد :<span style="font-size:14px;"><b> ', Convertnumber2farsi($time) ,'</b><span></div>';
}else {
echo '<div class="error">مشکلی در ذخیره اطلاعات وجود دارد :<br> '.mysql_error().'</div>';
}


//output ERROR
}else {
echo '<div class="error">مشکلی در ذخیره اطلاعات وجود دارد<br> $_Post is not available</div>';
}


?>