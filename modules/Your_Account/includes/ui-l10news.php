<?php


if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
global $currentlang,$prefix;
    // Last 10 Comments
    if ($articlecomm == 1) {
        $result6 = $db->sql_query("SELECT c.*,s.title FROM ".$prefix."_comments_moderated AS c LEFT JOIN nuke_stories AS s ON c.sid= s.sid WHERE c.name ='".$usrinfo['username']."' AND c.active='1' ORDER BY c.tid DESC LIMIT 0,10");
        if (($db->sql_numrows($result6) > 0)) {

        	OpenTable();
            echo "<b>$usrinfo[username]'s "._LAST10COMMENT.":</b><br><ul>";
            while($row6 = $db->sql_fetchrow($result6)) {
                $tid = $row6['tid'];
                $sid = $row6['sid'];
                $subject = $row6['title'];
                $comment = $row6['comment'];
	if (strlen($comment) > 100){ $comment = substr($comment, 0, 100) . ' ...';}
                echo "<li>
                <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($subject)."\">
                ".strip_tags($comment)."
                </a></li>";
            }
            echo "</ul>";
            CloseTable();
        }
    }
    $db->sql_freeresult($result6);
    // Last 10 Submissions
    $result7 = $db->sql_query("SELECT `sid`, `title` FROM ".$prefix."_stories WHERE `informant`='$usrinfo[username]' AND `time`<=now() AND  `section`='news' AND `approved`='1' AND `alanguage`='$currentlang' ORDER BY `sid` DESC LIMIT 0,10");
    if (($db->sql_numrows($result7) > 0)) {
        OpenTable();
        echo "<b>$usrinfo[username]'s "._LAST10SUBMISSION.":</b><br><ul>";
        while($row7 = $db->sql_fetchrow($result7)) {
            $sid = $row7[sid];
            $title = $row7[title];
            echo "<li>
            <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."\">
            $title  
            </a></li>";
        }
            echo "</ul>";
        CloseTable();
    }
    $db->sql_freeresult($result7);
?>