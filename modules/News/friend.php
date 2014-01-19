<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/*         Additional security & Abstraction layer conversion           */
/*                           2003 chatserv                              */
/*      http://www.nukefixes.com -- http://www.nukeresources.com        */
/************************************************************************/
/* INP-Nuke : Expect to be impressed                                    */
/* ===========================                                          */
/*                               COPYRIGHT                              */
/*                                                                      */
/* Copyright (c) 2005 - 2006 by http://www.irannuke.net                 */
/*                                                                      */
/*     Iran Nuke Portal                        (info@irannuke.net)      */
/*                                                                      */
/* Refer to irannuke.net for detailed information on INP-Nuke           */
/************************************************************************/

if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}
require_once("mainfile.php");

$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- "._RECOMMEND."";

function FriendSend($sid) {
    global $user, $cookie, $prefix, $db, $user_prefix, $module_name;
    $sid = intval($sid);
    if(!isset($sid)) { exit(); }
    include ("header.php");
    $row = $db->sql_fetchrow($db->sql_query("SELECT title FROM ".$prefix."_stories WHERE sid='$sid'"));
    $title = check_words(check_html($row['title'], "nohtml"));
    title(""._FRIEND."");
    OpenTable();
    echo "<center><font class=\"content\"><b>"._FRIEND."</b></font></center><br><br>"
                .""._YOUSENDSTORY." <b>$title</b> "._TOAFRIEND."<br><br>"
                ."<form action=\"modules.php?name=$module_name&amp;file=friend\" method=\"post\">"
                ."<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
  if (is_user($user)) {
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, username, user_email FROM ".$user_prefix."_users WHERE username='$cookie[1]'"));
		if ($row['name'] == "") {
			$yn = check_words(check_html($row2['username'], "nohtml"));
		} else {
			$yn = check_words(check_html($row2['name'], "nohtml"));
		}
		$ye = check_words(check_html($row2['user_email'], "nohtml"));
	}
    echo "<b>"._FYOURNAME." </b> <input type=\"text\" name=\"yname\" value=\"$yn\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(yname)><br><br>\n"
                ."<b>"._FYOUREMAIL." </b> <input type=\"text\" dir=\"ltr\" name=\"ymail\" value=\"$ye\"><br><br><br>\n"
                ."<b>"._FFRIENDNAME." </b> <input type=\"text\" name=\"fname\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(fname)><br><br>\n"
                ."<b>"._FFRIENDEMAIL." </b> <input type=\"text\" dir=\"ltr\" name=\"fmail\"><br><br>\n"
                ."<input type=\"hidden\" name=\"op\" value=\"SendStory\">\n"
                ."<input type=\"submit\" value="._SEND.">\n"
                ."</form>\n";
    CloseTable();
    include ('footer.php');
}

function SendStory($sid, $yname, $ymail, $fname, $fmail) {
    global $sitename, $nukeurl, $prefix, $db, $module_name;
    $fname = check_words(check_html(removecrlf($fname), "nohtml"));
    $fmail = check_words(check_html(removecrlf($fmail), "nohtml"));
    $yname = check_words(check_html(removecrlf($yname), "nohtml"));
    $ymail = check_words(check_html(removecrlf($ymail), "nohtml"));
    $sid = intval($sid);
    $row = $db->sql_fetchrow($db->sql_query("SELECT title, time, topic FROM ".$prefix."_stories WHERE sid='$sid'"));
    $title = check_words(check_html($row['title'], "nohtml"));
    $time = $row['time'];
    $topic = intval($row['topic']);
    $row2 = $db->sql_fetchrow($db->sql_query("SELECT topictext FROM ".$prefix."_topics WHERE topicid='$topic'"));
    $topictext = check_words(check_html($row2['topictext'], "nohtml"));
    $subject = ""._INTERESTING." $sitename";
    $message = ""._HELLO." $fname:\n\n"._YOURFRIEND." $yname "._CONSIDERED."\n\n\n$title\n("._FDATE." " . hejridate($time, 4, 9) . ")\n"._FTOPIC." $topictext\n\n"._URL.": $nukeurl/modules.php?name=$module_name&file=article&sid=$sid\n\n"._YOUCANREAD." $sitename\n$nukeurl";
    $message = FarsiMail($message);
	mail($fmail, $subject, $message, "From: \"$yname\" <$ymail>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nContent-transfer-encoding: 8bit");
    update_points(6);
    $title = urlencode($title);
    $fname = urlencode($fname);
    Header("Location: modules.php?name=$module_name&file=friend&op=StorySent&title=$title&fname=$fname");
}

function StorySent($title, $fname) {
    include ("header.php");
    $title = check_words(check_html($title, "nohtml"));
    $fname = htmlspecialchars(urldecode($fname));
    OpenTable();
    echo "<center><font class=\"content\">"._FSTORY." <b>$title</b> "._HASSENT." $fname... "._THANKS."</font></center>";
    CloseTable();
    include ("footer.php");
}

switch($op) {

    case "SendStory":
    SendStory($sid, $yname, $ymail, $fname, $fmail);
    break;
        
    case "StorySent":
    StorySent($title, $fname);
    break;

    case "FriendSend":
    FriendSend($sid);
    break;

}

?>