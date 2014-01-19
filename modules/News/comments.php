<?php

/**
*
* @package COMMENTS	
* Inspired by weblogina.com comment system appearance													
* @version $Id: comments.php $Aneeshtan 5:24 PM 10/5/2011				
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (!defined('MODULE_FILE')) {
	die ("You can't access this file directly...");
}
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);



if (isset($sid)) { $sid = intval($sid); } else { $sid = $_GET['sid']; }
if (isset($tid)) { $tid = intval($tid); } else { $tid = ""; }
if (isset($pid)) { $pid = intval($pid); } else { $pid = ""; }
if (isset($order)) { $order = intval($order); }
if (isset($thold)) { $thold = intval($thold); }
if (!isset($posttype)) { $posttype = ""; }

if (!isset($mode) OR empty($mode)) {
	if(isset($userinfo['umode'])) {
		$mode = $userinfo['umode'];
	} else {
		$mode = "thread";
	}
}
if (!isset($order) OR empty($order)) {
	if(isset($userinfo['uorder'])) {
		$order = $userinfo['uorder'];
	} else {
		$order = 0;
	}
}
if (!isset($thold) OR empty($thold)) {
	if(isset($userinfo['thold'])) {
		$thold = $userinfo['thold'];
	} else {
		$thold = 0;
	}
}
if (!isset($xanonpost)) { $xanonpost = ""; }

require_once(INCLUDES_PATH."inc_comments.php");
$commentClass = new comments_class();

switch($op) {
	
	case 'CreateTopic';
		$commentClass->CreateTopic($xanonpost,$author,$email,$url ,$subject, $comment, $pid, $sid, $host_name, $mode, $order, $thold,$comment_reply);
	break;
		
	case 'delete_this_comment';
		$commentClass->delete_this_comment();
	break;
		
	default:
		$commentClass->comment_showroom();
	break;
	
}
?>