<?php
/**
*
* @package acp                                                        
* @version $Id: acp_dashboard.php 0999 2009-12-12 15:35:19Z Aneeshtan $                        
* @copyright (c) Marlik Group  http://www.MarlikCMS.com                                            
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/**
* @ignore
*/
if (!defined('ADMIN_FILE')) {
	exit;
}
function MarlikCMS_RSS() {
	// You must include this PHP block in your template once
	// The required settings for Magpie
	define('MAGPIE_CACHE_DIR', 'includes/RSS/cache');
	define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
	// include the main file
	require_once('includes/RSS/rss_fetch.inc');
	//-- Show Latest Updates ----
	$latestupdate  = "<div id='SharedRss' style='padding: 8px;line-height:20px;'><h3> " . _LATEST_MarlikCMS_BLOGS . " </h3>";
	$sharedfeedurl = 'http://www.MarlikCMS.com/feed';
	$sharedpageurl = 'http://www.MarlikCMS.com/';
	$maxitems      = 10;
	$rss           = fetch_rss($sharedfeedurl);
	$countitems    = 1;
	foreach ($rss->items as $item) {
		$posttitle = $item["title"];
		if (strlen($showtitle) > 30)
		                                                $showtitle = substr($showtitle, 0, 49) . ' ...';
		$posturl  = $item["link_"];
		$siteurl  = $item["link_"];
		$sitename = $item["title_"];
		$latestupdate .= "<li><img src='images/icon/bullet_feed.png'><a href=" . $siteurl . " > $posttitle</a></li>";
		$countitems += 1;
		if ($countitems > $maxitems)
		                                                break;
	}
	$latestupdate .= "<br><img src='images/icon/rss.png'> <a href=" . $sharedpageurl . " rel=\"external\"><b>" . _MORENEWS . " </b></a></div>";
	//-- Show Latest Bugs ----
	$latestbugs    = "<div id='SharedRss' style='padding: 8px;line-height:20px;'><h3>  " . _LATEST_MarlikCMS_BUGS . "</h3>";
	$sharedfeedurl = 'http://www.MarlikCMS.com/bugs/syndicate.php';
	$sharedpageurl = 'http://www.bugs.MarlikCMS.com';
	$maxitems      = 10;
	$rss           = fetch_rss($sharedfeedurl);
	$countitems    = 1;
	foreach ($rss->items as $item) {
		$posttitle = $item["title"];
		if (strlen($showtitle) > 30)
		                                                $showtitle = substr($showtitle, 0, 49) . ' ...';
		$posturl  = $item["link"];
		$siteurl  = $item["link_"];
		$sitename = $item["title_"];
		$latestbugs .= "<li><img src='images/icon/bullet_feed.png'><a href=" . $posturl . " > $posttitle</a></li>";
		$countitems += 1;
		if ($countitems > $maxitems)
		                                                break;
	}
	$latestbugs .= "<br><img src='images/icon/rss.png'> <a href=" . $sharedfeedurl . " rel=\"external\"><b>" . _MORENEWS . " </b></a></div>";
	echo '<table style="width:100%;"><tr>' . '<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>' . $latestupdate . '</td>' //End Left sider
	. '<td  style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>' . $latestbugs . "</td>" //End Left sider
	. "</tr></table>
";
}
function news_list() {
	global $admin, $prefix, $db, $admin_file, $log;
	$sq  = $db->sql_query("SELECT sid, aid, title, time, topic, informant, alanguage , approved FROM " . STORY_TABLE . " WHERE title <> 'draft' ORDER BY time DESC LIMIT 0,20");
	$num = $db->sql_numrows($sq);
	if (!empty($num)) {
		//    OpenTable();
		echo "<h3 style=''>" . _LAST . " " . _ARTICLES . "</h3>";
		if ($num > 3) {
			$style = 'style="height:250px;width:100%;overflow-y:auto;overflow-x:hidden;text-align:center;"';
		}
		echo "<form action=\"" . $admin_file . ".php?op=multi_task\"  name='adminnews' id='adminnews' method=\"POST\" style='background:none;'>" . "<div $style >" . '<table class="widefat comments fixed" summary="Latest News">
    <thead>
    <tr>
    <th scope="col">
    ' . _SELECT . '<input type="checkbox" onclick="checkAll(document.getElementById(\'adminnews\'), \'selectbox\', this.checked);" />
    </th>
        <th scope="col">' . _TITLE . '</th>
            <th scope="col">' . _DATE . '</th>
                <th scope="col">' . _OPTIONS . '</th>
                </tr>
                </thead>
            <tfoot>
    <tr>
    <th scope="col">
    ' . _SELECT . '<input type="checkbox" onclick="checkAll(document.getElementById(\'adminnews\'), \'selectbox\', this.checked);" />
    </th>
        <th scope="col">' . _TITLE . '</th>
            <th scope="col">' . _DATE . '</th>
                <th scope="col">' . _OPTIONS . '</th>
                </tr>
            </tfoot>
    <tbody>';
		while (list($sid, $aid, $title, $time, $topic, $informant, $alanguage, $approved) = $db->sql_fetchrow($sq)) {
			$sid       = intval($sid);
			$aid       = check_html($aid, "nohtml");
			$said      = substr($aid, 0, 25);
			$title     = check_html($title, "nohtml");
			$topic     = intval($topic);
			$informant = check_html($informant, "nohtml");
			list($topicname) = $db->sql_fetchrow($db->sql_query("SELECT topicname FROM " . $prefix . "_topics WHERE topicid='$topic'"));
			$topicname = check_html($topicname, "nohtml");
			if (empty($alanguage)) {
				$alanguage = "" . _ALL . "";
			}
			$date     = date("Y-m-d g:i:s");
			$approved = intval($approved);
			if ($approved == "1") {
				$approved_style = "";
				$approved_img   = "images/icon/page_edit.png";
				$approved_title = "";
			} elseif ($approved == "2") {
				$approved_style = "style='background:#FFE49A;color:#293154'";
				$approved_img   = "images/icon/tick.png";
				$approved_title = "" . _SUBMITED . "-";
			} else {
				$approved_style = "style='background:#F1EEF5;color:#293154'";
				$approved_img   = "images/icon/tick.png";
				$approved_title = "" . _DRAFT . "-";
			}
			if ($time >= $date) {
				$approved_style = "style='background:#F2F2F2;color:#BBBBBB'";
				$approved_img   = "images/icon/time.png";
				$approved_title = "" . _SCHEDULED . "-";
			}
			echo "<tr>
            <td width=\"5%\" $approved_style><input type=\"checkbox\"  name=\"selecionar[]\"  class=\"selectbox\" value=\"$sid\"></td>" . "<td $approved_style align=\"right\"><a href=\"" . $admin_file . ".php?op=EditStory&amp;sid=$sid\">$title</a><font color='black'> $approved_title</font></td>" . "<td  $approved_style align=\"right\">" . hejridate($time, 4, 7) . "</td>";
			echo "<td $approved_style>&nbsp;
<a href=\"" . $admin_file . ".php?op=EditStory&amp;sid=$sid\"><img src=\"$approved_img\" alt=\"" . _EDIT . "\" title=\"" . _EDIT . "\"></a>
<a href=\"" . $admin_file . ".php?op=RemoveStory&amp;sid=$sid\"><img src=\"images/delete.gif\" alt=\"" . _DELETE . "\" title=\"" . _DELETE . "\"></a></td>";
		}
		echo "</tr></tbody></table></div><br class='clear'>";
		
		
		echo "<select name=\"act\">" . "<option value=\"del_stories\"  selected>" . _DELETESELECTED . "</option>" . "<option value=\"hot_stories\">" . _MAKEHOTSELECTED . "</option>" . "<option value=\"del_st_comments\">" . _DELETECOMMENTSELECTED . "</option>" . "</select>" . "&nbsp;<input type=\"submit\" value=\"" . _OK . "\">
        <br class='clear'>
        ";
		echo "</form>";

	echo "<div style='float:left'>
		<span style='background:#FFE49A;;cursor:pointer;padding:5px;border:1px solid white' title='" . _SUBMITED . "'>&nbsp;</span>&nbsp;
         <span style='background:#D7D0E0;;cursor:pointer;padding:5px;border:1px solid white' title='" . _DRAFT . "'>&nbsp;</span>&nbsp;
         <span style='background:#D9D9D9;cursor:pointer;padding:5px;border:1px solid white' title='" . _SCHEDULED . "'>&nbsp;</span>&nbsp;
	</div>";

	echo "<div style='float:left'>
	<form action='' onSubmit='javascript:return false;'>شناسه خبر : <input type='text' size='5' name='search_sid' id='search_sid'><input type='submit' onclick='javascript:window.location =\"admin.php?op=EditStory&sid=\"+$(\"#search_sid\").val()' value='"._GO."'></form>
	</div>";
	
	
	echo "<div class='clear'></div>";
	
		//    CloseTable();
	}
}
function comments_moderated($active, $sid) {
	global $prefix, $db, $admin_file, $pagenum, $log;
	//-- Lets learn if we have any story comments--
	if (!empty($sid)) {
		$sid  = sql_quote(intval($sid));
		$csid = "AND sid = '$sid'";
		//story number condition
	} else {
		$story_th       = '<th scope="col">' . _STORY_TITLE . '</th>';
		//story Name row
		$story_th_value = 1;
		//enable story th 
		$csid           = "";
		// Story row is zero
	}
	$num = $db->sql_numrows($db->sql_query("SELECT * FROM " . COMMENTS_TABLE . " 
 WHERE active='$active' $csid"));
	if ($num > 0) {
		$r .= "<h3 style=';'>$h3title</h3>\n" . "<form action=\"" . $admin_file . ".php?op=multi_task\" name=\"$formname\" id=\"$formname\"  method=\"POST\">\n";
		if ($num > 3) {
			$style = 'style="height:250px;width:100%;overflow-y:auto;overflow-x:hidden;text-align:center;"';
		}
		$r .= "<div $style >" . '<table class="widefat comments fixed" >
    <thead>
    <tr>
    <th scope="col">
    ' . _SELECT . '<input type="checkbox" onclick="checkAll(document.getElementById(\'' . $formname . '\'), \'selectbox\', this.checked);" />
    </th>
        <th scope="col">' . _COMMENT . '</th>
            ' . $story_th . '
            <th scope="col">' . _DATE . '</th>
              <th scope="col">' . _SENDER . '</th>
                <th scope="col">' . _FUNCTIONS . '</th>
                </tr>
                </thead>
                    </thead>
                    <tfoot>
    <tr>
    <th scope="col">
    ' . _SELECT . '<input type="checkbox" onclick="checkAll(document.getElementById(\'' . $formname . '\'), \'selectbox\', this.checked);" />
    </th>
        <th scope="col">' . _COMMENT . '</th>
            ' . $story_th . '
            <th scope="col">' . _DATE . '</th>
              <th scope="col">' . _SENDER . '</th>
                <th scope="col">' . _FUNCTIONS . '</th>
                </tr>
            </tfoot>
    <tbody>';
		/*
                                if (!isset($pagenum)) $pagenum=1;
                                $mc_exp=15;
                                $start_page=($pagenum-1)*$mc_exp;    
                                */
		$mc_exp = 15;
		//----
		// LIMIT $start_page,$mc_exp ";
		$rez    = $db->sql_query("SELECT * FROM " . COMMENTS_TABLE . " 
where active='$active' $csid
ORDER BY tid DESC
limit $mc_exp");
		while ($row = $db->sql_fetchrow($rez)) {
			if ($active == "1") {
				$h3title  = "" . _MODERATED_COMMENTS . "";
				$formname = "moderated";
			} else {
				$h3title           = "<span style='color:red'>" . _NOT_MODERATED_COMMENTS . "</span>";
				$formname          = "not_moderated";
				$approval_link_img = "<a href=\"" . $admin_file . ".php?op=moderation_approval&section=news&id=" . intval($row['tid']) . "\">
    <img src=\"images/check.png\" alt=\"" . _APPROVE . "\" title=\"" . _APPROVE . "\" width=\"15\"></a>";
			}
			$tid     = intval($row['tid']);
			$sid     = intval($row['sid']);
			$comment = check_words(strip_tags($row['comment']));
			if (strlen($comment) > 30) {
				$comment = substr($comment, 0, 30) . '...';
			}
			$email       = check_words(check_html($row['email'], "nohtml"));
			$time        = hejridate($row['date'], 1, 4);
			$row['name'] = filter($row['name'], "nohtml");
			$sql2        = $db->sql_query("SELECT sid, catid, aid, title FROM " . STORY_TABLE . " where sid = '$sid'");
			while ($row2 = $db->sql_fetchrow($sql2)) {
				$row2['sid'] = intval($row2['sid']);
				$s_sid       = intval($row2['sid']);
				$title       = check_words(check_html($row2['title'], "nohtml"));
				if (strlen($title) > 30) {
					$title = substr($title, 0, 30) . '...';
				}
				$r .= "<td width=\"5%\"><input type=\"checkbox\"   name=\"selecionar[]\"  class=\"selectbox\" value=\"" . $row['tid'] . "\" /></td>";
				$r .= "<td align=\"center\">&nbsp;<a href=\"" . $admin_file . ".php?op=moderation_mc_view&id=" . intval($row['tid']) . "\">$comment</a>&nbsp;</td>";
				if (!empty($story_th_value)) {
					$r .= "<td align=\"center\"><a href=\"modules.php?name=News&file=article&sid=" . intval($row['sid']) . "\">$title</a>&nbsp;</td>";
				}
				$r .= "<td align=\"center\">&nbsp;$time&nbsp;</td>";
				if ($email) {
					$r .= "<td align=\"center\" title= " . _GUEST . "> <a href=\"mailto:$email\" ><b>" . $row['name'] . "</b></a><br>";
				} else {
					$r .= "<td align=\"center\"><a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=" . $row['name'] . "\">
                        <b> " . $row['name'] . "</b></a>";
					$row2  = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM " . $user_prefix . "_users WHERE username='" . $row['name'] . "'"));
					$r_uid = intval($row2['user_id']);
				}
				$r .= "<td  align=\"center\">&nbsp; &nbsp; <a href=\"" . $admin_file . ".php?op=moderation_reject&section=news&id=" . intval($row['tid']) . "\"><img src=\"images/delete.gif\" alt=\"" . _REJECT . "\" title=\"" . _REJECT . "\" width=\"15\" heigh=\"15\" border=\"0\"></a>&nbsp;$approval_link_img </td>                </tr>";
			}
		}
		$r .= "</tbody></table></div><br>
<select name=\"act\">" . "<option value=\"del_comments\"  selected>" . _DELETESELECTED . "</option>";
		if ($active == "0") {
			$r .= "<option value=\"approve_comments\">" . _APPROVESELECTED . "</option>";
		}
		$r .= "</select>" . "&nbsp;<input type=\"submit\" value=\"" . _OK . "\">
</form>";
		/*                        
                                $sql_pn = "select tid FROM ".COMMENTS_TABLE." where active='$active' $csid ";
                                $result_pn = $db->sql_query($sql_pn);
                                $totalnum = $db->sql_numrows($result_pn);
                                $numpages = ceil($totalnum / $mc_exp);
                                if ($numpages> 1) {
                                echo "<br><br>";
                                echo "<center>";
                                echo "صفحات :[ " ;
                                for ($i=1; $i < $numpages+1; $i++) {  if ($i == $pagenum) { echo "&nbsp;$i&nbsp;";}
                                else {  echo "<a href='".ADMIN_OP."moderation_news&pagenum=$i' >&nbsp;<b>$i</b>&nbsp;</a>";  }
                                if ($i < $numpages) { echo " | "; } else  { echo " ]"; }  }
                                echo "</center>";
                                }
                                */
		return $r;
	}
}
?>