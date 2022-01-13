<?php

/**
 *
 * @package statistics														
 * @version $Id: statistics.php 6:45 PM 1/9/2010 Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
if (!preg_match("/" . $admin_file . ".php/", "$_SERVER[PHP_SELF]")) {
	die("Access Denied");
}

if (!defined('ADMIN_FILE')) {
	die("Illegal File Access");
}
global $admin;
if (is_superadmin($admin)) {
	function StatMain()
	{
		global $db, $trackip, $prefix;
		include_once('header.php');
		GraphicAdmin();
		if ($trackip == 0) {
			echo "<center><div class='error'>" . _STAT_DISABLED_TAS . "</div></center>";
		}
		show_charts();
		include_once('footer.php');
	}
	function show_charts()
	{

		global $db, $trackip, $prefix;
		if ($trackip == 0) {
			$classfornotfollowingiptracking = 'background:#FFCCCC';
		}

		$result = $db->sql_query("SELECT type, var, count from " . $prefix . "_counter order by type desc");
		while ($row = $db->sql_fetchrow($result)) {
			$type = check_words(check_html($row['type'], "nohtml"));
			$var = check_words(check_html($row['var'], "nohtml"));
			$count = intval($row['count']);
			if (($type == "config") && ($var == "Synchronization")) {
				$Synchronization = $count;
			} elseif (($type == "total") && ($var == "visits")) {
				$totalVisits = $count;
			} elseif (($type == "total") && ($var == "pageviews")) {
				$totalPVisits = $count;
			} elseif ($type == "browser") {
				if ($var == "FireFox") {
					$firefox = $count;
				} elseif ($var == "Chrome") {
					$Chrome = $count;
				} elseif ($var == "MSIE") {
					$msie = $count;
				} elseif ($var == "Konqueror") {
					$konqueror = $count;
				} elseif ($var == "Opera") {
					$opera = $count;
				} elseif ($var == "Lynx") {
					$lynx = $count;
				} elseif ($var == "Bot") {
					$bot = $count;
				} elseif (($type == "browser") && ($var == "Other")) {
					$b_other = $count;
				}
			} elseif ($type == "os") {
				if ($var == "Windows") {
					$windows = $count;
				} elseif ($var == "Mac") {
					$mac = $count;
				} elseif ($var == "Linux") {
					$linux = $count;
				} elseif ($var == "FreeBSD") {
					$freebsd = $count;
				} elseif ($var == "SunOS") {
					$sunos = $count;
				} elseif ($var == "IRIX") {
					$irix = $count;
				} elseif ($var == "BeOS") {
					$beos = $count;
				} elseif ($var == "OS/2") {
					$os2 = $count;
				} elseif ($var == "AIX") {
					$aix = $count;
				} elseif (($type == "os") && ($var == "Other")) {
					$os_other = $count;
				}
			} elseif ($type == "se") {
				if ($var == "google") {
					$google = $count;
				} elseif ($var == "yahoo") {
					$yahoo = $count;
				} elseif ($var == "bing") {
					$bing = $count;
				} elseif (($type == "se") && ($var == "other")) {
					$se_other = $count;
				}
			}
		}

		$db->sql_freeresult($result);

		if ($Synchronization == 0) {
			echo "<div class='notify'><img src='images/icon/note.png'><a href='" . ADMIN_OP . "Stat_Synchronization'>
			" . _STAT_SYNC . "
			</a></div>";
		}



		//Hamed: since the previous query wasn't working I came up with this one that makes less query(half the previous one) and yaay it's working.
		//fist we have to play a little bit with the date
		//Farshad : what about a better look at our query ?! :D



		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', time() - (3600 * 24));
		//this is the mighty query
		//SURE IT IS AND IT'S POWERED BY MINE :D
		$GeneralStat = $db->sql_fetchrow($db->sql_query("
		SELECT (SELECT COUNT(*) from " . __USER_TABLE . ") TotalUsers,
       (SELECT COUNT(*) from  " . STORY_TABLE . ") TotalStories,
       (SELECT COUNT(*) from " . COMMENTS_TABLE . ") totalcomm,
       (SELECT COUNT(*) from " . DOWNLOAD_TABLE . ") totalfiles,
       (SELECT COUNT(*) from " . $prefix . "_session) totalonlines,
       (SELECT COUNT(*) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tuv,
       (SELECT COUNT(*) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yuv,
       (SELECT COUNT(*) from " . $prefix . "_session WHERE session_user_id > 0 ) uonline,
       (SELECT COUNT(*) from " . $prefix . "_session WHERE session_user_id = '0' ) gonline,
       (SELECT `count` from " . $prefix . "_counter WHERE type = 'total' AND var = 'visits') totalVisits,
       (SELECT `count` from " . $prefix . "_counter WHERE type = 'total' AND var = 'pageviews') totalPVisits,
       (SELECT COUNT(*) from " . $prefix . "_authors ) TotalAuthors,
       (SELECT COUNT(*) from " . $prefix . "_topics) TotalTopics,
       (SELECT COUNT(*) from " . $prefix . "_tags) TotalTags;
  "));
		$TotalVisitsToday = $GeneralStat['tuv'];
		$TotalPVisitsToday = $GeneralStat['tv'];
		$TotalVisitsYesterday = $GeneralStat['yuv'];
		$TotalPVisitsYesterday = $GeneralStat['yv'];
		$TotalCrawlers = $GeneralStat['TotalCrawlers'];

		/// LIST ALL VISITS PER LISTENED DAYS
		$result = $db->sql_query("SELECT DATE(date_time) as date, COUNT(DISTINCT ip_address) AS TotalVisitsToday, COUNT(ip_address) AS TotalPVisitsToday  FROM " . $prefix . "_iptracking GROUP BY date ORDER BY date_time DESC");
		$a = 0;
		$array_chart_v = array();
		$array_chart_pv = array();
		$visitLists = $visitListsV = $HitsLists = $HitsListsV = "";
		while ($row = $db->sql_fetchrow($result)) {
			$a++;
			$date = $row['date'];


			$array_chart_v[] = intval($row['TotalVisitsToday']);
			$array_chart_pv[] = intval($row['TotalPVisitsToday']);


			$TotalVisitsTodaycount = $row['TotalVisitsToday'];
			$TotalPVisitsTodaycount = $row['TotalPVisitsToday'];

			$dateArr = explode(' ', $date);
			$comma = ($a == 1) ? "" : ",";

			$visitLists .= "$comma$TotalVisitsTodaycount";
			$visitListsV .= "<img src='images/icon/time.png'>" . hejridate($dateArr[0], 1) . "<img src='images/icon/bullet_orange.png'>[<b>" . number_format($TotalVisitsTodaycount) . "</b>]<br>";

			$HitsLists .= "$comma$TotalPVisitsTodaycount";
			$HitsListsV .= "<img src='images/icon/time.png'>" . hejridate($dateArr[0], 1) . "<img src='images/icon/bullet_orange.png'>[<b>" . number_format($TotalPVisitsTodaycount) . "</b>]<br>";
		}

		$db->sql_freeresult($result);



		$chartUrlPie1 = urlencode("" . ADMIN_OP . "chartDATA&chartTitle=pie&chartType=pie&chartValue=chartArraySO");
		$chartUrlPie2 = urlencode("" . ADMIN_OP . "chartDATA&chartTitle=pie&chartType=pie&chartValue=chartArrayBS");
		$chartUrlPie3 = urlencode("" . ADMIN_OP . "chartDATA&chartTitle=pie&chartType=pie&chartValue=chartArraySE");

		$chartUrlLine = urlencode("" . ADMIN_OP . "chartDATA&chartTitle=line&chartType=line&chartValue=array_chart_v");
		$chartUrlBar = urlencode("" . ADMIN_OP . "chartDATA&chartTitle=bar&chartType=bar&chartValue=array_chart_pv");
?>

		<script type="text/javascript" src="includes/openChart/js/swfobject.js"></script>
		<script type="text/javascript">
			swfobject.embedSWF(
				"includes/openChart/open-flash-chart.swf", "pie_chart1",
				"300", "300", "9.0.0", "expressInstall.swf", {
					"data-file": "<?php echo $chartUrlPie1; ?>"
				});

			swfobject.embedSWF(
				"includes/openChart/open-flash-chart.swf", "pie_chart2",
				"300", "300", "9.0.0", "expressInstall.swf", {
					"data-file": "<?php echo $chartUrlPie2; ?>"
				});

			swfobject.embedSWF(
				"includes/openChart/open-flash-chart.swf", "pie_chart3",
				"300", "300", "9.0.0", "expressInstall.swf", {
					"data-file": "<?php echo $chartUrlPie3; ?>"
				});


			swfobject.embedSWF(
				"includes/openChart/open-flash-chart.swf", "line_chart", "550", "200",
				"9.0.0", "expressInstall.swf", {
					"data-file": "<?php echo $chartUrlLine; ?>"
				});

			swfobject.embedSWF("includes/openChart/open-flash-chart.swf", "my_chart", "550", "200", "9.0.0", "expressInstall.swf", {
				"data-file": "<?php echo $chartUrlBar; ?>"
			});
		</script>


		<table style="width:100%;">

			<tr>

				<td style="width:50%;<?php echo $classfornotfollowingiptracking; ?>" class="box_wrapper" id="box_wrapper"><br><br>
					<h3>
						<?PHP echo _STAT_CHART_USERS_LINE ?>
					</h3>

					<p>
						<center>
							<div id="my_chart"></div>
						</center>
					</p>
					<br>



					<img src='images/icon/chart_line.png'>
					<?PHP echo _STAT_CHART_VISITED ?>
					:<br>
					<?PHP echo _TODAY ?>: <b><?php echo number_format($TotalPVisitsToday) ?></b> <br> <?PHP echo _YESTERDAY ?> : <b><?php echo number_format($TotalPVisitsYesterday) ?></b><br>
					<?PHP echo _AVERAGE ?> : <b><?php if (!empty($a)) {
													echo number_format(round($TotalPVisitsToday / $a));
												} else {
													echo _NO_CONTENT;
												} ?></b><br>
					<?PHP echo _STAT_CHART_VISITED_ALL ?>: <b><?php echo number_format($totalPVisits) ?></b>
					<hr>
					<div style="overflow:auto;height:150px;"><?php echo $HitsListsV; ?><br></div>
					<img src='images/icon/bullet_error.png'><?PHP echo _STAT_CHART_LISTENEDIN ?><span style="color:red"><b><?php echo  $a ?> </b><?PHP echo _STAT_CHART_LISTENEDINDAY ?></span>
				</td>
				<td style="width:50%;<?php echo $classfornotfollowingiptracking; ?>" class="box_wrapper" id="box_wrapper"><br><br>
					<h3>
						<?PHP echo _STAT_CHART_USERS_LINE ?>
					</h3>
					<br>
					<center>
						<div id="line_chart"></div>
					</center>
					<br>

					<img src='images/icon/chart_bar.png'>
					<?PHP echo _STAT_CHART_SUMMMARY ?><br>
					<img src='images/icon/chart_curve.png'><?PHP echo _STAT_CHART_UNIQUE_USERS ?>:<br>
					<?PHP echo _TODAY ?> : <b><?php echo number_format($TotalVisitsToday) ?></b><br> <?PHP echo _YESTERDAY ?> : <b><?php echo number_format($TotalVisitsYesterday) ?></b><br>
					<?PHP echo _AVERAGE ?>: <b><?php if (!empty($a)) {
													echo number_format(round($totalVisits / $a));
												} else {
													echo _NO_CONTENT;
												} ?></b><br>
					<?PHP echo _STAT_CHART_VISITORS_ALL ?>: <b><?php echo number_format($totalVisits) ?></b>
					<hr>
					<div style="overflow:auto;height:150px;">
						<?php echo $visitListsV; ?>
					</div>
					<img src='images/icon/bullet_error.png'><?PHP echo _STAT_CHART_LISTENEDIN ?><span style="color:red"><b><?php echo  $a ?> </b><?PHP echo _STAT_CHART_LISTENEDINDAY ?></span>
				</td>

			</tr>
			<tr>

				<td style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>

					<h3>
						<?PHP echo _STAT_CHART_OS_CIRCLE ?>
					</h3>
					<center>
						<div id="pie_chart1"></div>
					</center>
					<?php


					$chartcolor = 		array(
						'#00BAFF',    // <-- blue windows - bing - msie
						'#FF0600',    // <-- red  linux -  google - chrome
						'#FFD508',    // <-- yellow mac - yahoo - firefox
						'#52C230',    // <-- green freebsd - - opera
						'#B39C86',   // <-- brown sunos -konquer 
						'#6C6C6C',   // <-- gray other - bot
						'#F7F6EB'   // <-- other 
					);


					echo '<div style="text-align:left">
   <span class="break" style="color:white;background:' . $chartcolor[0] . '"> Windows : <b>' . $windows . '</b></span>
  <span class="break" style="color:white;background:' . $chartcolor[1] . '">  linux : <b>' . $linux . '</b></span>
     <span class="break"  style="background:' . $chartcolor[2] . '"> mac :<b>' . $mac . '</b></span>
    <span class="break" style="color:white;background:' . $chartcolor[4] . '">sunos :<b>' . $sunos . '</b></span>
	   <span class="break"  style="color:black;background:' . $chartcolor[6] . '">' . _OTHER . ' :<b>' . $os_other . '</b></span><br></div>';

					?>
				</td>

				<td style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>
					<h3>
						<?PHP echo _STAT_CHART_BROWSERS_CIRCLE ?>
					</h3>
					<center>
						<div id="pie_chart2"></div>
					</center>
					<?php
					echo '<div style="text-align:left">
    <span class="break" style="color:white;background:' . $chartcolor[0] . '">MS IE : <b>' . $msie . '</b></span>
    <span class="break" style="background:' . $chartcolor[2] . '">Firefox : <b>' . $firefox . '</b></span>
    <span class="break"  style="color:white;background:' . $chartcolor[1] . '">Google Chrome :<b>' . $Chrome . '</b></span>
    <span class="break" style="background:' . $chartcolor[3] . '">Opera :<b>' . $opera . '</b></span>
    <span class="break" style="color:white;background:' . $chartcolor[5] . '">' . _ROBOTS . ':<b>' . $bot . '</b></span>
    <span class="break"  style="color:black;background:' . $chartcolor[6] . '">' . _OTHER . ' :<b>' . $b_other . '</b></span><br></div>';
					?>
				</td>

			</tr>

			<tr>
				<td style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>

					<h3>
						<?PHP echo _STAT_CHART_SE_CIRCLE ?>:
					</h3>
					<center>
						<div id="pie_chart3"></div>
					</center>
					<?php

					echo '<div style="text-align:left">
    <span class="break" style="color:white;background:' . $chartcolor[1] . '">Google : <b>' . $google . '</b></span>
    <span class="break"  style="color:white;background:' . $chartcolor[2] . '">yahoo :<b>' . $yahoo . '</b></span>
    <span class="break" style="color:black;background:' . $chartcolor[3] . '">bing : <b>' . $bing . '</b></span>
    <span class="break"  style="background:' . $chartcolor[4] . '">' . _OTHER . ' :<b>' . $se_other . '</b></span><br></div>';

					?>
				</td>

				<td style="width:50%" class="box_wrapper" id="box_wrapper"><br><br>
					<h3>
						<?PHP echo _OTHER ?>:
					</h3>
					<?php

					echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\"><tr><td colspan=\"2\">\n";
					echo "<tr><td><img src=\"images/icon/user.png\" border=\"0\" alt=\"\">&nbsp;" . _USERS . " </td><td><b>" . $GeneralStat['TotalUsers'] . "</b></td></tr>\n";
					echo "<tr><td><img src=\"images/icon/user_gray.png\" border=\"0\" alt=\"\">&nbsp;" . _AUTHOR . "</td><td><b>" . $GeneralStat['TotalAuthors'] . "</b></td></tr>\n";
					echo "<tr><td><img src=\"images/icon/note.png\" border=\"0\" alt=\"\">&nbsp;" . _ARTICLES . "</td><td><b>" . $GeneralStat['TotalStories'] . "</b></td></tr>\n";
					if (is_active("Topics")) {
						echo "<tr><td><img src=\"images/icon/note.png\" border=\"0\" alt=\"\">&nbsp;" . _TOPICS . "</td><td><b>" . $GeneralStat['TotalTopics'] . "</b></td></tr>\n";
					}

					echo "<tr><td><img src=\"images/icon/tag_green.png\" border=\"0\" alt=\"\">&nbsp;" . _KEYWORDS . "</td><td><b>" . $GeneralStat['TotalTags'] . "</b></td></tr>\n";
					echo "<tr><td>  <a href='" . ADMIN_OP . "hreferer' class='colorbox'><img src='images/icon/arrow_out.png'> " . _STAT_REFERAL_LIST . " </a></td></tr>\n";
					echo "</table>\n";
					?>
					<!--<img src='images/icon/chart_line.png'> بهترین ارجاع دهنده ها :<br> <br><?php //echo $topreferer 
																								?></b><br><hr>
<img src='images/icon/chart_line.png'> فعال ترین اعضا :<br><br> <?php //echo $topusers 
																?></b><br> -->

				</td>
			</tr>
		</table>
	<?php


	}
	function hreferer()
	{
		global $prefix, $db, $admin_file;

		$result = $db->sql_query("SELECT ipid,referer from " . $prefix . "_iptracking WHERE referer!=''");
		$num = $db->sql_numrows($result);
		if ($num > 0) {
			OpenTable();
			echo "<div style='border:0px; height:100%; padding-right:12px; overflow:auto;'><ul>";
			echo "<center><b>" . _WHOLINKS . "</b></center><br>";
			$i = 0;
			while (list($id, $url) = $db->sql_fetchrow($result)) {
				$id = sql_quote(intval($id));
				$url = sql_quote($url);
				$url_name = substr($url, 0, 50) . '...';
				echo "<li style='background:#CCF0FF;border:1px solid white;padding:5px;'><b>" . $i++ . " - </b><a href=\"$url\" target=\"_blank\">$url_name</a></li>";
			}
			echo "</ul></div>"
				. "<center><a href='" . $admin_file . ".php?op=delreferer' class='button'>" . _DELETEREFERERS . "</a></center>";
		} else {

			echo "<div>" . NO_REFERER . "</div>";
		}

		CloseTable();
	}
	function delreferer()
	{
		global $prefix, $db, $admin_file;
		$db->sql_query("update " . $prefix . "_iptracking set referer = '' WHERE referer != ' '");
		Header("Location: " . ADMIN_OP . "adminMain");
	}
	function GAS()
	{
		session_start();
		$_SESSION = array();
	?>
		<div>
			<p>نام کاربری و رمز عبور اکانت گوگل خود را وارید کنید .</p>
			<form method="post" action="includes/statistics/analytics_data.php" style="direction:ltr;">
				<label for="username">E-mail</label><input type="text" name="username" id="username">
				<label for="password">Password</label><input type="password" name="password" id="password">
				<input type="submit" id="submit" value="Log in">
			</form>
		</div>
		<?php
		highlight_file('example.php');
	}
	function phpinfoDIV()
	{
		phpinfo();
	}
	function Stat_Synchronization()
	{
		global $db, $admin_file, $prefix;
		include_once('header.php');
		GraphicAdmin();
		$doaction = 0;

		OpenTable();
		echo "<h3>" . _STAT_SYNC_START . "</h3>";
		if ($_POST['doaction'] == 1) {

			$statRowT = $db->sql_fetchrow($db->sql_query("SELECT COUNT(DISTINCT ip_address) AS TotalVisits,COUNT(ip_address) AS TotalPVisits FROM " . $prefix . "_iptracking "));
			list($GoogleBot) = $db->sql_fetchrow($db->sql_query("(SELECT COUNT(hostname) AS GoogleBot FROM " . $prefix . "_iptracking WHERE hostname LIKE '%google%')"));
			list($YahooBot) = $db->sql_fetchrow($db->sql_query("(SELECT COUNT(hostname) AS YahooBot FROM " . $prefix . "_iptracking WHERE hostname LIKE '%yahoo%')"));
			list($MsnBot) = $db->sql_fetchrow($db->sql_query("(SELECT COUNT(hostname) AS MsnBot FROM " . $prefix . "_iptracking WHERE hostname LIKE '%msn%')"));

			$TotalPVisits = intval($statRowT['TotalPVisits']);
			$TotalVisits = intval($statRowT['TotalVisits']);

			echo "<div class='notify'><center>
			کل بازدیدهای صفحات : <b>$TotalPVisits</b><br>
			کل بازدیدکنندگان: <b>$TotalVisits</b><br>
			صفحات بازدیدشده گوگل: <b>$GoogleBot</b><br>
			صفحات بازدیدشده یاهو: <b>$YahooBot</b><br>
			صفحات بازدیدشده مایکروسافت: <b>$MsnBot</b><br>";

			$db->sql_query("UPDATE " . $prefix . "_counter SET count='$TotalPVisits' WHERE (type='total' AND var='pageviews')");
			$db->sql_query("UPDATE " . $prefix . "_counter SET count='$TotalVisits' WHERE (type='total' AND var='visits')");
			$db->sql_query("UPDATE " . $prefix . "_counter SET count='$GoogleBot' WHERE (type='se' AND var='google')");
			$db->sql_query("UPDATE " . $prefix . "_counter SET count='$YahooBot' WHERE (type='se' AND var='yahoo')");
			$db->sql_query("UPDATE " . $prefix . "_counter SET count='$MsnBot' WHERE (type='se' AND var='bing')");
			$db->sql_query("UPDATE " . $prefix . "_counter SET count='1' WHERE (type='config' AND var='Synchronization')");

			echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL=$admin_file.php?op=StatMain\">";
		} else {
		?>
			<form action="<?php echo $admin_file ?>.php?op=Stat_Synchronization" method="POST">
				<center>
					<?php echo _SYNCSTAT; ?><br><br>
					<img src='images/icon/accept.png'><?php echo _CHECK2WIZ ?><br><br>
					<hr>
					<input type="hidden" name="doaction" value="1">
					<input type="submit" value="<?php echo _STAT_SYNC_START ?>">
				</center>
			</form>
<?php
		}
		CloseTable();
	}
	function chartDATA($chartTitle, $chartType, $chartValue)
	{

		include 'includes/openChart/data.php';

		global $db, $prefix;
		global $db, $prefix;

		$result = $db->sql_query("SELECT type, var, count from " . $prefix . "_counter order by type desc");
		while ($row = $db->sql_fetchrow($result)) {
			$type = check_words(check_html($row['type'], "nohtml"));
			$var = check_words(check_html($row['var'], "nohtml"));
			$count = intval($row['count']);
			if (($type == "config") && ($var == "Synchronization")) {
				$Synchronization = $count;
			} elseif (($type == "total") && ($var == "visits")) {
				$totalVisits = $count;
			} elseif (($type == "total") && ($var == "pageviews")) {
				$totalPVisits = $count;
			} elseif ($type == "browser") {
				if ($var == "FireFox") {
					$firefox = $count;
				} elseif ($var == "Chrome") {
					$Chrome = $count;
				} elseif ($var == "MSIE") {
					$msie = $count;
				} elseif ($var == "Konqueror") {
					$konqueror = $count;
				} elseif ($var == "Opera") {
					$opera = $count;
				} elseif ($var == "Lynx") {
					$lynx = $count;
				} elseif ($var == "Bot") {
					$bot = $count;
				} elseif (($type == "browser") && ($var == "Other")) {
					$b_other = $count;
				}
			} elseif ($type == "os") {
				if ($var == "Windows") {
					$windows = $count;
				} elseif ($var == "Mac") {
					$mac = $count;
				} elseif ($var == "Linux") {
					$linux = $count;
				} elseif ($var == "FreeBSD") {
					$freebsd = $count;
				} elseif ($var == "SunOS") {
					$sunos = $count;
				} elseif ($var == "IRIX") {
					$irix = $count;
				} elseif ($var == "BeOS") {
					$beos = $count;
				} elseif ($var == "OS/2") {
					$os2 = $count;
				} elseif ($var == "AIX") {
					$aix = $count;
				} elseif (($type == "os") && ($var == "Other")) {
					$os_other = $count;
				}
			} elseif ($type == "se") {
				if ($var == "google") {
					$google = $count;
				} elseif ($var == "yahoo") {
					$yahoo = $count;
				} elseif ($var == "bing") {
					$bing = $count;
				} elseif (($type == "se") && ($var == "other")) {
					$se_other = $count;
				}
			}
		}

		$db->sql_freeresult($result);

		if ($Synchronization == 0) {
			echo "<div class='notify'><img src='images/icon/note.png'><a href='" . ADMIN_OP . "Stat_Synchronization'>
			" . _STAT_SYNC . "
			</a></div>";
		}



		//Hamed: since the previous query wasn't working I came up with this one that makes less query(half the previous one) and yaay it's working.
		//fist we have to play a little bit with the date
		//Farshad : what about a better look at our query ?! :D



		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', time() - (3600 * 24));
		//this is the mighty query
		//SURE IT IS AND IT'S POWERED BY MINE :D
		$GeneralStat = $db->sql_fetchrow($db->sql_query("
		SELECT (SELECT COUNT(*) from " . $prefix . "_users) TotalUsers,
       (SELECT COUNT(*) from  " . STORY_TABLE . ") TotalStories,
       (SELECT COUNT(*) from " . COMMENTS_TABLE . ") totalcomm,
       (SELECT COUNT(*) from " . DOWNLOAD_TABLE . ") totalfiles,
       (SELECT COUNT(*) from " . $prefix . "_session) totalonlines,
       (SELECT COUNT(*) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tuv,
       (SELECT COUNT(*) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yv,
       (SELECT COUNT(DISTINCT `ip_address`) FROM " . $prefix . "_iptracking WHERE date_time BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yuv,
       (SELECT COUNT(*) from " . $prefix . "_session WHERE session_user_id > 0 ) uonline,
       (SELECT COUNT(*) from " . $prefix . "_session WHERE session_user_id = '0' ) gonline,
       (SELECT `count` from " . $prefix . "_counter WHERE type = 'total' AND var = 'visits') totalVisits,
       (SELECT `count` from " . $prefix . "_counter WHERE type = 'total' AND var = 'pageviews') totalPVisits,
       (SELECT COUNT(*) from " . $prefix . "_authors ) TotalAuthors,
       (SELECT COUNT(*) from " . $prefix . "_topics) TotalTopics,
       (SELECT COUNT(*) from " . $prefix . "_tags) TotalTags;
  "));


		$tdy = $db->sql_fetchrow($sres);
		$TotalVisitsToday = $GeneralStat['tuv'];
		$TotalPVisitsToday = $GeneralStat['tv'];
		$TotalVisitsYesterday = $GeneralStat['yuv'];
		$TotalPVisitsYesterday = $GeneralStat['yv'];
		$TotalCrawlers = $GeneralStat['TotalCrawlers'];

		/// LIST ALL VISITS PER LISTENED DAYS
		$result = $db->sql_query("SELECT DATE(date_time) as date, COUNT(DISTINCT ip_address) AS TotalVisitsToday, COUNT(ip_address) AS TotalPVisitsToday  FROM " . $prefix . "_iptracking GROUP BY date ORDER BY date_time ASC");
		$a = 0;
		$array_chart_v = array();
		$array_chart_pv = array();
		$array_chart_day = array();
		while ($row = $db->sql_fetchrow($result)) {
			$a++;
			$date = $row['date'];


			$array_chart_v[] = intval($row['TotalVisitsToday']);
			$array_chart_pv[] = intval($row['TotalPVisitsToday']);
			$array_chart_day[] = $row['date'];


			$TotalVisitsTodaycount = $row['TotalVisitsToday'];
			$TotalPVisitsTodaycount = $row['TotalPVisitsToday'];

			$dateArr = explode(' ', $date);
			$comma = ($a == 1) ? "" : ",";

			$visitLists .= "$comma$TotalVisitsTodaycount";
			$visitListsV .= "<img src='images/icon/time.png'>" . hejridate($dateArr[0], 1) . "<img src='images/icon/bullet_orange.png'>[<b>" . number_format($TotalVisitsTodaycount) . "</b>]<br>";

			$HitsLists .= "$comma$TotalPVisitsTodaycount";
			$HitsListsV .= "<img src='images/icon/time.png'>" . hejridate($dateArr[0], 1) . "<img src='images/icon/bullet_orange.png'>[<b>" . number_format($TotalPVisitsTodaycount) . "</b>]<br>";
		}

		$db->sql_freeresult($result);



		$chartArraySO = array(intval($windows), intval($linux), intval($mac), intval($freebsd), intval($sunos), intval($os2), intval($os_other));
		$chartArraySE = array(intval($bing), intval($google), intval($yahoo), intval($se_other));
		$chartArrayBS = array(intval($msie), intval($Chrome), intval($firefox), intval($opera), intval($Konqueror), intval($bot), intval($b_other));





		//$chartValue = ($chartValue=="array_chart_v") ? $array_chart_v : ($chartValue=="array_chart_pv") ? $array_chart_pv :  ($chartValue=="chartArraySE") ? array($chartArraySE) : ($chartValue=="chartArraySO") ? array($chartArraySO) : ($chartValue=="chartArrayBrowsers") ? array($chartArrayBrowsers) : "" ;

		if ($chartValue == "array_chart_v") {
			$chartValue = $array_chart_v;
		} elseif ($chartValue == "array_chart_pv") {
			$chartValue = $array_chart_pv;
		} elseif ($chartValue == "chartArraySE") {
			$chartValue = $chartArraySE;
		} elseif ($chartValue == "chartArrayBS") {
			$chartValue = $chartArrayBS;
		} elseif ($chartValue == "chartArraySO") {
			$chartValue = $chartArraySO;
		} else {
			$chartValue = "";
		}


		switch ($chartType) {

			case "bar":

				// ----- BAR CHART ----------
				$bar = new bar_value(5);
				$bar->set_colour('#900000');
				$bar->set_tooltip($array_chart_day . '<br>#val#');
				$data[] = $bar;
				$title = new title($chartTitle);
				$bar = new bar_3d();
				$bar->set_values($chartValue);
				$bar->colour = '#D54C78';
				$x_axis = new x_axis();
				$x_axis->set_3d(5);
				$x_axis->colour = '#909090';
				$x_axis->set_labels($chartValue);
				$y = new y_axis();
				$y->set_range(0, 10000);
				$chart = new open_flash_chart();
				$chart->set_y_axis($y);
				$chart->set_title($title);
				$chart->add_element($bar);
				$chart->set_x_axis($x_axis);
				echo $chart->toPrettyString();



				break;

			case "pie":

				$pie = new pie();
				$pie->start_angle(35)
					->add_animation(new pie_fade())
					->add_animation(new pie_bounce(6))
					// ->label_colour('#432BAF') // <-- uncomment to see all labels set to blue
					->gradient_fill()
					->tooltip('#val# of #total#<br>#percent# of 100%')
					->colours(
						array(
							'#00BAFF',    // <-- blue windows - bing - msie
							'#FF0600',    // <-- red  linux -  google - chrome
							'#FFD508',    // <-- yellow mac - yahoo - firefox
							'#52C230',    // <-- green freebsd - - opera
							'#B39C86',   // <-- brown sunos -konquer 
							'#6C6C6C',   // <-- gray other - bot
							'#F7F6EB'   // <-- other 
						)
					);

				$pie->set_values($chartValue);
				$chart = new open_flash_chart();
				$chart->add_element($pie);
				echo $chart->toPrettyString();

			case "line":
				$default_dot = new dot();
				$default_dot->size(5)->colour('#DFC329');
				$line_dot = new line();
				$line_dot->set_default_dot_style($default_dot);
				$line_dot->set_width(4);
				$line_dot->set_colour('#DFC329');
				$line_dot->set_values($chartValue);
				$line_dot->set_key("Line 1", 10);
				$y = new y_axis();
				$y->set_range(0, 1000);
				$chart = new open_flash_chart();
				$chart->set_title(new title($chartTitle));
				$chart->set_y_axis($y);
				$chart->add_element($line_dot);
				echo $chart->toPrettyString();

				break;
		}
	}

	switch ($op) {

		case "hreferer":
			hreferer();
			break;

		case "Stat_Synchronization":
			Stat_Synchronization();
			break;

		case "delreferer":
			delreferer();
			break;

		case "GAS":
			GAS();
			break;

		case "phpinfoDIV":
			phpinfoDIV();
			break;

		case "StatMain":
			StatMain();
			break;

		case "chartDATA":
			chartDATA($chartTitle, $chartType, $chartValue);
			break;
	}
} else {
	echo "Access Denied";
}
?>