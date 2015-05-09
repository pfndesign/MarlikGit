<?php

/**
*
* @package submission														
* @version $Id: submission.php beta0.5   12/24/2009  5:51 PM  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $admin, $bgcolor1, $bgcolor2, $prefix, $db, $radminsuper, $anonymous, $multilingual, $admin_file, $user_prefix;
		$dummy = 0;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._SUBMISSIONSADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		$result = $db->sql_query("SELECT qid, uid, uname, subject, timestamp, alanguage FROM ".$prefix."_queue order by timestamp DESC");
		if($db->sql_numrows($result) == 0) {
			echo "<table width=\"100%\"><tr><td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NOSUBMISSIONS."</b></td></tr></table>\n";
		} else {
			echo "<center><font class=\"content\"><b>"._NEWSUBMISSIONS."</b></font><form action=\"".$admin_file.".php\" method=\"post\"><table width=\"100%\" border=\"1\"><tr><td bgcolor=\"$bgcolor2\"><b>&nbsp;"._TITLE."&nbsp;</b></td>";
			if ($multilingual == 1) {
				echo "<td bgcolor=\"$bgcolor2\"><b><center>&nbsp;"._LANGUAGE."&nbsp;</center></b></td>";
			}
			echo "<td bgcolor=\"$bgcolor2\"><b><center>&nbsp;"._AUTHOR."&nbsp;</center></b></td><td bgcolor=\"$bgcolor2\"><b><center>&nbsp;"._DATE."&nbsp;</center></b></td><td bgcolor=\"$bgcolor2\"><b><center>&nbsp;"._FUNCTIONS."&nbsp;</center></b></td></tr>\n";
			while (list($qid, $uid, $uname, $subject, $timestamp, $alanguage) = $db->sql_fetchrow($result)) {
				$qid = intval($qid);
				$uid = intval($uid);
				$row = $db->sql_fetchrow($db->sql_query("SELECT karma FROM ".$user_prefix."_users WHERE user_id='$uid'"));
				if ($row[karma] == 0) {
					$karma = "&nbsp;";
				} elseif ($row[karma] == 1) {
					$karma = "&nbsp;<img src=\"images/karma/$row[karma].gif\" alt=\""._KARMALOW."\" title=\""._KARMALOW."\" border=\"0\">";
				} elseif ($row[karma] == 2) {
					$karma = "&nbsp;<img src=\"images/karma/$row[karma].gif\" alt=\""._KARMABAD."\" title=\""._KARMABAD."\" border=\"0\">";
				} elseif ($row[karma] == 3) {
					$karma = "&nbsp;<img src=\"images/karma/$row[karma].gif\" alt=\""._KARMADEVIL."\" title=\""._KARMADEVIL."\" border=\"0\">";
				}
				echo "<td width=\"100%\" bgcolor=\"$bgcolor1\"><font class=\"content\">\n";
				if (empty($subject)) {
					echo "&nbsp;<a href=\"".$admin_file.".php?op=DisplayStory&amp;qid=$qid\">"._NOSUBJECT."</a></font>\n";
				} else {
					echo "&nbsp;<a href=\"".$admin_file.".php?op=DisplayStory&amp;qid=$qid\">$subject</a></font>\n";
				}
				if ($multilingual == 1) {
					if (empty($alanguage)) {
						$alanguage = _ALL;
					}
					echo "</td><td align=\"center\" bgcolor=\"$bgcolor1\"><font size=\"2\">&nbsp;$alanguage&nbsp;</font>\n";
				}
				if ($uname != $anonymous) {
					echo "</td><td bgcolor=\"$bgcolor1\" align=\"center\" nowrap><font size=\"2\">&nbsp;<a href='modules.php?name=Your_Account&op=userinfo&username=$uname'>$uname</a>$karma</font>\n";
				} else {
					echo "</td><td bgcolor=\"$bgcolor1\" align=\"center\" nowrap><font size=\"2\">&nbsp;$uname&nbsp;</font>\n";
				}
				$timestamp = explode(" ", $timestamp);
				echo "</td><td bgcolor=\"$bgcolor1\" align=\"right\" nowrap><font class=\"content\">&nbsp;" . hejridate($timestamp[0], 1, 3) . "&nbsp;</font></td><td bgcolor=\"$bgcolor1\" align=\"center\"><font class=\"content\">&nbsp;<a href=\"".$admin_file.".php?op=DisplayStory&amp;qid=$qid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=DeleteStory&amp;qid=$qid\"><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>&nbsp;</td></tr>\n";
				$dummy++;
			}
			if ($dummy < 1) {
				echo "<tr><td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NOSUBMISSIONS."</b></form></td></tr></table>\n";
			} else {
				echo "</table></form>\n";
			}
		}
		if ($radminsuper == 1) {
			echo "<br><center>"
			."[ <a href=\"".$admin_file.".php?op=subdelete\">"._DELETE."</a> ]"
			."</center><br>";
		}
		CloseTable();
		include ("footer.php");

?>