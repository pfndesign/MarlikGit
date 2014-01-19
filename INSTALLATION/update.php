<?php
/**
*
* @package Update
* @copyright (c) Nukelearn Group  http://www.nukelearn.com $Aneeshtan
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
global $admin,$prefix;
if (is_superadmin($admin)) {
	list($nlVersion) = $db->sql_fetchrow($db->sql_query("SELECT USV_Version FROM  ".$prefix."_config LIMIT 1"));
	define("NL_VERSION",$nlVersion);
	define("_GOBACK2","<a href='install.php?update=1'>بازگشت به صفحه ارتقا</a>")
	?>
	<center>
	<div class="sidebox" style="background:#BCE1F6" >
	<span style='text-align:center;'>
	<p>ارتقا پرتال نیوک لرن به نسخه های گوناگون در این بخش فراهم آمده است . 
	<br>
	شما در این بخش می توانید فایل های یک نسخه خاص را منتقل کنید و دیتابیس را به نسخه بالاتر ارتقا بدهید
	<br>
	این برنامه به صورت خودکار نسخه کنونی سایت شما را حدس می زند و شما نیازمند ارتقا به یک نسخه بالاتر هستید تا به آخرین 
	نسخه موجود برسید.
	</p>
	</span>
	</center>
	<?php echo $pagetitle;
	$pagetitle = "اسکریپت ارتقا نیوک لرن";
	title("$pagetitle");
	echo "<table align='center' border='0'>\n";
	echo "<form action='install.php' method='GET'>\n";
	echo "<tr><td align='center'><font color='red'>بهتر است اول از ديتابيس خود پشتيباني بگيريد</font><br>
       	<br></td></tr>\n";
	echo "<tr><td align='center'> نسخه کنونی شما   :
        <span style='font-size:20px;color:green'><b>".NL_VERSION."</b></span><br>
        </td></tr>\n";
	echo "<tr><td></td></tr>\n";
	echo "<tr><td align='center'>
       		<select id='act' name='act' style='width:200px;'>\n";
	echo "<option value='upgrade_1_1_0'>ارتقا به 1.1.0</option>\n";
	echo "<option value='upgrade_1_1_1'>ارتقا به 1.1.1</option>\n";
	echo "<option value='upgrade_1_1_2'>ارتقا به 1.1.2</option>\n";
	echo "<option value='upgrade_1_1_3'>ارتقا به 1.1.3</option>\n";
	echo "<option value='upgrade_1_1_4'>ارتقا به 1.1.4</option>\n";
	echo "<option value='upgrade_1_1_5'>ارتقا به 1.1.5</option>\n";
	echo "</select> 
	<input type='hidden' name='update' value='1'>
       		<input type='submit' value='شروع نصب ارتقا'></td></tr>\n";
	echo "</form>";
	echo "</table>\n";
	
	
	switch($_GET['act']) {
		case "upgrade_1_1_0":
		       		$pagetitle = "ارتقا به 1.1.0";
		title("$pagetitle<br>"._GOBACK2);
		$sql_queue = array("
        ALTER TABLE `nuke_comments_moderated`
        ADD COLUMN `active` int(1)   NOT NULL DEFAULT '0' after `sid`,
        CHANGE `date` `date` datetime   NULL after `active`,
        CHANGE `name` `name` varchar(60)  COLLATE utf8_bin NOT NULL after `date`,
        CHANGE `email` `email` varchar(60)  COLLATE utf8_bin NULL after `name`,
        CHANGE `url` `url` varchar(60)  COLLATE utf8_bin NULL after `email`,
        CHANGE `host_name` `host_name` varchar(60)  COLLATE utf8_bin NULL after `url`,
        CHANGE `subject` `subject` varchar(85)  COLLATE utf8_bin NOT NULL after `host_name`,
        CHANGE `comment` `comment` text  COLLATE utf8_bin NOT NULL after `subject`,
        CHANGE `score` `score` tinyint(4)   NOT NULL DEFAULT '0' after `comment`,
        CHANGE `reason` `reason` tinyint(4)   NOT NULL DEFAULT '0' after `score`,
        CHANGE `last_moderation_ip` `last_moderation_ip` varchar(15)  COLLATE utf8_bin NULL DEFAULT '0' after `reason`, COMMENT='';
","
        ALTER TABLE `nuke_config`
        ADD COLUMN `USV_Version` varchar(15)  COLLATE utf8_bin NOT NULL after `copyright`,
        CHANGE `support` `support` varchar(30)  COLLATE utf8_bin NOT NULL after `USV_Version`,
        DROP COLUMN `INPNuke_VN`, COMMENT='';
","
        CREATE TABLE IF NOT EXISTS  `nuke_contact_us`(
        `pid` int(3) NOT NULL  auto_increment ,
        `name` varchar(255) COLLATE utf8_bin NULL  ,
        `phone_num` varchar(60) COLLATE utf8_bin NULL  ,
        `fax_num` varchar(255) COLLATE utf8_bin NULL  ,
        `yahoo_id` varchar(255) COLLATE utf8_bin NOT NULL  ,
        `gmail_id` varchar(255) COLLATE utf8_bin NOT NULL  ,
        `dept_name` varchar(255) COLLATE utf8_bin NOT NULL  ,
        `dept_email` varchar(255) COLLATE utf8_bin NOT NULL  ,
        `address` text COLLATE utf8_bin NOT NULL  ,
        `showaddress` int(1) NOT NULL  DEFAULT '0' ,
        PRIMARY KEY (`pid`) ,
        KEY `pid`(`pid`)
        ) ENGINE=MyISAM DEFAULT CHARSET='utf8';
","
        ALTER TABLE `nuke_groups`
        ADD COLUMN `posts` int(8)   NOT NULL after `points`,
        ADD COLUMN `members` text  COLLATE utf8_bin NOT NULL after `posts`,
        ADD COLUMN `point_amount` text  COLLATE utf8_bin NOT NULL after `members`, COMMENT='';
","
        CREATE TABLE IF NOT EXISTS  `nuke_keywords`(
        `mid` int(10) NOT NULL  auto_increment ,
        `title` varchar(255) COLLATE utf8_general_ci NOT NULL  DEFAULT '' ,
        `keywords` text COLLATE utf8_general_ci NOT NULL  ,
        `description` text COLLATE utf8_general_ci NOT NULL  ,
        PRIMARY KEY (`mid`)
        ) ENGINE=InnoDB DEFAULT CHARSET='utf8';
","
        CREATE TABLE IF NOT EXISTS  `nuke_keywords_main`(
        `keywords` text COLLATE utf8_general_ci NOT NULL  ,
        `description` text COLLATE utf8_general_ci NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET='utf8';
","
        ALTER TABLE `nuke_nsngd_downloads`
        ADD COLUMN  `password` varchar(255)  COLLATE utf8_bin NOT NULL after `active`,
        ADD COLUMN  `source` varchar(255)  COLLATE utf8_bin NOT NULL after `password`,
        ADD COLUMN  `tags` varchar(256)  COLLATE utf8_bin NOT NULL after `source`, COMMENT='';
","
        ALTER TABLE `nuke_poll_data`
        CHANGE `optionText` `optionText` char(50)  COLLATE utf8_bin NOT NULL after `pollID`, COMMENT='';
","
        CREATE TABLE IF NOT EXISTS  `nuke_ratings`(
        `id` int(11) NOT NULL  auto_increment ,
        `rating_id` int(11) NOT NULL  DEFAULT '0' ,
        `rating_num` int(11) NOT NULL  DEFAULT '0' ,
        `section` int(1) NOT NULL  DEFAULT '0' ,
        `ip` varchar(25) COLLATE utf8_bin NOT NULL  ,
        `voter` varchar(256) COLLATE utf8_bin NOT NULL  ,
        PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET='utf8';
","
        CREATE TABLE IF NOT EXISTS  `nuke_squestions`(
        `qid` int(2) NOT NULL  auto_increment ,
        `question` varchar(256) COLLATE utf8_bin NOT NULL  ,
        `answer` varchar(256) COLLATE utf8_bin NOT NULL  ,
        PRIMARY KEY (`qid`)
        ) ENGINE=MyISAM DEFAULT CHARSET='utf8';
","
        ALTER TABLE `nuke_stories`
        ADD COLUMN  `newsref` varchar(100)  COLLATE utf8_bin NULL after `bodytext`,
        ADD COLUMN  `newsreflink` varchar(200)  COLLATE utf8_bin NULL after `newsref`,
        CHANGE `comments` `comments` int(11)   NULL DEFAULT '0' after `newsreflink`,
        CHANGE `counter` `counter` mediumint(8) unsigned   NULL after `comments`,
        CHANGE `topic` `topic` int(3)   NOT NULL DEFAULT '1' after `counter`,
        CHANGE `informant` `informant` varchar(25)  COLLATE utf8_bin NOT NULL after `topic`,
        CHANGE `notes` `notes` text  COLLATE utf8_bin NOT NULL after `informant`,
        CHANGE `ihome` `ihome` int(1)   NOT NULL DEFAULT '0' after `notes`,
        CHANGE `alanguage` `alanguage` varchar(30)  COLLATE utf8_bin NOT NULL after `ihome`,
        CHANGE `acomm` `acomm` int(1)   NOT NULL DEFAULT '0' after `alanguage`,
        ADD COLUMN  `hotnews` int(1)   NOT NULL DEFAULT '0' after `acomm`,
        CHANGE `haspoll` `haspoll` int(1)   NOT NULL DEFAULT '0' after `hotnews`,
        CHANGE `pollID` `pollID` int(10)   NOT NULL DEFAULT '0' after `haspoll`,
        CHANGE `associated` `associated` text  COLLATE utf8_bin NOT NULL after `pollID`,
        ADD COLUMN  `tags` varchar(255)  COLLATE utf8_bin NOT NULL after `associated`,
        ADD COLUMN  `approved` tinyint(1)   NOT NULL DEFAULT '1' after `tags`,
        ADD COLUMN  `section` varchar(15)  COLLATE utf8_bin NOT NULL DEFAULT 'news' after `approved`,
        DROP COLUMN `score`,
        DROP COLUMN `ratings`,
        DROP COLUMN `rating_ip`, COMMENT='';
","
        CREATE TABLE IF NOT EXISTS  `nuke_tags`(
        `tid` int(5) NOT NULL  auto_increment ,
        `tag` varchar(255) COLLATE utf8_bin NOT NULL  ,
        `slug` varchar(255) COLLATE utf8_bin NOT NULL  ,
        `count` int(6) NOT NULL  ,
        PRIMARY KEY (`tid`)
        ) ENGINE=MyISAM DEFAULT CHARSET='utf8';
","
        ALTER TABLE `nuke_users`
        CHANGE `name` `name` varchar(60)  COLLATE utf8_bin NULL after `user_id`,
        CHANGE `username` `username` varchar(25)  COLLATE utf8_bin NULL after `name`,
        CHANGE `user_email` `user_email` varchar(255)  COLLATE utf8_bin NULL after `username`,
        CHANGE `femail` `femail` varchar(255)  COLLATE utf8_bin NULL after `user_email`,
        CHANGE `user_website` `user_website` varchar(255)  COLLATE utf8_bin NULL after `femail`,
        CHANGE `user_avatar` `user_avatar` varchar(255)  COLLATE utf8_bin NULL after `user_website`,
        CHANGE `user_regdate` `user_regdate` varchar(20)  COLLATE utf8_bin NULL after `user_avatar`,
        CHANGE `user_interests` `user_interests` varchar(150)  COLLATE utf8_bin NULL after `user_from_flag`,
        CHANGE `user_password` `user_password` varchar(40)  COLLATE utf8_bin NULL after `user_msnm`,
        CHANGE `umode` `umode` varchar(10)  COLLATE utf8_bin NULL after `storynum`,
        CHANGE `bio` `bio` tinytext  COLLATE utf8_bin NULL after `noscore`,
        CHANGE `ublock` `ublock` tinytext  COLLATE utf8_bin NULL after `ublockon`,
        CHANGE `theme` `theme` varchar(255)  COLLATE utf8_bin NULL after `ublock`,
        CHANGE `user_location` `user_location` varchar(255)  COLLATE utf8_bin NULL after `user_lastaction`,
        DROP COLUMN `user_thanks_received`,
        DROP COLUMN `user_thanks_given`, COMMENT='';
","
        UPDATE `nuke_comments_moderated` SET `active`='1' ;
","
        UPDATE `nuke_users` SET `theme` = '';
","
        UPDATE `nuke_config` SET `Default_Theme` = 'USV-classio' LIMIT 1 ;
","
        UPDATE `nuke_config` SET `USV_Version` = '1.1.0' LIMIT 1 ;
","
        UPDATE `nuke_config` SET `support` = 'info@nukelearn.com' LIMIT 1 ;
","
        UPDATE `nuke_config` SET `copyright` = 'Nukelearn USV &copy; 2009-2010 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>' LIMIT 1 ;
","
        INSERT INTO `nuke_modules` (`mid`, `title`, `custom_title`, `active`, `view`, `inmenu`, `mod_group`, `admins`) VALUES
        (NULL , 'phpBB3', 'phpBB3', 1, 0, 1, 0, '');
","
        DROP TABLE IF EXISTS `nuke_reviews`;
 ","       DROP TABLE IF EXISTS `nuke_reviews_add`;
 ","       DROP TABLE IF EXISTS `nuke_reviews_comments`;
 ","       DROP TABLE IF EXISTS `nuke_reviews_comments_moderated`;
 ","       DROP TABLE IF EXISTS `nuke_reviews_main`;
 ","       DROP TABLE IF EXISTS `nuke_stats_date`;
 ","       DROP TABLE IF EXISTS `nuke_stats_hour`;
 ","       DROP TABLE IF EXISTS `nuke_stats_month`;
 ","       DROP TABLE IF EXISTS `nuke_stats_year`;
 ","       DROP TABLE IF EXISTS `nuke_subscriptions`;
 ","       DROP TABLE IF EXISTS `nuke_journal`;
 ","       DROP TABLE IF EXISTS `nuke_journal_comments`;
 ","       DROP TABLE IF EXISTS `nuke_journal_stats`;
 ","       DROP TABLE IF EXISTS `nuke_dis_er`;
 ","       DROP TABLE IF EXISTS `nuke_comments`;
 ","       DROP TABLE IF EXISTS `nuke_autonews`;
  ","      ALTER TABLE `nuke_config` ADD `gfx_chk` TINYINT( 1 ) NOT NULL DEFAULT '1';
  ","      ALTER TABLE `nuke_config` ADD `use_question` INT( 1 ) NOT NULL DEFAULT '0';
  ","      ALTER TABLE `nuke_config` ADD `codesize` INT( 1 ) NOT NULL DEFAULT '4';
   ","     ALTER TABLE `nuke_config` ADD `cache_system` TINYINT( 1 ) NOT NULL DEFAULT '0';
   ","     ALTER TABLE `nuke_config` ADD `cache_lifetime` INT( 8 ) NOT NULL DEFAULT '120';
   ","     ALTER TABLE `nuke_config` ADD `nuke_editor` INT( 1 ) NOT NULL DEFAULT '1';
	");
		echo "<hr />\n";
		for ($i=0; $i < count($sql_queue); $i++) {
			$classrow = ($i%2) ? "class=\"oddrow\"" : "class=\"evenrow\"";
			$sql = $sql_queue[$i];
			if (!$db->sql_query($sql)) {
				$error = $db->sql_error();
				$error = $error['message'];
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				$error_info = (substr_count($error, 'Duplicate entry') || substr_count($error, 'already exists')) ? '<br><b>تحلیل:</b><span class="gen">از قبل اطلاعات درخواستی شما موجود است و نیاز به جایگزینی مجدد نمی باشد !</span>' : '';
				echo "<div $classrow>[<font color=\"red\">خطا</font>] <span class=\"gensmall\">:: $sql</span><br />
		<b>علت خطا:</b><span class=\"gen\">$error</span>
		$error_info<br /></div><br />";
			} else {
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				print "<div $classrow>".'[<font color="green" >موفقیت آمیز</font>] :: ' . $sql . '</div><br />';
			}
		}
		break;
		case "upgrade_1_1_1":
		       		$pagetitle = "ارتقا به 1.1.1";
		title("$pagetitle<br>"._GOBACK2);
		$sql_queue = array("
DROP TABLE IF EXISTS `nuke_iptracking`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_iptracking` (
  `ipid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `referer` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page` varchar(150) NOT NULL,
  `page_title` varchar(150) NOT NULL,
  PRIMARY KEY (`ipid`),
  KEY `ipid` (`ipid`),
  KEY `i1iptracking` (`ip_address`,`hostname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
"," 
DROP TABLE IF EXISTS `nuke_jcalendar_events`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_jcalendar_events` (
  `eid` smallint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `repeat_type` enum('off','daily','weekly','monthly','yearly') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'off',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `holiday` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
"," 
DROP TABLE IF EXISTS `nuke_referer`;
"," 
DROP TABLE IF EXISTS `nuke_session`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_session` (
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `session_user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `session_last_visit` int(11) unsigned NOT NULL DEFAULT '0',
  `session_start` int(11) unsigned NOT NULL DEFAULT '0',
  `session_time` int(11) unsigned NOT NULL DEFAULT '0',
  `session_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_browser` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_page` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `session_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `session_time` (`session_time`),
  KEY `session_user_id` (`session_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
"," 
ALTER TABLE `nuke_poll_desc` ADD COLUMN  `active` int(1)  NOT NULL DEFAULT '0' ;
"," 
ALTER TABLE `nuke_config` ADD COLUMN  `tracking`  int(1)  NOT NULL DEFAULT '0' ;
"," 
        UPDATE `nuke_config` SET `USV_Version` = '1.1.1' LIMIT 1 ;
	");
		echo "<hr />\n";
		for ($i=0; $i < count($sql_queue); $i++) {
			$classrow = ($i%2) ? "class=\"oddrow\"" : "class=\"evenrow\"";
			$sql = $sql_queue[$i];
			if (!$db->sql_query($sql)) {
				$error = $db->sql_error();
				$error = $error['message'];
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				$error_info = (substr_count($error, 'Duplicate entry') || substr_count($error, 'already exists')) ? '<br><b>تحلیل:</b><span class="gen">از قبل اطلاعات درخواستی شما موجود است و نیاز به جایگزینی مجدد نمی باشد !</span>' : '';
				echo "<div $classrow>[<font color=\"red\">خطا</font>] <span class=\"gensmall\">:: $sql</span><br />
		<b>علت خطا:</b><span class=\"gen\">$error</span>
		$error_info<br /></div><br />";
			} else {
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				print "<div $classrow>".'[<font color="green" >موفقیت آمیز</font>] :: ' . $sql . '</div><br />';
			}
		}
		break;
		case "upgrade_1_1_2":
		       		$pagetitle = "ارتقا به 1.1.2";
		title("$pagetitle<br>"._GOBACK2);
		$sql_queue = array("
Alter Table  `nuke_topics` ADD slug text COLLATE utf8_persian_ci NOT NULL After `topicname`,
ADD parent bigint(20) unsigned NOT NULL DEFAULT '0' After topictext ,
Change topicname topicname varchar(70) COLLATE utf8_persian_ci DEFAULT NULL;
"," 
Alter Table  `nuke_config`
ADD use_sec_pass int(1) NOT NULL  DEFAULT '0',
ADD sec_pass varchar(40) COLLATE utf8_bin DEFAULT NULL;
"," 
ALTER TABLE  `nuke_users` ADD `user_blog_colors` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '#F9F1A9#EEE4C6#EDFAC8',
ADD `user_blog_password` varchar(255) COLLATE utf8_bin NOT NULL;
"," 
DROP TABLE IF EXISTS `nuke_blogs`;
","
CREATE TABLE IF NOT EXISTS `nuke_blogs` (
  `bid` int(10) NOT NULL AUTO_INCREMENT,
  `tid` int(10) NOT NULL DEFAULT '0',
  `content` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` varchar(14) COLLATE utf8_bin DEFAULT NULL,
  `sender` int(10) NOT NULL,
  `sender_name` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `reciever` int(10) NOT NULL,
  `reciever_name` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `like` int(10) unsigned NOT NULL DEFAULT '0',
  `unlike` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`),
  KEY `bid` (`bid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;
"," 
UPDATE `nuke_config` SET `USV_Version`='1.1.2';
"," 
UPDATE `nuke_config` SET `copyright`='Nukelearn USV &copy; 2009-2011 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>';
");
		echo "<hr />\n";
		for ($i=0; $i < count($sql_queue); $i++) {
			$classrow = ($i%2) ? "class=\"oddrow\"" : "class=\"evenrow\"";
			$sql = $sql_queue[$i];
			if (!$db->sql_query($sql)) {
				$error = $db->sql_error();
				$error = $error['message'];
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				$error_info = (substr_count($error, 'Duplicate entry') || substr_count($error, 'already exists')) ? '<br><b>تحلیل:</b><span class="gen">از قبل اطلاعات درخواستی شما موجود است و نیاز به جایگزینی مجدد نمی باشد !</span>' : '';
				echo "<div $classrow>[<font color=\"red\">خطا</font>] <span class=\"gensmall\">:: $sql</span><br />
		<b>علت خطا:</b><span class=\"gen\">$error</span>
		$error_info<br /></div><br />";
			} else {
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				print "<div $classrow>".'[<font color="green" >موفقیت آمیز</font>] :: ' . $sql . '</div><br />';
			}
		}
		break;
		case "upgrade_1_1_3":
		       		$pagetitle = "ارتقا به 1.1.3";
		title("$pagetitle<br>"._GOBACK2);
		$sql_queue = array("
 DROP TABLE IF EXISTS `nuke_tree_elements`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_tree_elements` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `lang` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `ownerEl` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'parent',
  `slave` binary(1) NOT NULL DEFAULT '0',
  `link` text NOT NULL,
  `module` varchar(255) NOT NULL,
  `icon` varchar(512) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Icon URI',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `nuke_tree_elements` (`Id`, `name`, `lang`, `position`, `ownerEl`, `slave`, `link`, `module`, `icon`) VALUES
(1, '  اخبار سایت', '', 0, 0, '0', '|_self', 'News', 'archive.png'),
(3, ' کاربران سایت', '', 1, 0, '0', '|_self', 'Your_Account', 'users.png'),
(4, 'متفرقه', '', 2, 0, '0', '|_self', '', 'item.png'),
(5, '  ارسال خبر', '', 0, 1, '1', '|_self', 'Submit_News', ''),
(6, '       آرشیو اخبار', '', 1, 1, '1', '|_self', 'Stories_Archive', ''),
(7, '    آرشیو چاپی اخبار', '', 2, 1, '1', '|_self', 'AvantGo', ''),
(8, ' جستجو در اخبار', '', 3, 1, '1', '|_self', 'Search', ''),
(9, ' صفحه شخصی کاربر', '', 2, 3, '1', '|_self', 'Your_Account', ''),
(10, ' وبلاگ شما ', '', 0, 3, '1', '|_self', 'Your_Account', ''),
(12, ' تقویم سایت', '', 0, 4, '1', '|_self', 'jCalendar', ''),
(13, ' نقشه سایت', '', 1, 4, '1', '|_self', 'Site_Map', ''),
(17, '     ویرایش مشخصات', '', 1, 3, '1', 'modules.php?name=Your_Account&op=edituser|_self', '', ''),
(18, '   ارتباط با ما', '', 8, 4, '1', '|_self', 'Contact_Plus', ''),
(19, ' معرفی ما', '', 2, 4, '1', '|_self', 'Recommend_Us', ''),
(20, ' تبلیغات', '', 4, 4, '1', '|_self', 'Advertising', ''),
(21, ' لینک به ما', '', 5, 4, '1', '|_self', 'Link_To_Us', ''),
(22, ' برترین ها', '', 6, 4, '1', '|_self', 'Top', ''),
(23, '  موضوعات', '', 4, 1, '1', '|_self', 'Topics', ''),
(24, ' فهرست کاربران', '', 3, 3, '1', 'modules.php?name=Your_Account&amp;op=memberlist|_self', '', ''),
(25, ' پیوندها', '', 7, 4, '1', '|_self', 'Web_Links', '');
"," 
DROP TABLE IF EXISTS `nuke_counter`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_counter` (
  `type` varchar(80) COLLATE utf8_bin NOT NULL,
  `var` varchar(80) COLLATE utf8_bin NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
"," 
INSERT INTO `nuke_counter` (`type`, `var`, `count`) VALUES
('total', 'visits', 2693),
('total', 'pageviews', 2694),
('total_tv', '2011-02-16', 2),
('total_tp', '2011-02-25', 13),
('total_yv', '2011-02-15', 31),
('total_yp', '2011-02-24', 91),
('se', 'google', 0),
('se', 'yahoo', 0),
('se', 'bing', 0),
('se', 'other', 0),
('browser', 'WebTV', 0),
('browser', 'Lynx', 0),
('browser', 'MSIE', 41),
('browser', 'Opera', 160),
('browser', 'Konqueror', 0),
('browser', 'Chrome', 1894),
('browser', 'FireFox', 599),
('browser', 'Bot', 0),
('browser', 'Other', 0),
('os', 'Windows', 2694),
('os', 'Linux', 0),
('os', 'Mac', 0),
('os', 'FreeBSD', 0),
('os', 'SunOS', 0),
('os', 'IRIX', 0),
('os', 'BeOS', 0),
('os', 'OS/2', 0),
('os', 'AIX', 0),
('os', 'Other', 0),
('config', 'browser_chart', 1),
('config', 'os_chart', 1),
('config', 'users_chart', 1),
('config', 'Synchronization', 1);
"," 
UPDATE `nuke_stories` SET `associated`=concat(`associated`, '-');
"," 
UPDATE `nuke_config` SET `USV_Version`='1.1.3';
"," 
ALTER IGNORE TABLE `nuke_session` ADD UNIQUE KEY(`session_ip`) 
"," 
UPDATE `nuke_config` SET `copyright`='Nukelearn USV &copy; 2009-2011 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>';
"," 
ALTER IGNORE TABLE `nuke_users` ADD UNIQUE KEY(`username`)
"," 
UPDATE `nuke_config` SET `copyright`='Nukelearn USV &copy; 2009-2011 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>';
	");
		echo "<hr />\n";
		for ($i=0; $i < count($sql_queue); $i++) {
			$classrow = ($i%2) ? "class=\"oddrow\"" : "class=\"evenrow\"";
			$sql = $sql_queue[$i];
			if (!$db->sql_query($sql)) {
				$error = $db->sql_error();
				$error = $error['message'];
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				$error_info = (substr_count($error, 'Duplicate entry') || substr_count($error, 'already exists')) ? '<br><b>تحلیل:</b><span class="gen">از قبل اطلاعات درخواستی شما موجود است و نیاز به جایگزینی مجدد نمی باشد !</span>' : '';
				echo "<div $classrow>[<font color=\"red\">خطا</font>] <span class=\"gensmall\">:: $sql</span><br />
		<b>علت خطا:</b><span class=\"gen\">$error</span>
		$error_info<br /></div><br />";
			} else {
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				print "<div $classrow>".'[<font color="green" >موفقیت آمیز</font>] :: ' . $sql . '</div><br />';
			}
		}
		break;
		case "upgrade_1_1_4":
		       		$pagetitle = "ارتقا به 1.1.4";
		title("$pagetitle<br>"._GOBACK2);
		$sql_queue = array("
UPDATE `nuke_config` SET `USV_Version`='1.1.4';
"," 
ALTER IGNORE TABLE `nuke_session` ADD UNIQUE KEY(`session_ip`) 
"," 
UPDATE `nuke_config` SET `copyright`='Nukelearn USV &copy; 2009-2011 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>';
"," 
ALTER IGNORE TABLE `nuke_users` ADD UNIQUE KEY(`username`)
"," 
DROP TABLE IF EXISTS `nuke_shoutbox`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_shoutbox` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'anonimous',
  `message` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;
"," 
DROP TABLE IF EXISTS `nuke_counter`;
"," 
CREATE TABLE IF NOT EXISTS `nuke_counter` (
  `type` varchar(80) COLLATE utf8_bin NOT NULL,
  `var` varchar(80) COLLATE utf8_bin NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
"," 
INSERT INTO `nuke_counter` (`type`, `var`, `count`) VALUES
('total', 'visits', 0),
('total', 'pageviews', 0),
('total_today', '2011-02-14', 0),
('total_yesterday', '2011-03-17', 0),
('se', 'google', 0),
('se', 'yahoo', 0),
('se', 'bing', 0),
('se', 'other', 0),
('browser', 'WebTV', 0),
('browser', 'Lynx', 0),
('browser', 'MSIE', 0),
('browser', 'Opera', 0),
('browser', 'Konqueror', 0),
('browser', 'Netscape', 0),
('browser', 'FireFox', 0),
('browser', 'Bot', 0),
('browser', 'Other', 0),
('os', 'Windows', 0),
('os', 'Linux', 0),
('os', 'Mac', 0),
('os', 'FreeBSD', 0),
('os', 'SunOS', 0),
('os', 'IRIX', 0),
('os', 'BeOS', 0),
('os', 'OS/2', 0),
('os', 'AIX', 0),
('os', 'Other', 0),
('config', 'browser_chart', 1),
('config', 'os_chart', 1),
('config', 'users_chart', 1),
('config', 'Synchronization', 1);
"," 
ALTER TABLE `nuke_tree_elements` ADD `icon` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Icon URI';
"," 
ALTER TABLE `nuke_tree_elements` ADD `lang` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `name` ;
"," 
ALTER TABLE `nuke_tree_elements` CHANGE `eng_name` `lang` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL 
"," 
UPDATE `nuke_config` SET `copyright`='Nukelearn USV &copy; 2009-2011 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>';
"," 
ALTER TABLE `nuke_nsnst_config` CHANGE `config_value` `config_value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL 
"," 
ALTER TABLE `nuke_stories` ADD `rate` INT( 8 ) NOT NULL DEFAULT '0',
ADD `rates_count` INT( 8 ) NOT NULL DEFAULT '0';
"," 
ALTER TABLE `nuke_nsngd_downloads` ADD `rate` INT( 8 ) NOT NULL DEFAULT '0',
ADD `rates_count` INT( 8 ) NOT NULL DEFAULT '0';
"," 
ALTER TABLE `nuke_users` ADD `rate` INT( 8 ) NOT NULL DEFAULT '0',
ADD `rates_count` INT( 8 ) NOT NULL DEFAULT '0';
"," 
INSERT INTO `nuke_nsnst_config` (`config_name`, `config_value`) VALUES
('disable_from_date', '2011-03-28 2:04:24'),
('disable_to_date', '2011-03-31 6:25:34'),
('disable_reason', '');
","
DROP TABLE IF EXISTS `nuke_headlines`;
"," 
INSERT INTO `nuke_cnbya_config` (`config_name`,`config_value`)VALUES('headlines', 'http://www.tabnak.ir/fa/rss/allnews\r\nhttp://www.itna.ir/index.xml\r\nhttp://www.cmsnews.ir/feed/rss/\r\nhttp://www.nukelearn.com/feed/News\r\n');
","
DROP TABLE IF EXISTS `nuke_groups_ranges`;
","","
DROP TABLE IF EXISTS `nuke_groups`;

","

DROP TABLE IF EXISTS `nuke_groups`;

","
CREATE TABLE IF NOT EXISTS `nuke_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varbinary(255) DEFAULT NULL,
  `description` blob,
  `post_min` int(8) NOT NULL,
  `post_max` int(11) NOT NULL,
  `point_min` int(11) NOT NULL,
  `point_max` int(11) NOT NULL,
  `members` blob,
  `point_amount` varbinary(255) DEFAULT NULL,
  `color` varchar(9) COLLATE utf8_persian_ci DEFAULT '#000000',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=5 ;


","

ALTER TABLE `nuke_users` DROP COLUMN `user_points`;

","

ALTER TABLE `nuke_users` DROP COLUMN `user_notify_donation`;
","
DROP TABLE IF EXISTS `nuke_session`;
","
CREATE TABLE IF NOT EXISTS `nuke_session` (
  `session_id` varchar(255) character set utf8 collate utf8_bin NOT NULL,
  `session_user_id` mediumint(8) unsigned NOT NULL default '0',
  `session_last_visit` int(11) unsigned NOT NULL default '0',
  `session_start` int(11) unsigned NOT NULL default '0',
  `session_time` int(11) unsigned NOT NULL default '0',
  `session_ip` varchar(40) character set utf8 collate utf8_bin NOT NULL default '',
  `session_browser` varchar(150) character set utf8 collate utf8_bin NOT NULL default '',
  `session_page` varchar(255) character set utf8 collate utf8_bin NOT NULL default '',
  `session_admin` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  UNIQUE KEY `session_ip_2` (`session_ip`),
  KEY `session_time` (`session_time`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_ip` (`session_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

","
INSERT INTO `nuke_groups` (`id`, `name`, `description`, `post_min`, `post_max`, `point_min`, `point_max`, `members`, `point_amount`, `color`) VALUES
(1, 'اعضای سایت', ' اعضای جدید سایت که حداکثر 1000 امتیاز ذخیره کرده اند', 0, 0, 0, 1000, NULL, '25-25-10-25-25-10-10-10-25-25-25-10-2-3-3-25-5-5-5-5-5', '#000000');


");

		echo "<hr />\n";
		for ($i=0; $i < count($sql_queue); $i++) {
			$classrow = ($i%2) ? "class=\"oddrow\"" : "class=\"evenrow\"";
			$sql = $sql_queue[$i];
			if (!$db->sql_query($sql)) {
				$error = $db->sql_error();
				$error = $error['message'];
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				$error_info = (substr_count($error, 'Duplicate entry') || substr_count($error, 'already exists')) ? '<br><b>تحلیل:</b><span class="gen">از قبل اطلاعات درخواستی شما موجود است و نیاز به جایگزینی مجدد نمی باشد !</span>' : '';
				echo "<div $classrow>[<font color=\"red\">خطا</font>] <span class=\"gensmall\">:: $sql</span><br />
		<b>علت خطا:</b><span class=\"gen\">$error</span>
		$error_info<br /></div><br />";
			} else {
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				print "<div $classrow>".'[<font color="green" >موفقیت آمیز</font>] :: ' . $sql . '</div><br />';
			}
		}
		break;
		
case "upgrade_1_1_5":
		       		$pagetitle = "ارتقا به 1.1.5";
		       		title("$pagetitle<br>"._GOBACK2);
		       		$sql_queue = array("
ALTER TABLE `nuke_blogs`
Change date date datetime NOT NULL;
"," 
ALTER TABLE `nuke_jcalendar_events`
ADD COLUMN `linkstr` varchar(255) DEFAULT NULL,
"," 
UPDATE `nuke_config` SET `USV_Version`='1.1.5';
"," 
UPDATE `nuke_config` SET `copyright`='Nukelearn USV &copy; 2009-2011 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>';
");
		echo "<hr />\n";
		for ($i=0; $i < count($sql_queue); $i++) {
			$classrow = ($i%2) ? "class=\"oddrow\"" : "class=\"evenrow\"";
			$sql = $sql_queue[$i];
			if (!$db->sql_query($sql)) {
				$error = $db->sql_error();
				$error = $error['message'];
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				$error_info = (substr_count($error, 'Duplicate entry') || substr_count($error, 'already exists')) ? '<br><b>تحلیل:</b><span class="gen">از قبل اطلاعات درخواستی شما موجود است و نیاز به جایگزینی مجدد نمی باشد !</span>' : '';
				echo "<div $classrow>[<font color=\"red\">خطا</font>] <span class=\"gensmall\">:: $sql</span><br />
		<b>علت خطا:</b><span class=\"gen\">$error</span>
		$error_info<br /></div><br />";
			} else {
				if ( strlen($sql) > 200) $sql = substr($sql, 0, 200) . ' ...';
				print "<div $classrow>".'[<font color="green" >موفقیت آمیز</font>] :: ' . $sql . '</div><br />';
			}
		}
		break;
		
	}
} else {
	echo "<b><img src='images/icon/note.png'>تنها مدیرکل سایت امکان اجرای ارتقا سایت را دارد . <br>
	در صورتی که مدیر این سایت هستید . به بخش مدیریت خود وارد شوید و مجدد این بخش را اجرا کنید.<br><br><br>
	<img src='images/icon/user.png'><a href='install.php' class='button'>بازگشت به صفحه اول نصب کننده</a>
	</b>\n";
}
?>
<p class="footmsg_l"><a href='http://www.nukelearn.com'>Powered By Nukelearn</a><br></p></div>