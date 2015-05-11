CREATE TABLE IF NOT EXISTS `nuke_authors` (
  `aid` varchar(25) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `pwd` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  `radminsuper` tinyint(1) NOT NULL DEFAULT '1',
  `admlanguage` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_banned_ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) COLLATE utf8_bin NOT NULL,
  `reason` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_banner` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `imageurl` varchar(100) COLLATE utf8_bin NOT NULL,
  `clickurl` varchar(200) COLLATE utf8_bin NOT NULL,
  `alttext` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime DEFAULT NULL,
  `dateend` datetime DEFAULT NULL,
  `position` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `ad_class` varchar(5) COLLATE utf8_bin NOT NULL,
  `ad_code` text COLLATE utf8_bin NOT NULL,
  `ad_width` int(4) DEFAULT '0',
  `ad_height` int(4) DEFAULT '0',
  PRIMARY KEY (`bid`),
  KEY `bid` (`bid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_banner_clients` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_bin NOT NULL,
  `contact` varchar(60) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `login` varchar(10) COLLATE utf8_bin NOT NULL,
  `passwd` varchar(10) COLLATE utf8_bin NOT NULL,
  `extrainfo` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_banner_plans` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `delivery` varchar(10) COLLATE utf8_bin NOT NULL,
  `delivery_type` varchar(25) COLLATE utf8_bin NOT NULL,
  `price` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `buy_links` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_banner_positions` (
  `apid` int(10) NOT NULL AUTO_INCREMENT,
  `position_number` int(5) NOT NULL DEFAULT '0',
  `position_name` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`apid`),
  KEY `position_number` (`position_number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

INSERT INTO `nuke_banner_positions` (`apid`, `position_number`, `position_name`) VALUES
(1, 0, 'Page Top'),
(2, 1, 'Left Block');

CREATE TABLE IF NOT EXISTS `nuke_banner_terms` (
  `terms_body` text COLLATE utf8_bin NOT NULL,
  `country` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_blocks` (
  `bid` int(10) NOT NULL AUTO_INCREMENT,
  `bkey` varchar(15) COLLATE utf8_bin NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `url` varchar(200) COLLATE utf8_bin NOT NULL,
  `bposition` char(1) COLLATE utf8_bin NOT NULL,
  `weight` int(10) NOT NULL DEFAULT '1',
  `active` int(1) NOT NULL DEFAULT '1',
  `refresh` int(10) NOT NULL DEFAULT '0',
  `time` varchar(14) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `blanguage` varchar(30) COLLATE utf8_bin NOT NULL,
  `blockfile` varchar(255) COLLATE utf8_bin NOT NULL,
  `view` int(1) NOT NULL DEFAULT '0',
  `expire` varchar(14) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `action` char(1) COLLATE utf8_bin NOT NULL,
  `subscription` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`),
  KEY `bid` (`bid`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=28 ;


INSERT INTO `nuke_blocks` (`bid`, `bkey`, `title`, `content`, `url`, `bposition`, `weight`, `active`, `refresh`, `time`, `blanguage`, `blockfile`, `view`, `expire`, `action`, `subscription`) VALUES
(1, '', '_BLOCK_MMENU', '', '', 'l', 0, 1, 0, '', '', 'block-menu.php', 0, '0', 'd', 0),
(2, '', '_SEARCH', '', '', 'i', 8, 0, 3600, '', '', 'block-Search.php', 0, '0', 'd', 0),
(3, '', '_BLOCK_RANDOM_HEADLINES', '', '', 'r', 3, 1, 3600, '', '', 'block-Random_Headlines.php', 0, '0', 'd', 0),
(4, '', '_BLOCK_CATS', '', '', 'l', 3, 1, 0, '', '', 'block-Categories.php', 0, '0', 'd', 0),
(5, '', '_POLLS', '', '', 'l', 2, 1, 0, '', '', 'block-JQ-Poll.php', 0, '0', 'd', 0),
(6, '', '_BLOCK_TOP_STORY', '', '', 'i', 0, 0, 3600, '', '', 'block-Big_Story_of_Today.php', 0, '0', 'd', 0),
(7, '', '_PASTARTICLES', '', '', 'd', 0, 1, 3600, '', '', 'block-Old_Articles.php', 0, '0', 'd', 0),
(8, '', '_BLOGPOSTS_LATESTPOSTS', '', '', 'i', 6, 0, 0, '', '', 'block-BlogRoll.php', 0, '0', 'd', 0),
(9, '', '_BLOCK_ADS', '', '', 'i', 5, 0, 0, '', '', 'block-INPB_Login.php', 0, '0', 'd', 0),
(10, '', '_BLOCK_LINKS', '', '', 'i', 7, 0, 0, '', '', 'block-CZLinks.php', 0, '0', 'd', 0),
(11, '', '_ADMIN_MODULE_JCALENDAR', '', '', 'r', 2, 1, 0, '', '', 'block-Calender.php', 0, '0', 'd', 0),
(12, '', '_BLOCK_INFO', '', '', 'i', 2, 0, 0, '', '', 'block-Info_Box.php', 0, '0', 'd', 0),
(13, '', '_BLOCK_RSS', '', '', 'l', 4, 1, 0, '', '', 'block-RSS_List.php', 0, '0', 'd', 0),
(14, '', '_BLOCK_BOOKMARK', '', '', 'i', 3, 0, 0, '', '', 'block-BookMark.php', 0, '0', 'd', 0),
(15, '', '_BLOCK_KEYWORDS', '', '', 'i', 4, 0, 0, '', '', 'block-Tag_Cloud.php', 0, '0', 'd', 0),
(16, '', '_BLOCK_GSEARCH', '', '', 'i', 1, 0, 0, '', '', 'block-Ajax_Google_Search.php', 0, '0', 'd', 0),
(17, '', '_SEARCH', '', '', 'c', 0, 1, 3600, '', '', 'block-Search.php', 0, '0', 'd', 0),
(18, '', '_BLOCK_SUPPORT_NKLN', 0x3c70207374796c653d22746578742d616c69676e3a2063656e7465723b20223e0d0a093c6120687265663d22687474703a2f2f7777772e6e756b656c6561726e2e636f6d223e3c696d6720616c743d2222207372633d22696e636c756465732f75706c6f61642f4e756b656c6561726e2f3132302d3234302e706e6722207374796c653d2277696474683a2031323070783b206865696768743a2032343070783b2022202f3e3c2f613e3c2f703e0d0a, '', 'l', 5, 1, 0, '', '', '', 0, '0', 'd', 0),
(19, '', '_BLOCK_QUICKADMIN', '', '', 'l', 1, 1, 3600, '', '', 'block-Admin.php', 2, '0', 'd', 0),
(20, '', '_BLOCK_WHATSLEFT', '', '', 'r', 4, 1, 3600, '', '', 'block-LeftToDo.php', 0, '0', 'd', 0),
(21, '', '_ADMIN_STATADMIN', '', '', 'r', 0, 1, 3600, '', '', 'block-Statistic.php', 0, '0', 'd', 0),
(22, '', '_BLOCK_SHOUTBOX', '', '', 'r', 1, 1, 3600, '', '', 'block-shoutbox.php', 0, '0', 'd', 0),
(23, '', 'آخرین ارسال های انجمن های گفتگو', '', '', 'c', 1, 1, 3600, '', 'persian', 'block-mybb_forums.php', 0, '0', 'd', 0);


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


CREATE TABLE IF NOT EXISTS `nuke_cnbya_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` longtext COLLATE utf8_bin,
  UNIQUE KEY `config_name` (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_cnbya_config` (`config_name`, `config_value`) VALUES
('allowmailchange', '1'),
('allowuserdelete', '0'),
('allowuserreg', '0'),
('allowusertheme', '0'),
('autosuspend', '0'),
('autosuspendmain', '0'),
('bad_mail', 'mysite.com\r\nyoursite.com'),
('bad_nick', 'adm\r\nadmin\r\nanonimo\r\nanonymous\r\nanَnimo\r\ngod\r\nlinux\r\nnobody\r\noperator\r\nroot\r\nstaff\r\nwebmaster'),
('codesize', '4'),
('cookiecheck', '1'),
('cookiecleaner', '1'),
('cookieinactivity', '-'),
('cookiepath', ''),
('cookietimelife', '2592000'),
('coppa', '0'),
('doublecheckemail', '1'),
('emailvalidate', '0'),
('expiring', '86400'),
('nick_max', '20'),
('nick_min', '3'),
('pass_max', '25'),
('pass_min', '3'),
('perpage', '100'),
('requireadmin', '0'),
('sendaddmail', '0'),
('senddeletemail', '0'),
('servermail', '1'),
('tos', '0'),
('tosall', '0'),
('useactivate', '1'),
('usegfxcheck', '3'),
('version', '4.4.1'),
('use_question', '1'),
('headlines', 'http://www.tabnak.ir/fa/rss/allnews\r\nhttp://www.itna.ir/index.xml\r\nhttp://www.cmsnews.ir/feed/rss/\r\nhttp://www.MarlikCMS.com/feed/News\r\n');


CREATE TABLE IF NOT EXISTS `nuke_cnbya_field` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'field',
  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `size` int(3) DEFAULT NULL,
  `need` int(1) NOT NULL DEFAULT '1',
  `pos` int(3) DEFAULT NULL,
  `public` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_cnbya_tos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `des` text COLLATE utf8_bin NOT NULL,
  `language` varchar(25) COLLATE utf8_bin NOT NULL,
  `time` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

INSERT INTO `nuke_cnbya_tos` (`id`, `data`, `status`, `des`, `language`, `time`) VALUES
(1, '<p><font class="content"><b>1. قانون اول</b><br>\r\nشرح قانون اول<br>\r\n<br>\r\n<b>2. قانون دوم</b><br>\r\nشرح قانون دوم<br>\r\n<br>\r\n<b>3. قانون سوم</b><br>\r\nشرح قانون سوم<br>\r\n<br>\r\n<b>4. قانون چهارم</b><br>\r\nشرح قانون چهارم<br>\r\n<br>\r\n<b>5. قانون پنجم</b><br>\r\nشرح قانون پنجم<br>\r\n<br>\r\n<b>6. قانون ششم</b><br>\r\nشرح قانون ششم<br>\r\n<br>\r\n<b>7. قانون هفتم</b><br>\r\nشرح قانون هفتم<br>\r\n<br>\r\n<b>8. قانون هشتم</b><br>\r\nشرح قانون هشتم<br>\r\n<br>\r\n<b>9.قانون نهم</b><br>\r\nشرح قانون نهم<br>\r\n<br>\r\n<b>10. قانون دهم</b><br>\r\nشرح قانون دهم<br>\r\n<br>\r\n<b>11. قانون یازدهم</b><br>\r\nشرح قانون یازدهم<br>\r\n<br>\r\n<b>12. قانون دوازدهم</b><br>\r\nشرح قانون دوازدهم<br>\r\n<br>\r\n<b>13. قانون سیزدهم</b><br>\r\nشرح قانون سیزدهم<br>\r\n </font></p>\r\n', 1, 'قوانین پیشفرض', 'persian', '2005-05-03 00:10');

CREATE TABLE IF NOT EXISTS `nuke_cnbya_value` (
  `vid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `fid` int(10) NOT NULL DEFAULT '0',
  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`vid`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_cnbya_value_temp` (
  `vid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `fid` int(10) NOT NULL DEFAULT '0',
  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`vid`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_comments_moderated` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `name` varchar(60) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `host_name` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `subject` varchar(85) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `score` tinyint(4) NOT NULL DEFAULT '0',
  `reason` tinyint(4) NOT NULL DEFAULT '0',
  `last_moderation_ip` varchar(15) COLLATE utf8_bin DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_config` (
  `sitename` varchar(255) COLLATE utf8_bin NOT NULL,
  `nukeurl` varchar(255) COLLATE utf8_bin NOT NULL,
  `site_logo` varchar(255) COLLATE utf8_bin NOT NULL,
  `slogan` varchar(255) COLLATE utf8_bin NOT NULL,
  `startdate` varchar(50) COLLATE utf8_bin NOT NULL,
  `adminmail` varchar(255) COLLATE utf8_bin NOT NULL,
  `anonpost` tinyint(1) NOT NULL DEFAULT '0',
  `Default_Theme` varchar(255) COLLATE utf8_bin NOT NULL,
  `foot1` text COLLATE utf8_bin NOT NULL,
  `foot2` text COLLATE utf8_bin NOT NULL,
  `foot3` text COLLATE utf8_bin NOT NULL,
  `commentlimit` int(9) NOT NULL DEFAULT '10',
  `anonymous` varchar(255) COLLATE utf8_bin NOT NULL,
  `minpass` tinyint(1) NOT NULL DEFAULT '5',
  `pollcomm` tinyint(1) NOT NULL DEFAULT '1',
  `articlecomm` tinyint(1) NOT NULL DEFAULT '1',
  `broadcast_msg` tinyint(1) NOT NULL DEFAULT '1',
  `my_headlines` tinyint(1) NOT NULL DEFAULT '1',
  `top` int(3) NOT NULL DEFAULT '10',
  `storyhome` int(2) NOT NULL DEFAULT '10',
  `user_news` tinyint(1) NOT NULL DEFAULT '1',
  `oldnum` int(2) NOT NULL DEFAULT '30',
  `ultramode` tinyint(1) NOT NULL DEFAULT '0',
  `loading` tinyint(1) NOT NULL DEFAULT '0',
  `nextg` tinyint(1) NOT NULL DEFAULT '0',
  `banners` tinyint(1) NOT NULL DEFAULT '1',
  `backend_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `backend_language` varchar(10) COLLATE utf8_bin NOT NULL,
  `language` varchar(100) COLLATE utf8_bin NOT NULL,
  `locale` varchar(10) COLLATE utf8_bin NOT NULL,
  `multilingual` tinyint(1) NOT NULL DEFAULT '0',
  `useflags` tinyint(1) NOT NULL DEFAULT '0',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `notify_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `notify_subject` varchar(255) COLLATE utf8_bin NOT NULL,
  `notify_message` varchar(255) COLLATE utf8_bin NOT NULL,
  `notify_from` varchar(255) COLLATE utf8_bin NOT NULL,
  `moderate` tinyint(1) NOT NULL DEFAULT '0',
  `admingraphic` tinyint(1) NOT NULL DEFAULT '1',
  `httpref` tinyint(1) NOT NULL DEFAULT '1',
  `httprefmax` int(5) NOT NULL DEFAULT '1000',
  `CensorMode` tinyint(1) NOT NULL DEFAULT '3',
  `CensorReplace` varchar(10) COLLATE utf8_bin NOT NULL,
  `copyright` text COLLATE utf8_bin NOT NULL,
  `USV_Version` varchar(15) COLLATE utf8_bin NOT NULL,
  `support` varchar(30) COLLATE utf8_bin NOT NULL,
  `gfx_chk` tinyint(1) NOT NULL DEFAULT '1',
  `use_question` int(1) NOT NULL DEFAULT '0',
  `codesize` int(1) NOT NULL DEFAULT '4',
  `cache_system` int(1) NOT NULL DEFAULT '0',
  `cache_lifetime` int(1) NOT NULL DEFAULT '120',
  `nuke_editor` int(1) NOT NULL DEFAULT '1',
  `tracking` int(1) NOT NULL DEFAULT '0',
  `sec_pass` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`sitename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_config` (`sitename`, `nukeurl`, `site_logo`, `slogan`, `startdate`, `adminmail`, `anonpost`, `Default_Theme`, `foot1`, `foot2`, `foot3`, `commentlimit`, `anonymous`, `minpass`, `pollcomm`, `articlecomm`, `broadcast_msg`, `my_headlines`, `top`, `storyhome`, `user_news`, `oldnum`, `ultramode`, `loading`, `nextg`, `banners`, `backend_title`, `backend_language`, `language`, `locale`, `multilingual`, `useflags`, `notify`, `notify_email`, `notify_subject`, `notify_message`, `notify_from`, `moderate`, `admingraphic`, `httpref`, `httprefmax`, `CensorMode`, `CensorReplace`, `copyright`, `USV_Version`, `support`, `gfx_chk`, `use_question`, `codesize`, `cache_system`, `cache_lifetime`, `nuke_editor`, `tracking`, `sec_pass`) VALUES
('MarlikCMS Tigris', '', 'logo.png', '', '', '', 0, 'FarshadGhazanfari', '', '', '', 10, 'کاربر مهمان', 5, 0, 1, 1, 1, 330, 10, 1, 30, 0, 0, 0, 0, 'MarlikCMS Tigris Powered Site', 'persian', 'persian', 'en_US', 1, 1, 1, 'info@MarlikCMS.com', 'اطلاعیه سایت', 'از سوی سایت اطلاعیه دارید ', 'مدیریت', 0, 1, 1, 1000, 3, '*****', 0x4e756b656c6561726e205469677269732026636f70793b20323030392d32303130203c6120687265663d22687474703a2f2f7777772e6e756b656c6561726e2e636f6d22207461726765743d225f626c616e6b223e4e756b656c6561726e3c2f613e, 'Tigris 1.1.6', 'info@MarlikCMS.com', 1, 0, 4, 0, 120, 1, 1, '');

CREATE TABLE IF NOT EXISTS `nuke_confirm` (
  `confirm_id` char(32) COLLATE utf8_bin NOT NULL,
  `session_id` char(32) COLLATE utf8_bin NOT NULL,
  `code` char(6) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`,`confirm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_contact_us` (
  `pid` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `phone_num` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `fax_num` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `yahoo_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `gmail_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `dept_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `dept_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `address` text COLLATE utf8_bin NOT NULL,
  `showaddress` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

INSERT INTO `nuke_contact_us` (`pid`, `name`, `phone_num`, `fax_num`, `yahoo_id`, `gmail_id`, `dept_name`, `dept_email`, `address`, `showaddress`) VALUES
(1, 'TEST', '000000000', '', 'YahooID', 'test@gmail.com', 'مدیریت سایت', 'info@site.com', 'Address Info', 0);



CREATE TABLE IF NOT EXISTS `nuke_counter` (
  `type` varchar(80) COLLATE utf8_bin NOT NULL,
  `var` varchar(80) COLLATE utf8_bin NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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


INSERT INTO `nuke_groups` (`id`, `name`, `description`, `post_min`, `post_max`, `point_min`, `point_max`, `members`, `point_amount`, `color`) VALUES
(1, '_REGMEMBERS', ' اعضای جدید سایت که حداکثر 1000 امتیاز ذخیره کرده اند', 0, 0, 0, 1000, NULL, '25-25-10-25-25-10-10-10-25-25-25-10-2-3-3-25-5-5-5-5-5', '#000000');



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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_jcalendar_events` (
  `eid` smallint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `repeat_type` enum('off','daily','weekly','monthly','yearly') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'off',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `holiday` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `linkstr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `nuke_keywords` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_keywords_main` (
  `keywords` text NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `nuke_keywords_main` (`keywords`, `description`) VALUES
('News, نیوک لرن, Nuke, USV NUKE, Downloads, Community, Forum, Bulletin, Board, PHP, MySQL, Survey, Portal, Blog', 'Your slogan here');

CREATE TABLE IF NOT EXISTS `nuke_links_categories` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `cdescription` text COLLATE utf8_bin NOT NULL,
  `parentid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_links_editorials` (
  `linkid` int(11) NOT NULL DEFAULT '0',
  `adminid` varchar(60) COLLATE utf8_bin NOT NULL,
  `editorialtimestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editorialtext` text COLLATE utf8_bin NOT NULL,
  `editorialtitle` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`linkid`),
  KEY `linkid` (`linkid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_links_links` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `url` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `date` datetime DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `submitter` varchar(60) COLLATE utf8_bin NOT NULL,
  `linkratingsummary` double(6,4) NOT NULL DEFAULT '0.0000',
  `totalvotes` int(11) NOT NULL DEFAULT '0',
  `totalcomments` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_links_modrequest` (
  `requestid` int(11) NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `url` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `modifysubmitter` varchar(60) COLLATE utf8_bin NOT NULL,
  `brokenlink` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`requestid`),
  UNIQUE KEY `requestid` (`requestid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_links_newlink` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `url` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `submitter` varchar(60) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_links_votedata` (
  `ratingdbid` int(11) NOT NULL AUTO_INCREMENT,
  `ratinglid` int(11) NOT NULL DEFAULT '0',
  `ratinguser` varchar(60) COLLATE utf8_bin NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `ratinghostname` varchar(60) COLLATE utf8_bin NOT NULL,
  `ratingcomments` text COLLATE utf8_bin NOT NULL,
  `ratingtimestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ratingdbid`),
  KEY `ratingdbid` (`ratingdbid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nuke_linktous` (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `l_zipurl` varchar(255) NOT NULL DEFAULT '',
  `l_image` varchar(255) NOT NULL DEFAULT '',
  `l_mouseover` varchar(255) NOT NULL DEFAULT '',
  `l_status` int(1) NOT NULL DEFAULT '0',
  `l_size_width` char(3) NOT NULL DEFAULT '0',
  `l_size_height` char(3) NOT NULL DEFAULT '0',
  `l_hits` bigint(20) NOT NULL DEFAULT '0',
  `l_linktype` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`l_id`),
  KEY `l_id` (`l_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `nuke_linktous` (`l_id`, `l_zipurl`, `l_image`, `l_mouseover`, `l_status`, `l_size_width`, `l_size_height`, `l_hits`, `l_linktype`) VALUES
(1, '', 'images/links/MarlikCMS tigris1.png', 'MarlikCMS Tigris ', 0, '120', '240', 1, 0);

CREATE TABLE IF NOT EXISTS `nuke_linktous_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_linktous_config` (`config_name`, `config_value`) VALUES
('path', 'images/links'),
('zippath', 'images/links/zips'),
('respath', 'images/links/res'),
('blktoshowml', '1'),
('blkziportext', '0'),
('blkscrollml', '0'),
('blkscrheightml', '31'),
('blkscrdelayml', '1'),
('blkorderml', '2'),
('blkalphaml', '0'),
('blkactiveres', '1'),
('blktoshowres', '10'),
('blkscrollres', '1'),
('blkscrheightres', '100'),
('blkscrdelayres', '1'),
('blkorderres', '2'),
('blkalphares', '1'),
('modalphaml', '0'),
('modorderbyml', '2'),
('modactiveres', '1'),
('modalphares', '1'),
('modorderbyres', '2');

CREATE TABLE IF NOT EXISTS `nuke_linktous_resources` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(60) COLLATE utf8_bin NOT NULL,
  `r_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `r_image` varchar(255) COLLATE utf8_bin NOT NULL,
  `r_status` int(1) NOT NULL DEFAULT '0',
  `r_size_width` char(3) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `r_size_height` char(3) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `r_hits` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`r_id`),
  KEY `r_id` (`r_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

INSERT INTO `nuke_linktous_resources` (`r_id`, `r_name`, `r_url`, `r_image`, `r_status`, `r_size_width`, `r_size_height`, `r_hits`) VALUES
(1, 'MarlikCMS Portal', 'http://MarlikCMS.com/', 'images/links/res/MarlikCMS_portal.png', 0, '88', '31', 2);


CREATE TABLE IF NOT EXISTS `nuke_main` (
  `main_module` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_main` (`main_module`) VALUES
('News');

CREATE TABLE IF NOT EXISTS `nuke_modules` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `custom_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `view` int(1) NOT NULL DEFAULT '0',
  `inmenu` tinyint(1) NOT NULL DEFAULT '1',
  `mod_group` int(10) DEFAULT '0',
  `admins` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `mid` (`mid`),
  KEY `title` (`title`),
  KEY `custom_title` (`custom_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=45 ;

INSERT INTO `nuke_modules` (`mid`, `title`, `custom_title`, `active`, `view`, `inmenu`, `mod_group`, `admins`) VALUES
(1, 'AvantGo', '_AVANTGO', 1, 0, 1, 0, ''),
(2, 'Downloads', '_DOWNLOADS', 1, 0, 1, 0, ''),
(3, 'Contact_Plus', '_CONTACT_US', 1, 0, 1, 0, ''),
(4, 'News', '_RSS_NEWS', 1, 0, 1, 0, ''),
(5, 'Pages', '_PAGES', 1, 0, 1, 0, ''),
(6, 'Recommend_Us', '_RECOMMENDUS', 1, 0, 1, 0, ''),
(7, 'Search', '_SEARCH', 1, 0, 1, 0, ''),
(8, 'Stories_Archive', '_ARCHIVE', 1, 0, 1, 0, ''),
(9, 'Submit_Downloads', '_SUBMIT_DOWNLOADS', 0, 0, 1, 0, ''),
(10, 'Submit_News', '_SUBMIT_NEWS', 1, 0, 1, 0, ''),
(11, 'Surveys', '_POLLS', 1, 0, 1, 0, ''),
(12, 'Top', '_TOP', 1, 0, 1, 0, ''),
(13, 'Topics', '_TOPICS', 1, 0, 1, 0, ''),
(14, 'Web_Links', '_WEBLINKS', 1, 0, 1, 0, ''),
(15, 'Your_Account', '_ACCOUNT', 1, 0, 1, 0, ''),
(16, 'Advertising', '_ADVERTISING', 1, 0, 1, 0, ''),
(17, 'Link_To_Us', '_ADMIN_MODULE_LINKTOUS', 1, 0, 1, 0, ''),
(18, 'Site_Map', '_SITE_MAP', 1, 0, 1, 0, ''),
(19, 'Dynamic_Keywords', '_KEYWORDS', 0, 0, 1, 0, ''),
(20, 'Statistics', '_ADMIN_STATADMIN', 1, 0, 1, 0, ''),
(21, 'jCalendar', '_CALENDAR', 1, 0, 1, 0, '');

CREATE TABLE IF NOT EXISTS `nuke_msconfig` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_msconfig` (`id`, `value`) VALUES
('results-per-page', '7'),
('mSearch-version', '3.0'),
('enable-rss', 'on'),
('use-gsearch', 'on'),
('scope-on-front-page', 'on');


CREATE TABLE IF NOT EXISTS `nuke_msmodules` (
  `name` text COLLATE utf8_bin NOT NULL,
  `use` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_nsngd_accesses` (
  `username` varchar(60) COLLATE utf8_bin NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT '0',
  `uploads` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_nsngd_categories` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `cdescription` text COLLATE utf8_bin NOT NULL,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `whoadd` tinyint(2) NOT NULL DEFAULT '0',
  `uploaddir` varchar(255) COLLATE utf8_bin NOT NULL,
  `canupload` tinyint(2) NOT NULL DEFAULT '0',
  `active` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`),
  KEY `cid` (`cid`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_nsngd_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_nsngd_config` (`config_name`, `config_value`) VALUES
('admperpage', '50'),
('blockunregmodify', '0'),
('dateformat', 'D M j G:i:s T Y'),
('mostpopular', '25'),
('mostpopulartrig', '0'),
('perpage', '10'),
('popular', '500'),
('results', '10'),
('show_links_num', '0'),
('usegfxcheck', '0'),
('show_download', '0'),
('version_number', '1.0.3');

CREATE TABLE IF NOT EXISTS `nuke_nsngd_downloads` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `submitter` varchar(60) COLLATE utf8_bin NOT NULL,
  `sub_ip` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0.0.0.0',
  `filesize` bigint(20) NOT NULL DEFAULT '0',
  `version` varchar(20) COLLATE utf8_bin NOT NULL,
  `homepage` varchar(255) COLLATE utf8_bin NOT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `source` varchar(255) COLLATE utf8_bin NOT NULL,
  `tags` varchar(256) COLLATE utf8_bin NOT NULL,
  `rate` int(8) NOT NULL DEFAULT '0',
  `rates_count` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_nsngd_extensions` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `ext` varchar(6) COLLATE utf8_bin NOT NULL,
  `file` tinyint(1) NOT NULL DEFAULT '0',
  `image` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `ext` (`eid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

INSERT INTO `nuke_nsngd_extensions` (`eid`, `ext`, `file`, `image`) VALUES
(1, '.ace', 1, 0),
(2, '.arj', 1, 0),
(3, '.bz', 1, 0),
(4, '.bz2', 1, 0),
(5, '.cab', 1, 0),
(6, '.exe', 1, 0),
(7, '.gif', 0, 1),
(8, '.gz', 1, 0),
(9, '.iso', 1, 0),
(10, '.jpeg', 0, 1),
(11, '.jpg', 0, 1),
(12, '.lha', 1, 0),
(13, '.lzh', 1, 0),
(14, '.png', 0, 1),
(15, '.rar', 1, 0),
(16, '.tar', 1, 0),
(17, '.tgz', 1, 0),
(18, '.uue', 1, 0),
(19, '.zip', 1, 0),
(20, '.zoo', 1, 0);

CREATE TABLE IF NOT EXISTS `nuke_nsngd_mods` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `modifier` varchar(60) COLLATE utf8_bin NOT NULL,
  `sub_ip` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0.0.0.0',
  `brokendownload` int(3) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `filesize` bigint(20) NOT NULL DEFAULT '0',
  `version` varchar(20) COLLATE utf8_bin NOT NULL,
  `homepage` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`rid`),
  UNIQUE KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_nsngd_new` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `submitter` varchar(60) COLLATE utf8_bin NOT NULL,
  `sub_ip` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0.0.0.0',
  `filesize` bigint(20) NOT NULL DEFAULT '0',
  `version` varchar(20) COLLATE utf8_bin NOT NULL,
  `homepage` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `lid` (`lid`),
  KEY `cid` (`cid`),
  KEY `sid` (`sid`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_nsnst_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_nsnst_config` (`config_name`, `config_value`) VALUES
('admin_contact', 'webmaster@yoursite.com'),
('block_perpage', '50'),
('block_sort_column', 'date'),
('block_sort_direction', 'desc'),
('crypt_salt', 'N$'),
('disable_switch', '0'),
('display_link', '3'),
('display_reason', '3'),
('dump_directory', 'cache/'),
('flood_delay', '2'),
('force_nukeurl', '0'),
('ftaccess_path', ''),
('help_switch', '1'),
('htaccess_path', ''),
('http_auth', '0'),
('ip2c_version', '0'),
('list_harvester', '@yahoo.com\r\nalexibot\r\nalligator\r\nanonymiz\r\nasterias\r\nbackdoorbot\r\nblack hole\r\nblackwidow\r\nblowfish\r\nbotalot\r\nbuiltbottough\r\nbullseye\r\nbunnyslippers\r\ncatch\r\ncegbfeieh\r\ncharon\r\ncheesebot\r\ncherrypicker\r\nchinaclaw\r\ncombine\r\ncopyrightcheck\r\ncosmos\r\ncrescent\r\ncurl\r\ndbrowse\r\ndisco\r\ndittospyder\r\ndlman\r\ndnloadmage\r\ndownload\r\ndreampassport\r\ndts agent\r\necatch\r\neirgrabber\r\nerocrawler\r\nexpress webpictures\r\nextractorpro\r\neyenetie\r\nfantombrowser\r\nfantomcrew browser\r\nfileheap\r\nfilehound\r\nflashget\r\nfoobot\r\nfranklin locator\r\nfreshdownload\r\nfscrawler\r\ngamespy_arcade\r\ngetbot\r\ngetright\r\ngetweb\r\ngo!zilla\r\ngo-ahead-got-it\r\ngrab\r\ngrafula\r\ngsa-crawler\r\nharvest\r\nhloader\r\nhmview\r\nhttplib\r\nhttpresume\r\nhttrack\r\nhumanlinks\r\nigetter\r\nimage stripper\r\nimage sucker\r\nindustry program\r\nindy library\r\ninfonavirobot\r\ninstallshield digitalwizard\r\ninterget\r\niria\r\nirvine\r\niupui research bot\r\njbh agent\r\njennybot\r\njetcar\r\njobo\r\njoc\r\nkapere\r\nkenjin spider\r\nkeyword density\r\nlarbin\r\nleechftp\r\nleechget\r\nlexibot\r\nlibweb/clshttp\r\nlibwww-perl\r\nlightningdownload\r\nlincoln state web browser\r\nlinkextractorpro\r\nlinkscan/8.1a.unix\r\nlinkwalker\r\nlwp-trivial\r\nlwp::simple\r\nmac finder\r\nmata hari\r\nmediasearch\r\nmetaproducts\r\nmicrosoft url control\r\nmidown tool\r\nmiixpc\r\nmissauga locate\r\nmissouri college browse\r\nmister pix\r\nmoget\r\nmozilla.*newt\r\nmozilla/3.0 (compatible)\r\nmozilla/3.mozilla/2.01\r\nmsie 4.0 (win95)\r\nmultiblocker browser\r\nmydaemon\r\nmygetright\r\nnabot\r\nnavroad\r\nnearsite\r\nnet vampire\r\nnetants\r\nnetmechanic\r\nnetpumper\r\nnetspider\r\nnewsearchengine\r\nnicerspro\r\nninja\r\nnitro downloader\r\nnpbot\r\noctopus\r\noffline explorer\r\noffline navigator\r\nopenfind\r\npagegrabber\r\npapa foto\r\npavuk\r\npbrowse\r\npcbrowser\r\npeval\r\npompos/\r\nprogram shareware\r\npropowerbot\r\nprowebwalker\r\npsurf\r\npuf\r\npuxarapido\r\nqueryn metasearch\r\nrealdownload\r\nreget\r\nrepomonkey\r\nrsurf\r\nrumours-agent\r\nsakura\r\nscan4mail\r\nsemanticdiscovery\r\nsitesnagger\r\nslysearch\r\nspankbot\r\nspanner \r\nspiderzilla\r\nsq webscanner\r\nstamina\r\nstar downloader\r\nsteeler\r\n\r\nstrip\r\nsuperbot\r\nsuperhttp\r\nsurfbot\r\nsuzuran\r\nswbot\r\nszukacz\r\ntakeout\r\nteleport\r\ntelesoft\r\ntest spider\r\nthe intraformant\r\nthenomad\r\ntighttwatbot\r\ntitan\r\ntocrawl/urldispatcher\r\ntrue_robot\r\ntsurf\r\nturing machine\r\nturingos\r\nurlblaze\r\nurlgetfile\r\nurly warning\r\nutilmind\r\nvci\r\nvoideye\r\nweb image collector\r\nweb sucker\r\nwebauto\r\nwebbandit\r\nwebcapture\r\nwebcollage\r\nwebcopier\r\nwebenhancer\r\nwebfetch\r\nwebgo\r\nwebleacher\r\nwebmasterworldforumbot\r\nwebql\r\nwebreaper\r\nwebsite extractor\r\nwebsite quester\r\nwebster\r\nwebstripper\r\nwebwhacker\r\nwep search\r\nwget\r\nwhizbang\r\nwidow\r\nwildsoft surfer\r\nwww-collector-e\r\nwww.netwu.com\r\nwwwoffle\r\nxaldon\r\nxenu\r\nzeus\r\nziggy\r\nzippy'),
('list_referer', '121hr.com\r\n1st-call.net\r\n1stcool.com\r\n5000n.com\r\n69-xxx.com\r\n9irl.com\r\n9uy.com\r\na-day-at-the-party.com\r\naccessthepeace.com\r\nadult-model-nude-pictures.com\r\nadult-sex-toys-free-porn.com\r\nagnitum.com\r\nalfonssackpfeiffe.com\r\nalongwayfrommars.com\r\nanime-sex-1.com\r\nanorex-sf-stimulant-free.com\r\nantibot.net\r\nantique-tokiwa.com\r\napotheke-heute.com\r\narmada31.com\r\nartark.com\r\nartlilei.com\r\nascendbtg.com\r\naschalaecheck.com\r\nasian-sex-free-sex.com\r\naslowspeeker.com\r\nassasinatedfrogs.com\r\nathirst-for-tranquillity.net\r\naubonpanier.com\r\navalonumc.com\r\nayingba.com\r\nbayofnoreturn.com\r\nbbw4phonesex.com\r\nbeersarenotfree.com\r\nbierikiuetsch.com\r\nbilingualannouncements.com\r\nblack-pussy-toon-clip-anal-lover-single.com\r\nblownapart.com\r\nblueroutes.com\r\nboasex.com\r\nbooksandpages.com\r\nbootyquake.com\r\nbossyhunter.com\r\nboyz-sex.com\r\nbrokersaandpokers.com\r\nbrowserwindowcleaner.com\r\nbudobytes.com\r\nbusiness2fun.com\r\nbuymyshitz.com\r\nbyuntaesex.com\r\ncaniputsomeloveintoyou.com\r\ncartoons.net.ru\r\ncaverunsailing.com\r\ncertainhealth.com\r\nclantea.com\r\nclose-protection-services.com\r\nclubcanino.com\r\nclubstic.com\r\ncobrakai-skf.com\r\ncollegefucktour.co.uk\r\ncommanderspank.com\r\ncoolenabled.com\r\ncrusecountryart.com\r\ncrusingforsex.co.uk\r\ncunt-twat-pussy-juice-clit-licking.com\r\ncustomerhandshaker.com\r\ncyborgrama.com\r\ndarkprofits.co.uk\r\ndatingforme.co.uk\r\ndatingmind.com\r\ndegree.org.ru\r\ndelorentos.com\r\ndiggydigger.com\r\ndinkydonkyaussie.com\r\ndjpritchard.com\r\ndjtop.com\r\ndraufgeschissen.com\r\ndreamerteens.co.uk\r\nebonyarchives.co.uk\r\nebonyplaya.co.uk\r\necobuilder2000.com\r\nemailandemail.com\r\nemedici.net\r\nengine-on-fire.com\r\nerocity.co.uk\r\nesport3.com\r\neteenbabes.com\r\neurofreepages.com\r\neurotexans.com\r\nevolucionweb.com\r\nfakoli.com\r\nfe4ba.com\r\nferienschweden.com\r\nfindly.com\r\nfirsttimeteadrinker.com\r\nfishing.net.ru\r\nflatwonkers.com\r\nflowershopentertainment.com\r\nflymario.com\r\nfree-xxx-pictures-porno-gallery.com\r\nfreebestporn.com\r\nfreefuckingmovies.co.uk\r\nfreexxxstuff.co.uk\r\nfruitologist.net\r\nfruitsandbolts.com\r\nfuck-cumshots-free-midget-movie-clips.com\r\nfuck-michaelmoore.com\r\nfundacep.com\r\ngadless.com\r\ngallapagosrangers.com\r\ngalleries4free.co.uk\r\ngalofu.com\r\ngaypixpost.co.uk\r\ngeomasti.com\r\ngirltime.co.uk\r\nglassrope.com\r\ngodjustblessyouall.com\r\ngoldenageresort.com\r\ngonnabedaddies.com\r\ngranadasexi.com\r\n\r\nguardingtheangels.com\r\nguyprofiles.co.uk\r\nhappy1225.com\r\nhappychappywacky.com\r\nhealth.org.ru\r\nhexplas.com\r\nhighheelsmodels4fun.com\r\nhillsweb.com\r\nhiptuner.com\r\nhistoryintospace.com\r\nhoa-tuoi.com\r\nhomebuyinginatlanta.com\r\nhorizonultra.com\r\nhorseminiature.net\r\nhotkiss.co.uk\r\nhotlivegirls.co.uk\r\nhotmatchup.co.uk\r\nhusler.co.uk\r\niaentertainment.com\r\niamnotsomeone.com\r\niconsofcorruption.com\r\nihavenotrustinyou.com\r\ninformat-systems.com\r\ninteriorproshop.com\r\nintersoftnetworks.com\r\ninthecrib.com\r\ninvestment4cashiers.com\r\niti-trailers.com\r\njackpot-hacker.com\r\njacks-world.com\r\njamesthesailorbasher.com\r\njesuislemonds.com\r\njustanotherdomainname.com\r\nkampelicka.com\r\nkanalrattenarsch.com\r\nkatzasher.com\r\nkerosinjunkie.com\r\nkillasvideo.com\r\nkoenigspisser.com\r\nkontorpara.com\r\nl8t.com\r\nlaestacion101.com\r\nlambuschlamppen.com\r\nlankasex.co.uk\r\nlaser-creations.com\r\nle-tour-du-monde.com\r\nlecraft.com\r\nledo-design.com\r\nleftregistration.com\r\nlekkikoomastas.com\r\nlepommeau.com\r\nlibr-animal.com\r\nlibraries.org.ru\r\nlikewaterlikewind.com\r\nlimbojumpers.com\r\nlink.ru\r\nlockportlinks.com\r\nloiproject.com\r\nlongtermalternatives.com\r\nlottoeco.com\r\nlucalozzi.com\r\nmaki-e-pens.com\r\nmalepayperview.co.uk\r\nmangaxoxo.com\r\nmaps.org.ru\r\nmarcofields.com\r\nmasterofcheese.com\r\nmasteroftheblasterhill.com\r\nmastheadwankers.com\r\nmegafrontier.com\r\nmeinschuppen.com\r\nmercurybar.com\r\nmetapannas.com\r\nmicelebre.com\r\nmidnightlaundries.com\r\nmikeapartment.co.uk\r\nmillenniumchorus.com\r\nmimundial2002.com\r\nminiaturegallerymm.com\r\nmixtaperadio.com\r\nmondialcoral.com\r\nmonja-wakamatsu.com\r\nmonstermonkey.net\r\nmouthfreshners.com\r\nmullensholiday.com\r\nmusilo.com\r\nmyhollowlog.com\r\nmyhomephonenumber.com\r\nmykeyboardisbroken.com\r\nmysofia.net\r\nnaked-cheaters.com\r\nnaked-old-women.com\r\nnastygirls.co.uk\r\nnationclan.net\r\nnatterratter.com\r\nnaughtyadam.com\r\nnestbeschmutzer.com\r\nnetwu.com\r\nnewrealeaseonline.com\r\nnewrealeasesonline.com\r\nnextfrontiersonline.com\r\nnikostaxi.com\r\nnotorious7.com\r\nnrecruiter.com\r\nnursingdepot.com\r\nnustramosse.com\r\nnuturalhicks.com\r\noccaz-auto49.com\r\nocean-db.net\r\noilburnerservice.net\r\nomburo.com\r\noneoz.com\r\nonepageahead.net\r\nonlinewithaline.com\r\norganizate.net\r\nourownweddingsong.com\r\nowen-music.com\r\np-partners.com\r\npaginadeautor.com\r\npakistandutyfree.com\r\npamanderson.co.uk\r\nparentsense.net\r\nparticlewave.net\r\npay-clic.com\r\npay4link.net\r\npcisp.com\r\npersist-pharma.com\r\npeteband.com\r\npetplusindia.com\r\npickabbw.co.uk\r\npicture-oral-position-lesbian.com\r\npl8again.com\r\nplaneting.net\r\npopusky.com\r\nporn-expert.com\r\npromoblitza.com\r\nproproducts-usa.com\r\nptcgzone.com\r\nptporn.com\r\npublishmybong.com\r\nputtingtogether.com\r\nqualifiedcancelations.com\r\nrahost.com\r\nrainbow21.com\r\nrakkashakka.com\r\nrandomfeeding.com\r\nrape-art.com\r\nrd-brains.com\r\nrealestateonthehill.net\r\nrebuscadobot\r\nrequested-stuff.com\r\nretrotrasher.com\r\nricopositive.com\r\nrisorseinrete.com\r\nrotatingcunts.com\r\nrunawayclicks.com\r\nrutalibre.com\r\ns-marche.com\r\nsabrosojazz.com\r\nsamuraidojo.com\r\nsanaldarbe.com\r\nsasseminars.com\r\nschlampenbruzzler.com\r\nsearchmybong.com\r\nseckur.com\r\nsex-asian-porn-interracial-photo.com\r\nsex-porn-fuck-hardcore-movie.com\r\nsexa3.net\r\nsexer.com\r\nsexintention.com\r\nsexnet24.tv\r\nsexomundo.com\r\nsharks.com.ru\r\nshells.com.ru\r\nshop-ecosafe.com\r\nshop-toon-hardcore-fuck-cum-pics.com\r\nsilverfussions.com\r\nsin-city-sex.net\r\nsluisvan.com\r\nsmutshots.com\r\nsnagglersmaggler.com\r\nsomethingtoforgetit.com\r\nsophiesplace.net\r\nsoursushi.com\r\nsouthernxstables.com\r\nspeed467.com\r\nspeedpal4you.com\r\nsporty.org.ru\r\nstopdriving.net\r\nstw.org.ru\r\nsufficientlife.com\r\nsussexboats.net\r\nswinger-party-free-dating-porn-sluts.com\r\nsydneyhay.com\r\nszmjht.com\r\nteninchtrout.com\r\nthebalancedfruits.com\r\ntheendofthesummit.com\r\nthiswillbeit.com\r\nthosethosethose.com\r\nticyclesofindia.com\r\ntits-gay-fagot-black-tits-bigtits-amateur.com\r\ntonius.com\r\ntoohsoft.com\r\ntoolvalley.com\r\ntooporno.net\r\ntoosexual.com\r\ntorngat.com\r\ntour.org.ru\r\ntowneluxury.com\r\ntrafficmogger.com\r\ntriacoach.net\r\ntrottinbob.com\r\ntttframes.com\r\ntvjukebox.net\r\nundercvr.com\r\nunfinished-desires.com\r\nunicornonero.com\r\nunionvillefire.com\r\nupsandowns.com\r\nupthehillanddown.com\r\nvallartavideo.com\r\nvietnamdatingservices.com\r\nvinegarlemonshots.com\r\nvizy.net.ru\r\nvnladiesdatingservices.com\r\nvomitandbusted.com\r\nwalkingthewalking.com\r\nwell-I-am-the-type-of-boy.com\r\nwhales.com.ru\r\nwhincer.net\r\nwhitpagesrippers.com\r\nwhois.sc\r\nwipperrippers.com\r\nwordfilebooklets.com\r\nworld-sexs.com\r\nxsay.com\r\nxxxchyangel.com\r\nxxxx:\r\nxxxzips.com\r\nyouarelostintransit.com\r\nyuppieslovestocks.com\r\nyuzhouhuagong.com\r\nzhaori-food.com\r\nzwiebelbacke.com'),
('list_string', ''),
('lookup_link', 'http://www.DNSstuff.com/tools/whois.ch?ip='),
('page_delay', '5'),
('prevent_dos', '0'),
('proxy_reason', 'admin_proxy_reason.tpl'),
('proxy_switch', '0'),
('santy_protection', '1'),
('self_expire', '0'),
('show_right', '0'),
('site_reason', 'admin_site_reason.tpl'),
('site_switch', '0'),
('staccess_path', ''),
('test_switch', '0'),
('track_active', '0'),
('track_clear', '0'),
('track_max', '604800'),
('track_perpage', '50'),
('track_sort_column', '6'),
('track_sort_direction', 'desc'),
('version_check', '1191745602'),
('version_newest', '2.5.16'),
('version_number', '2.6.01'),
('disable_from_date', '2011-03-28 2:04:24'),
('disable_to_date', '2011-03-31 6:25:34'),
('disable_reason', '');


CREATE TABLE IF NOT EXISTS `nuke_extpages` (
  `pid` int(10) NOT NULL auto_increment,
  `title` varchar(255) collate utf8_bin NOT NULL,
  `slug` text collate utf8_bin NOT NULL,
  `text` text collate utf8_bin NOT NULL,
  `counter` int(10) NOT NULL default '0',
  `perm` int(1) NOT NULL default '0',
  `nav` int(1) NOT NULL default '0',
  `post_time` datetime NOT NULL,
  `active` int(1) NOT NULL default '0',
  PRIMARY KEY  (`pid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;


CREATE TABLE IF NOT EXISTS `nuke_pollcomments` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `pollID` int(11) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `name` varchar(60) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `host_name` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `subject` varchar(60) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `score` tinyint(4) NOT NULL DEFAULT '0',
  `reason` tinyint(4) NOT NULL DEFAULT '0',
  `last_moderation_ip` varchar(15) COLLATE utf8_bin DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `pollID` (`pollID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_pollcomments_moderated` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `pollID` int(11) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `name` varchar(60) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `host_name` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `subject` varchar(60) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `score` tinyint(4) NOT NULL DEFAULT '0',
  `reason` tinyint(4) NOT NULL DEFAULT '0',
  `last_moderation_ip` varchar(15) COLLATE utf8_bin DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `tid` (`tid`),
  KEY `pid` (`pid`),
  KEY `pollID` (`pollID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_poll_check` (
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `time` varchar(14) COLLATE utf8_bin NOT NULL,
  `pollID` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_poll_data` (
  `pollID` int(11) NOT NULL DEFAULT '0',
  `optionText` char(50) COLLATE utf8_bin NOT NULL,
  `optionCount` int(11) NOT NULL DEFAULT '0',
  `voteID` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_poll_data` (`pollID`, `optionText`, `optionCount`, `voteID`) VALUES
(1, 'معمولی', 0, 1),
(1, 'متوسط', 0, 2),
(1, 'خوب', 0, 3),
(1, 'عالی', 0, 4),
(1, '', 0, 5),
(1, '', 0, 6),
(1, '', 0, 7),
(1, '', 0, 8),
(1, '', 0, 9),
(1, '', 0, 10),
(1, '', 0, 11),
(1, '', 0, 12),
(2, 'Bad', 0, 1),
(2, 'Not bad', 0, 2),
(2, 'Good', 0, 3),
(2, 'Excellent', 0, 4),
(2, '', 0, 5),
(2, '', 0, 6),
(2, '', 0, 7),
(2, '', 0, 8),
(2, '', 0, 9),
(2, '', 0, 10),
(2, '', 0, 11),
(2, '', 0, 12);

CREATE TABLE IF NOT EXISTS `nuke_poll_desc` (
  `pollID` int(11) NOT NULL AUTO_INCREMENT,
  `pollTitle` varchar(100) COLLATE utf8_bin NOT NULL,
  `timeStamp` int(11) NOT NULL DEFAULT '0',
  `voters` mediumint(9) NOT NULL DEFAULT '0',
  `planguage` varchar(30) COLLATE utf8_bin NOT NULL,
  `artid` int(10) NOT NULL DEFAULT '0',
  `comments` int(11) DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pollID`),
  KEY `pollID` (`pollID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

INSERT INTO `nuke_poll_desc` (`pollID`, `pollTitle`, `timeStamp`, `voters`, `planguage`, `artid`, `comments`, `active`) VALUES
(1, 'پرتال نیوک لرن را چگونه ارزیابی می کنید ؟', 1310192663, 0, 'persian', 0, 0, 1),
(2, 'How do u evaluate MarlikCMS CMS ?', 1310192663, 0, 'english', 0, 0, 1);

CREATE TABLE IF NOT EXISTS `nuke_public_messages` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime DEFAULT NULL,
  `who` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_quotes` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote` text COLLATE utf8_bin,
  PRIMARY KEY (`qid`),
  KEY `qid` (`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating_id` int(11) NOT NULL DEFAULT '0',
  `rating_num` int(11) NOT NULL DEFAULT '0',
  `section` int(1) NOT NULL DEFAULT '0',
  `ip` varchar(25) COLLATE utf8_bin NOT NULL,
  `voter` varchar(256) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `nuke_related` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `url` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `rid` (`rid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `nuke_session`;
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
  UNIQUE KEY `session_id` (`session_id`),
  KEY `session_user_id` (`session_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `nuke_sitemap_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE IF NOT EXISTS `nuke_sitemap_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO `nuke_sitemap_config` (`config_name`, `config_value`) VALUES
('match_theme', '1'),
('use_sommaire', '0'),
('use_gt', '1'),
('show_google_block', '1'),
('show_gentime', '1'),
('show_news', '1'),
('show_fna', '0'),
('show_forum_cat', '1'),
('show_forums', '1'),
('show_forum_topics', '1'),
('show_kb', '0'),
('show_downloads', '1'),
('show_weblinks', '1'),
('show_faq', '1'),
('show_content', '0'),
('show_reviews', '0'),
('show_tutorials', '0'),
('show_projects', '0'),
('show_supporters', '1'),
('show_shouts', '1'),
('show_coppermine', '0'),
('show_spchat', '0'),
('show_arcade', '0'),
('show_rss', '1'),
('limit_news', '50'),
('limit_fna', '50'),
('limit_forum_topics', '100'),
('limit_kb', '100'),
('limit_downloads', '100'),
('limit_weblinks', '50'),
('limit_content', '20'),
('limit_reviews', '20'),
('limit_tutorials', '20'),
('limit_projects', '20'),
('limit_supporters', '20'),
('limit_shouts', '50'),
('limit_coppermine_pics', '50'),
('limit_arcade', '100'),
('site_logo', 'logo.gif'),
('site_logo_path', 'images/'),
('site_google_logo_height', '50'),
('site_google_logo_width', '425'),
('site_google_header', '#ffffff'),
('site_google_bg', '#ffffff'),
('google_logo', 'google.gif'),
('google_logo_path', 'images/powered/'),
('sitemap_version', '2.0.0');


CREATE TABLE IF NOT EXISTS `nuke_squestions` (
  `qid` int(2) NOT NULL AUTO_INCREMENT,
  `question` varchar(256) COLLATE utf8_bin NOT NULL,
  `answer` varchar(256) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;

INSERT INTO `nuke_squestions` (`qid`, `question`, `answer`) VALUES
(1, '2+2 = ', '4');


CREATE TABLE IF NOT EXISTS `nuke_stories` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `aid` varchar(30) COLLATE utf8_bin NOT NULL,
  `title` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `hometext` text COLLATE utf8_bin,
  `bodytext` text COLLATE utf8_bin NOT NULL,
  `newsref` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `newsreflink` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `comments` int(11) NOT NULL DEFAULT '0',
  `counter` mediumint(8) NOT NULL DEFAULT '0',
  `topic` int(3) NOT NULL DEFAULT '1',
  `informant` varchar(25) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `ihome` int(1) NOT NULL DEFAULT '0',
  `alanguage` varchar(30) COLLATE utf8_bin NOT NULL,
  `acomm` int(1) NOT NULL DEFAULT '0',
  `hotnews` int(1) NOT NULL DEFAULT '0',
  `haspoll` int(1) NOT NULL DEFAULT '0',
  `pollID` int(10) NOT NULL DEFAULT '0',
  `associated` varchar(255) COLLATE utf8_bin NOT NULL,
  `tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `section` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT 'news',
  `rate` int(8) NOT NULL DEFAULT '0',
  `rates_count` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `tags` (`tags`),
  KEY `associated` (`associated`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO `nuke_stories` (`sid`, `catid`, `aid`, `title`, `time`, `hometext`, `bodytext`, `newsref`, `newsreflink`, `comments`, `counter`, `topic`, `informant`, `notes`, `ihome`, `alanguage`, `acomm`, `hotnews`, `haspoll`, `pollID`, `associated`, `tags`, `approved`, `section`, `rate`, `rates_count`) VALUES
(1, 0, 'admin', 'پرتال نیوک لرن نسخه 1.1.6 با موفقیت نصب شد .', '2010-07-19 10:51:37', 0x3c703ed8aed8b4d986d988d8afdb8cd98520daa9d98720d8b4d985d8a720d8a7d8b220d986d8b1d98520d8a7d981d8b2d8a7d8b120d8b3d8a7db8cd8aa20d8b3d8a7d8b220d986db8cd988daa920d984d8b1d98620d8a7d8b3d8aad981d8a7d8afd98720d985db8c20daa9d986db8cd8af202e20d8a7db8cd98620d986d8b1d98520d8a7d981d8b2d8a7d8b120d8afd8b120d986d8b3d8aed98720312e312e3620d8a7d985daa9d8a7d986d8a7d8aa20d981d8b1d8a7d988d8a7d986db8c20d8b1d8a720d8acd8a7db8c20d8afd8a7d8afd98720d8a7d8b3d8aa202e3c2f703e0d0a0d0a3c70207374796c653d22746578742d616c69676e3a2063656e7465723b223e3c696d67207372633d22696e636c756465732f656c66696e6465722f2e2e2f75706c6f61642f4e756b656c6561726e2f4e756b656c6561726e5553562e706e6722207374796c653d2233333770783b206865696768743a2033323370783b22202f3e3c2f703e0d0a0d0a3c703ed8afd8b120d986d8b3d8aed98720312e312e3620d9bed8b1d8aad8a7d98420d986db8cd988daa920d984d8b1d98620d8a7d985daa9d8a7d986d8a7d8aadb8c20d986d8b8db8cd8b1203a3c2f703e0d0a0d0a3c703e266e6273703b3c2f703e0d0a0d0a3c6469763e2d20d8b3db8cd8b3d8aad98520d986d8b5d8a820d982d8a7d984d8a820d8a8d98720d8b5d988d8b1d8aa20d8afd8a7d986d984d988d8af20d8a7d8a8d8b1db8c20d8a8d8b120d8b1d988db8c20d8b3d8a7db8cd8aa3c2f6469763e0d0a0d0a3c6469763e2d20d8a8d987db8cd986d98720d8b3d8a7d8b2db8c20d987d8b3d8aad98720d8b3db8cd8b3d8aad98520d98820d8a8d98720d8b1d988d8b220d8b1d8b3d8a7d986db8c20daa9d8afd987d8a720d8a8d8b1d8a7db8c20d8b3d8a7d8b2daafd8a7d8b1db8c20d8a8db8cd8b4d8aad8b13c2f6469763e0d0a0d0a3c6469763e2d20d8add8b0d98120d986daafd987d8a8d8a7d98620d8b3d8a7db8cd8aa20d98820d8acd8a7db8cdaafd8b2db8cd986db8c20d8afdb8cd988d8a7d8b1d98720d8a2d8aad8b4266e6273703b3c2f6469763e0d0a0d0a3c6469763e2d20d8a8d987db8cd986d98720d8b3d8a7d8b2db8c20d8b3d8a6d98820d98820db8cdaa9d9bed8a7d8b1da86d98720d8b3d8a7d8b2db8c20d8aad8badb8cdb8cd8b120d985d8b3db8cd8b1d987d8a73c2f6469763e0d0a0d0a3c6469763e2d20d8b8d8a7d987d8b120d8acd8afdb8cd8af20d985d8afdb8cd8b1db8cd8aa20d8b3d8a7db8cd8aa20d98820daa9d8a7d8b1d8a8d8b1db8c3c2f6469763e0d0a0d0a3c6469763e2d20d986d8b3d8aed987203420d988db8cd8b1d8a7db8cd8b4daafd8b120436b656469746f723c2f6469763e0d0a0d0a3c6469763e2d20d986d8b3d8aed98720312e3220d985d8afdb8cd8b1db8cd8aa20d981d8a7db8cd98420d987d8a73c2f6469763e0d0a0d0a3c703e3c6120687265663d22687474703a2f2f6172656135312e6e756b656c6561726e2e636f6d2f223ed8b4d985d8a720d986db8cd8b220d985db8c20d8aad988d8a7d986db8cd8af20d8a7d985daa9d8a7d986d8a7d8aa20d985d988d8b1d8af20d986d8b8d8b120d8aed988d8af20d8b1d8a720d9bedb8cd8b4d986d987d8a7d8af20d8afd987db8cd8af3c2f613e3c2f703e0d0a0d0a3c703ed8afd8b1203c6120687265663d22687474703a2f2f627567732e6e756b656c6561726e2e636f6d2f223e3c7374726f6e673ed8a7db8cd98620d984db8cd8b3d8aa3c2f7374726f6e673e3c2f613e20d8b3d8b9db8c20d8b4d8afd98720d8a7d8b3d8aa20d8a8db8cd8b4d8aad8b120d8a7d8b4daa9d8a7d984d8a7d8aa20daafd8b2d8a7d8b1d8b420d8b4d8afd98720d8a8d8b1d8b7d8b1d98120d8b4d988d8af202e3c2f703e0d0a0d0a3c703ed8a8d8a720d8a7d985db8cd8af20d8a8d98720d8a7d981d8aad8aed8a7d8b120d8a2d981d8b1db8cd986db8c20d8a8d8b1d8a7db8c20d8a7db8cd8b1d8a7d986db8c20d987d8a73c2f703e0d0a0d0a3c703edaafd8b1d988d98720d986db8cd988daa920d984d8b1d9863c2f703e0d0a0d0a3c703ed981d8b1d8b4d8a7d8af20d8bad8b6d986d981d8b1db8c3c2f703e0d0a, '', '', '', 1, 370, 0, '', '', 0, 'persian', 0, 1, 0, 0, 0x312d322d, ' ', 1, 'news', 4, 1),
(2, 0, 'admin', 'MarlikCMS CMS version Tigris 1.1.6  is installed succefuly', '2011-01-26 13:18:01', 0x3c703e0d0a09266e6273703b3c2f703e0d0a3c646976207374796c653d22746578742d616c69676e3a206c6566743b20223e0d0a09436f6e67726174756c6174696f6e732120596f75206861766520696e7374616c6c6564204e756b656c6561726e20434d532056657273696f6e20312e312e36202e204e756b656c6561726e2674726164653b20636f6d6573207769746820746865206d6f737420757020746f206461746520666561747572657320617661696c61626c6520666f7220686176696e67206120636f6d70726568656e736976652077656273697465202c20696e636c7564696e6720647261672026616d703b2064726f7020626c6f636b73202c206e65772074656d706c61746520656e67696e6520746f20736d6f6f74682064657369676e696e672068616269747320616e64206c6f7473206f662070726f66657373696f6e616c20666561747572657320616c6c20666f722066726565202e3c2f6469763e0d0a3c646976207374796c653d22746578742d616c69676e3a206c6566743b20223e0d0a09266e6273703b3c2f6469763e0d0a3c646976207374796c653d22746578742d616c69676e3a2063656e7465723b20223e0d0a093c696d6720616c743d2222207372633d22696e636c756465732f656c66696e6465722f2e2e2f75706c6f61642f4e756b656c6561726e2f4e756b656c6561726e5553562e706e6722207374796c653d2233333770783b206865696768743a2033323370783b2022202f3e3c2f6469763e0d0a3c646976207374796c653d22746578742d616c69676e3a206c6566743b20223e0d0a09266e6273703b3c2f6469763e0d0a3c646976207374796c653d22746578742d616c69676e3a206c6566743b20223e0d0a09636865636b206f7574206f7572207765627369746520616e64206b65657020657965206f6e20746865206c6174657374206e65777320666f72204e756b656c6561726e20434d533c2f6469763e0d0a, '', '', '', 0, 1, 0, 'admin', '', 0, 'english', 0, 0, 0, 0, 0x322d, ' 2 ', 1, 'news', 0, 0);


DROP TABLE IF EXISTS `nuke_shoutbox`;
CREATE TABLE IF NOT EXISTS `nuke_shoutbox` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'anonimous',
  `message` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;


INSERT INTO `nuke_shoutbox` (`id`, `date`, `user`, `message`) VALUES
(1, '2011-04-05 18:37:41', 'admin', '_WELCOMEYOU');

CREATE TABLE IF NOT EXISTS `nuke_tags` (
  `tid` int(5) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `count` int(6) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `nuke_tags` (`tid`, `tag`, `slug`, `count`) VALUES
(1, 'MarlikCMS', 'MarlikCMS', 1);



CREATE TABLE IF NOT EXISTS `nuke_topics` (
  `topicid` int(3) NOT NULL AUTO_INCREMENT,
  `topicname` varchar(70) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `slug` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `topicimage` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `topictext` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topicid`),
  KEY `topicid` (`topicid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

INSERT INTO `nuke_topics` (`topicid`, `topicname`, `slug`, `topicimage`, `topictext`, `parent`, `counter`) VALUES
(1, 'نیوک لرن', 'MarlikCMS', 'Groups.png', 'نیوک لرن نرم افزار ایرانی', 0, 0),
(2, 'اخبار', 'news', 'Groups.png', 'اخبار مرتبط با سایت ', 1, 0),
(3, 'متفرقه', 'others', 'Groups.png', 'موضوعات متفرقه', 0, 0);



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
(1, '_RSS_NEWS', '', 0, 0, '0', '|_self', 'News', 'archive.png'),
(3, '_BMEMP', '', 1, 0, '0', '|_self', 'Your_Account', 'users.png'),
(4, '_OTHER', '', 2, 0, '0', '|_self', '', 'item.png'),
(5, '_SUBMIT_NEWS', '', 0, 1, '1', '|_self', 'Submit_News', ''),
(6, '_ARCHIVE', '', 1, 1, '1', '|_self', 'Stories_Archive', ''),
(7, '_AVANTGO', '', 2, 1, '1', '|_self', 'AvantGo', ''),
(8, '_SEARCH', '', 3, 1, '1', '|_self', 'Search', ''),
(9, '_ACCOUNT', '', 2, 3, '1', '|_self', 'Your_Account', ''),
(10,'_JOURNAL', '', 0, 3, '1', '|_self', 'Your_Account', ''),
(12, '_CALENDAR', '', 0, 4, '1', '|_self', 'jCalendar', ''),
(13, '_ADMIN_MODULE_SITEMAP', '', 1, 4, '1', '|_self', 'Site_Map', ''),
(17, '_ACCOUNT_EDIT', '', 1, 3, '1', 'modules.php?name=Your_Account&op=edituser|_self', '', ''),
(18, '_CONTACT_US', '', 8, 4, '1', '|_self', 'Contact_Plus', ''),
(19, '_RECOMMENDUS', '', 2, 4, '1', '|_self', 'Recommend_Us', ''),
(20, '_ADVERTISING', '', 4, 4, '1', '|_self', 'Advertising', ''),
(21, '_ADMIN_MODULE_LINKTOUS', '', 5, 4, '1', '|_self', 'Link_To_Us', ''),
(22, '_TOP', '', 6, 4, '1', '|_self', 'Top', ''),
(23, '_TOPICS', '', 4, 1, '1', '|_self', 'Topics', ''),
(24, '_BMEMP', '', 3, 3, '1', 'modules.php?name=Your_Account&amp;op=memberlist|_self', '', ''),
(25, '_WEBLINKS', '', 7, 4, '1', '|_self', 'Web_Links', ''),
(26, '_ADMIN_STATADMIN', '', 8, 4, '1', '|_self', 'Statistics', '');


CREATE TABLE IF NOT EXISTS `nuke_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `femail` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_regdate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `user_icq` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `user_occ` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `user_from` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `user_from_flag` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `user_interests` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `user_sig` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_viewemail` tinyint(2) DEFAULT NULL,
  `user_theme` int(3) DEFAULT NULL,
  `user_aim` varchar(18) COLLATE utf8_bin DEFAULT NULL,
  `user_yim` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `user_msnm` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `user_password` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `storynum` tinyint(4) NOT NULL DEFAULT '10',
  `umode` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `uorder` tinyint(1) NOT NULL DEFAULT '0',
  `thold` tinyint(1) NOT NULL DEFAULT '0',
  `noscore` tinyint(1) NOT NULL DEFAULT '0',
  `bio` tinytext COLLATE utf8_bin,
  `ublockon` tinyint(1) NOT NULL DEFAULT '0',
  `ublock` tinytext COLLATE utf8_bin,
  `theme` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `commentmax` int(11) NOT NULL DEFAULT '255',
  `counter` int(11) NOT NULL DEFAULT '0',
  `newsletter` int(1) NOT NULL DEFAULT '0',
  `user_posts` int(10) NOT NULL DEFAULT '0',
  `user_attachsig` int(2) NOT NULL DEFAULT '0',
  `user_rank` int(10) NOT NULL DEFAULT '0',
  `user_level` int(10) NOT NULL DEFAULT '1',
  `broadcast` tinyint(1) NOT NULL DEFAULT '1',
  `popmeson` tinyint(1) NOT NULL DEFAULT '0',
  `user_active` tinyint(1) DEFAULT '1',
  `user_session_time` int(11) NOT NULL DEFAULT '0',
  `user_session_page` smallint(5) NOT NULL DEFAULT '0',
  `user_lastvisit` int(11) NOT NULL DEFAULT '0',
  `user_timezone` tinyint(4) NOT NULL DEFAULT '10',
  `user_style` tinyint(4) DEFAULT NULL,
  `user_lang` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'persian',
  `user_dateformat` varchar(14) COLLATE utf8_bin NOT NULL DEFAULT 'D M d, Y g:i a',
  `user_new_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_unread_privmsg` smallint(5) unsigned NOT NULL DEFAULT '0',
  `user_last_privmsg` int(11) NOT NULL DEFAULT '0',
  `user_emailtime` int(11) DEFAULT NULL,
  `user_allowhtml` tinyint(1) DEFAULT '1',
  `user_allowbbcode` tinyint(1) DEFAULT '1',
  `user_allowsmile` tinyint(1) DEFAULT '1',
  `user_allowavatar` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_pm` tinyint(1) NOT NULL DEFAULT '1',
  `user_allow_viewonline` tinyint(1) NOT NULL DEFAULT '1',
  `user_notify` tinyint(1) NOT NULL DEFAULT '0',
  `user_notify_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_popup_pm` tinyint(1) NOT NULL DEFAULT '0',
  `user_avatar_type` tinyint(4) NOT NULL DEFAULT '3',
  `user_sig_bbcode_uid` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `user_actkey` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `user_newpasswd` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `points` int(10) DEFAULT '0',
  `last_ip` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `agreedtos` tinyint(1) NOT NULL DEFAULT '0',
  `user_group_cp` int(11) NOT NULL DEFAULT '1',
  `user_group_list_cp` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '2',
  `user_active_cp` enum('YES','NO') COLLATE utf8_bin NOT NULL DEFAULT 'YES',
  `admin_allow_points` tinyint(1) NOT NULL DEFAULT '1',
  `karma` tinyint(1) DEFAULT '0',
  `user_level2` smallint(6) NOT NULL DEFAULT '2',
  `user_allowemails` tinyint(1) NOT NULL DEFAULT '1',
  `user_invisible` tinyint(1) NOT NULL DEFAULT '0',
  `user_lastaction` int(11) NOT NULL DEFAULT '0',
  `user_location` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_comments` smallint(6) unsigned NOT NULL DEFAULT '0',
  `user_blog_colors` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '#F9F1A9#EEE4C6#EDFAC8',
  `user_blog_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `rate` int(8) NOT NULL DEFAULT '0',
  `rates_count` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO `nuke_users` (`user_id`, `name`, `username`, `user_email`, `femail`, `user_website`, `user_avatar`, `user_regdate`, `user_icq`, `user_occ`, `user_from`, `user_from_flag`, `user_interests`, `user_sig`, `user_viewemail`, `user_theme`, `user_aim`, `user_yim`, `user_msnm`, `user_password`, `storynum`, `umode`, `uorder`, `thold`, `noscore`, `bio`, `ublockon`, `ublock`, `theme`, `commentmax`, `counter`, `newsletter`, `user_posts`, `user_attachsig`, `user_rank`, `user_level`, `broadcast`, `popmeson`, `user_active`, `user_session_time`, `user_session_page`, `user_lastvisit`, `user_timezone`, `user_style`, `user_lang`, `user_dateformat`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_emailtime`, `user_allowhtml`, `user_allowbbcode`, `user_allowsmile`, `user_allowavatar`, `user_allow_pm`, `user_allow_viewonline`, `user_notify`, `user_notify_pm`, `user_popup_pm`, `user_avatar_type`, `user_sig_bbcode_uid`, `user_actkey`, `user_newpasswd`, `points`, `last_ip`, `agreedtos`, `user_group_cp`, `user_group_list_cp`, `user_active_cp`, `admin_allow_points`, `karma`, `user_level2`, `user_allowemails`, `user_invisible`, `user_lastaction`, `user_location`, `user_comments`, `user_blog_colors`, `user_blog_password`, `rate`, `rates_count`) VALUES
(1, '', 'Anonymous', '', '', '', 'blank.gif', 'Nov 10, 2000', '', '', '', NULL, '', '', 0, 0, '', '', '', '2a2e0edbc27feb9a93c00956949630df', 10, '', 0, 0, 0, '', 0, '', '', '255', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 10, NULL, 'persian', 'D M d, Y g:i a', 0, 0, 0, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 0, 3, NULL, NULL, NULL, 1, '0', 0, 3, '3', 'YES', 1, 0, 2, 1, 0, 0, '0', 0, '#F9F1A9#EEE4C6#EDFAC8', '', 0, 0);

CREATE TABLE IF NOT EXISTS `nuke_users_temp` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `realname` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(40) COLLATE utf8_bin NOT NULL,
  `user_regdate` varchar(20) COLLATE utf8_bin NOT NULL,
  `check_num` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` varchar(14) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `nuke_users_temp` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `realname` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(40) COLLATE utf8_bin NOT NULL,
  `user_regdate` varchar(20) COLLATE utf8_bin NOT NULL,
  `check_num` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` varchar(14) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;