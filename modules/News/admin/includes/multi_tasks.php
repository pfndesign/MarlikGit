<?php

/**
*
* @package News Multi Tasks 														
* @version $Id: multi_tasks.php beta0.5   12/24/2009  5:51 PM  Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
/*
if (empty($order) OR empty($act) ) {
header('Location: admin.php?op=ShowNewsPanel');
}else {
*/

//--- News List Multi tasks ---
function del_stories(){
global $db,$log;
$id = $_POST['selecionar'];
$ids = implode(',',$id);
if ($id = null) {
show_error(HACKING_ATTEMPT);
}
$result = $db->sql_query("DELETE from ".STORY_TABLE." WHERE sid IN ($ids)");
$ids = explode(",",$ids);
$num = count($ids);
if ($result) {
$log->lwrite('admin',''. _ADMIN .":". LOG_MULTI_DEL_STORY.'');
 header("Location:  ".ADMIN_PHP."?op=ShowNewsPanel&nfy_msg=".$num." مطلب حذف شدند"); 
}else {
show_error(SQL_ERROR ."<br>".mysql_error());
}
}

function hot_stories(){
global $db,$log;
$id = $_POST['selecionar'];
$ids = implode(',',$id);
if ($id = null) {
show_error(HACKING_ATTEMPT);
}
$result = $db->sql_query("UPDATE ".STORY_TABLE." SET hotnews=1 WHERE sid IN ($ids)"); 
$ids = explode(",",$ids);
$num = count($ids);
if ($result) {
 header("Location:  ".$_SERVER['HTTP_REFERER']."&nfy_msg=".$num."مطلب داغ شدند "); 
 $log->lwrite('admin',''. _ADMIN .":". LOG_MULTI_HOT_STORY.'');
}else {
show_error(SQL_ERROR ."<br>".mysql_error());
}
}			

function del_st_comments(){
global $db,$log;
$id = $_POST['selecionar'];
$ids = implode(',',$id);
if ($id = null) {
show_error(HACKING_ATTEMPT);
}
$result = $db->sql_query("DELETE from ".COMMENTS_TABLE." WHERE sid IN ($ids)");
$ids = explode(",",$ids);
$num = count($ids);
if ($result) {
$log->lwrite('admin',''. _ADMIN .":". LOG_MULTI_DEL_STORY_COM.'');
 header("Location:  ".$_SERVER['HTTP_REFERER']."&nfy_msg=".$num." نظرات خبرها پاک شدند "); 
}else {
show_error(SQL_ERROR ."<br>".mysql_error());
}
}

//---- Comments List Multi Tasks --- 
function del_comments(){

global $db,$log;
$id = $_POST['selecionar'];
$ids = implode(',',$id);
if ($id != null) {
$showids =  $ids ;
}else {
show_error(HACKING_ATTEMPT);
}

$result = $db->sql_query("DELETE FROM ". COMMENTS_TABLE ." WHERE tid IN ($ids)");
$result = $db->sql_query("UPDATE ".STORY_TABLE."  SET comments=comments-1 WHERE sid IN ($ids)");
if ($result) {
$log->lwrite('admin',''. _ADMIN .":". LOG_MULTI_DELETE_COMMENTS.'');
 header("Location:  ".$_SERVER['HTTP_REFERER']." "); 
}else {
show_error(SQL_ERROR ."<br>".mysql_error());
}
}
function approve_comments(){
global $db,$log;
$id = $_POST['selecionar'];
$ids = implode(',',$id);
if ($id != null) {
$showids =  $ids ;
}else {
show_error(HACKING_ATTEMPT);
}

$result = $db->sql_query("UPDATE ".COMMENTS_TABLE." SET active='1' WHERE tid IN ($ids)");
$result = $db->sql_query("UPDATE ".STORY_TABLE." SET comments=comments+1 WHERE sid IN ($ids)");

if ($result) {
$log->lwrite('admin',''. _ADMIN .":". LOG_MULTI_APPROVE_COMMENTS.'');
 header("Location:  ".$_SERVER['HTTP_REFERER']." "); 
}else {
show_error(SQL_ERROR ."<br>".mysql_error());
}

}


switch ($order){
	
	case 'counter-desc':
	header("Location: ".ADMIN_OP."ShowNewsPanel&orderby=counter&mode=desc");
	die();
	
	case 'time-asc':
	header("Location: ".ADMIN_OP."ShowNewsPanel&orderby=time&mode=asc");
	die();
	
}
		
switch ($act) { 

	default:
	header('Location: '.ADMIN_PHP.'?op=ShowNewsPanel');
	break;
	
	case del_stories:
		del_stories();
	break;
	
	case hot_stories:
		hot_stories();
	break;
	
	case del_st_comments:
		del_st_comments();
	break;
	
	case del_comments:
		del_comments();
	break;
	
	case approve_comments:
		approve_comments();
	break;
	
	case trash_comments:
		trash_comments();
	break;
	
	case trash_stories:
		trash_stories();
	break;
	
}
//}
?>