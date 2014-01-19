<?php
/**
 *
 * @package shoutbox
 * @version $Id: BASIC VERSION : Aneeshtan $
 * @copyright (c) INSPIRED BY : yensdesign.com AND Revised By Nukelearn Group  http://www.nukelearn.com
 * @license ONLY FOR NUKELEARN'S USERS
 *
 */
/******************************
	LOAD SHOUTBOX CLASS 
/******************************/
global $db,$admin,$prefix;
define("NL_SHOUTBOX_TABLE","".$prefix."_shoutbox");
define("NL_SHOUTBOX_PATH","".MODS_PATH."JQ-Shoutbox/");
define("NL_SHOUTBOX_SMILEY_DIR","images/smiley/");
require_once(NL_SHOUTBOX_PATH."class.shoutbox.php");
$NL_SHOUTBOX_CLASS = new nl_shoutbox();
/******************************
	MANAGE REQUESTS
/******************************/
if(!$_POST['action']) {
	header ("Location: index.php");
} else {
	switch($_POST['action']) {
		case "update":
		$res = $NL_SHOUTBOX_CLASS->getContent(10);
		$cnt=1;
		$result = "<div style='overflow-y:auto;overflow-x:hidden;height:250px;'>";
		while($row = $db->sql_fetchrow($res)) {
			$message_shoutbox = check_html($row['message'],'nohtml');
			$message_shoutbox = $NL_SHOUTBOX_CLASS->check_smiley_in_text(sql_quote($message_shoutbox));
			$cnt++;
			$classrow = ($cnt%2) ? "class=\"shoutbox-oddrow\"" : "class=\"shoutbox-evenrow\"";
			if (is_admin($admin)) {
				$delteIMG = "<a href='javascript:delete_shout_".$row['id']."' class='delete_update' id='".$row['id']."'><img src=\"images/icon/bullet_delete.png\" ></a>";
			}
			$result .= "<li $classrow id='shout_li_".$row['id']."'><img src=\"images/icon/user.png\" /><a href='modules.php?name=Your_Account&op=userinfo&username=".$row['user']."'><b>&nbsp;".$row['user']."</b></a><br>".langit($message_shoutbox)." $delteIMG<br>
				<span class=\"date\">&nbsp;".$row['date']."</span></li>";
		}
		$result .= "</div>";
		echo $result;
		break;
		case "insert":
					echo $NL_SHOUTBOX_CLASS->insertMessage(sql_quote($_POST['nick']), sql_quote($_POST['message']));
		break;
		case "delete":
					echo $NL_SHOUTBOX_CLASS->deleteMessage(sql_quote($_POST['id']));
		break;
	}
	$db->sql_freeresult($link);
}
?>