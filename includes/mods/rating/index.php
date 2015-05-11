<?php
/** 
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package Star Rating																		|
	|	* @version v 1.0.0																			|																		|	* @copyright (c) Marlik Group														|
	|	* http://www.MarlikCMS.com																	|
	|	* Ported By: Exoid - www.nuke-evolution.ir		                    						|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
	|	File Copyright		farshad ghazanfari: 													|
   	|   ======================================== 													|
	|																								|
	+-----------------------------------------------------------------------------------------------+
*/
// Modified for MarlikCMS USV by James [Hamed]
//define("RATING_IN",true);
header("Cache-Control: no-cache");
header("Pragma: nocache");

/*

Dynamic Star Rating Redux
Developed by Jordan Boesch
www.boedesign.com
Licensed under Creative Commons - http://creativecommons.org/licenses/by-nc-nd/2.5/ca/

Used CSS from komodomedia.com.
*/
include_once(MODS_PATH."rating/inc_ratings.php");
switch ($_GET['action']) {
	case 'posneg':
		setScore();
	break;

	default:
		break;
}

if(empty($_GET['id']) AND empty($_POST['id'])){
	show_error("YOU ARE NOT AUTHORIZED TO VIEW THIS FILE DIRECTLY");
}else {

//require_once("mainfile.php");
// Cookie settings
$expire = time() + 99999999;
$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
global $db,$prefix,$userinfo;
// escape variables
function escape($val){

	$val = trim($val);
	
	if(get_magic_quotes_gpc()) {
       	$val = stripslashes($val);
     }
	 
	 return mysql_real_escape_string($val);
	 
}

// IF JAVASCRIPT IS ENABLED

if($_POST){

	
	$id = escape($_POST['id']);
	$rating = (int) $_POST['rating'];
	$section = (int) $_POST['section'];
	$sid = (int) $_POST['sid'];
/*
define('NEWS_SEC',1);
define('DOWNLOAD_SEC',2);
define('USERS_SEC',3);
*/
	if($rating <= 5 && $rating >= 1){
	
		$result = mysql_query("SELECT id FROM ".$prefix."_ratings WHERE rating_id = '$id' AND section='$section' AND (ip = '".$_SERVER['REMOTE_ADDR']."' OR voter = '".$userinfo['username']."')");
		
		if(mysql_num_rows($result)>0 || isset($_COOKIE[''.$section.'_vote_'.$id])){
			echo 'already_voted';
			echo _YOU_VOTED_BEFORE;
			
		} else {

			
			setcookie(''.$section.'_vote_'.$id,$id,$expire,'/',$domain,false);
			mysql_query("INSERT INTO ".$prefix."_ratings (rating_id,rating_num,section,ip,voter) VALUES ('$id','$rating','$section','".$_SERVER['REMOTE_ADDR']."','".$userinfo['username']."')") or die(mysql_error());
			
			switch ($section){
				case '3':
			mysql_query('UPDATE `'.$prefix.'_users` SET `rate` = `rate` + '.$rating.', `rates_count` = `rates_count` + 1 WHERE `user_id` = "'.$id.'" LIMIT 1') or die(mysql_error());
				break;
				case '2':
			mysql_query('UPDATE `'.$prefix.'_nsngd_downloads` SET `rate` = `rate` + '.$rating.', `rates_count` = `rates_count` + 1 WHERE `lid` = "'.$id.'" LIMIT 1') or die(mysql_error());
				break;
				case '1':
			mysql_query('UPDATE `'.$prefix.'_stories` SET `rate` = `rate` + '.$rating.', `rates_count` = `rates_count` + 1 WHERE `sid` = "'.$id.'" LIMIT 1') or die(mysql_error());
				break;			
			}
			
			
			$total = 0;
			$rows = 0;
			
			$sel = mysql_query("SELECT rating_num FROM ".$prefix."_ratings WHERE rating_id = '$id'");
			while($data = mysql_fetch_assoc($sel)){
			
				$total = $total + $data['rating_num'];
				$rows++;
			}
			
			$perc = ($total/$rows) * 20;
			
			echo round($perc,2);
			//echo round($perc/5)*5;
			
		}
		
	}

}

// IF JAVASCRIPT IS DISABLED

else{

	$id = escape($_GET['id']);
	$rating = (int) $_GET['rating'];
	$section = (int) $_GET['section'];
	
	// If you want people to be able to vote more than once, comment the entire if/else block block and uncomment the code below it.
	
	if($rating <= 5 && $rating >= 1){
	
		if(mysql_fetch_assoc(mysql_query("SELECT id FROM ".$prefix."_ratings WHERE rating_id = '$id' AND section='$section' AND (ip = '".$_SERVER['REMOTE_ADDR']."' OR voter = '".$userinfo['username']."')")) || isset($_COOKIE[''.$section.'_vote_'.$id])){
		
			echo 'already_voted';
			
		} else {
			
			setcookie(''.$section.'_vote_'.$id,$id,$expire,'/',$domain,false);
			mysql_query("INSERT INTO ".$prefix."_ratings (rating_id,rating_num,section,ip,voter) VALUES ('$id','$rating','$section','".$_SERVER['REMOTE_ADDR']."','".$userinfo['username']."')") or die(mysql_error());
			
			switch ($section){
				case '3':
			mysql_query('UPDATE `'.$prefix.'_users` SET `rate` = `rate` + '.$rating.', `rates_count` = `rates_count` + 1 WHERE user_id = "'.$sid.'" LIMIT 1') or die(mysql_error());
				break;
				case '2':
			mysql_query('UPDATE `'.$prefix.'nsngd_downloads` SET `rate` = `rate` + '.$rating.', `rates_count` = `rates_count` + 1 WHERE lid = "'.$sid.'" LIMIT 1') or die(mysql_error());
				break;
				case '1':
			mysql_query('UPDATE `'.$prefix.'stories` SET `rate` = `rate` + '.$rating.', `rates_count` = `rates_count` + 1 WHERE sid = "'.$sid.'" LIMIT 1') or die(mysql_error());
				break;			
			}
			
			
			
		}
		
		header("Location:".$_SERVER['HTTP_REFERER']."");
		die;
		
	}
	else {
	
		echo 'You vote  '.$rating.' times .You cannot rate this more than 5 or less than 1  <a href="'.$_SERVER['HTTP_REFERER'].'">back</a>';
		
	}
	
}

}
?>