<?php
/**
*
* @package MT_CONVERT
* @copyright (c) Marlik Group  http://www.nukelearn.com $Aneeshtan
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
require_once("mainfile.php");
global $admin,$prefix;
if (is_superadmin($admin)) {
	list($nlVersion) = $db->sql_fetchrow($db->sql_query("SELECT USV_Version FROM  ".$prefix."_config LIMIT 1"));
	define("NL_VERSION",$nlVersion);
	define("_GOBACK2","<a href='install.php?convert=1'>بازگشت به صفحه تبدیل پرتال</a>")
	?>
	<center>
	<div class="sidebox" style="background:#BCE1F6" >
	<p>
	پرتال مشهد تیم 
	www.phpnuke.ir
	<br>
	با انتقال به پرتال نیوک لرن و اجرای این اسکریپت , این جداول حذف می شوند !
	<br>
	
	<div style="height:100px;overflow:auto;text-align:left;direction:ltr;margin-left:20px;">
	nuke_users_invites;
<br>nuke_user_fildes;
<br>nuke_subscriptions;
<br>nuke_stories_score;
<br>nuke_stories_comments_moderated;
<br>nuke_stories_comments_fildes;
<br>nuke_stories_comments;
<br>nuke_stats_year;
<br>nuke_stats_month;
<br>nuke_stats_hour;
<br>nuke_stats_date;
<br>nuke_staticpages_comments_fildes;
<br>nuke_staticpages_comments;
<br>nuke_staticpages;
<br>nuke_sms_settings;
<br>nuke_sms_sent;
<br>nuke_sms_scheduled;
<br>nuke_sms_readyforsend;
<br>nuke_sms_outbox;
<br>nuke_sms_inbox;
<br>nuke_sms_groups;
<br>nuke_sms_folders_text;
<br>nuke_sms_folders;
<br>nuke_sms_draft;
<br>nuke_sms_contacts;
<br>nuke_seo;
<br>nuke_reports;
<br>nuke_referer;
<br>nuke_queue;
<br>nuke_products_topics;
<br>nuke_products_score;
<br>nuke_products_related;
<br>nuke_products_comments_moderated;
<br>nuke_products_comments_fildes;
<br>nuke_products_comments;
<br>nuke_products;
<br>nuke_preloader_configs;
<br>nuke_pollcomments_fildes;
<br>nuke_pages_score;
<br>nuke_pages_comments_fildes;
<br>nuke_pages_comments;
<br>nuke_pages_categories;
<br>nuke_pages;
<br>nuke_nukesql;
<br>nuke_mttos;
<br>nuke_mtsn_ipban;
<br>nuke_mtsn_config;
<br>nuke_mtsn;
<br>nuke_mtgalpic;
<br>nuke_mtgalcat;
<br>nuke_mtconfig;
<br>nuke_mostonline;
<br>nuke_modules_popups;
<br>nuke_modules_exlinks;
<br>nuke_modules_config;
<br>nuke_modules_categories;
<br>nuke_meta;
<br>nuke_message;
<br>nuke_journal_stats;
<br>nuke_journal_comments;
<br>nuke_journal;
<br>nuke_headlines;
<br>nuke_groups_points;
<br>nuke_groups_info;
<br>nuke_galconfig;
<br>nuke_feedbacks;
<br>nuke_feedback_depts;
<br>nuke_feedback_config;
<br>nuke_faqcategories;
<br>nuke_faqanswer;
<br>nuke_encyclopedia_text;
<br>nuke_encyclopedia;
<br>nuke_downloads_votedata;
<br>nuke_downloads_newdownload;
<br>nuke_downloads_modrequest;
<br>nuke_downloads_editorials;
<br>nuke_downloads_downloads;
<br>nuke_downloads_categories;
<br>nuke_costumer_sold;
<br>nuke_costumer_code;
<br>nuke_costumer;
<br>nuke_comments_config;
<br>nuke_cache_data;
<br>nuke_cache_config;
<br>nuke_bookmarksite;
<br>nuke_blocks_titles;
<br>nuke_blocks_sides;
<br>nuke_bb3zebra;
<br>nuke_bb3words;
<br>nuke_bb3warnings;
<br>nuke_bb3user_group;
<br>nuke_bb3topics_watch;
<br>nuke_bb3topics_track;
<br>nuke_bb3topics_posted;
<br>nuke_bb3topics;
<br>nuke_bb3thanks;
<br>nuke_bb3styles_theme;
<br>nuke_bb3styles_template_data;
<br>nuke_bb3styles_template;
<br>nuke_bb3styles_imageset_data;
<br>nuke_bb3styles_imageset;
<br>nuke_bb3styles;
<br>nuke_bb3smilies;
<br>nuke_bb3sitelist;
<br>nuke_bb3sessions_keys;
<br>nuke_bb3sessions;
<br>nuke_bb3search_wordmatch;
<br>nuke_bb3search_wordlist;
<br>nuke_bb3search_results;
<br>nuke_bb3reports_reasons;
<br>nuke_bb3reports;
<br>nuke_bb3ranks;
<br>nuke_bb3profile_lang;
<br>nuke_bb3profile_fields_lang;
<br>nuke_bb3profile_fields_data;
<br>nuke_bb3profile_fields;
<br>nuke_bb3privmsgs_to;
<br>nuke_bb3privmsgs_rules;
<br>nuke_bb3privmsgs_folder;
<br>nuke_bb3privmsgs;
<br>nuke_bb3posts;
<br>nuke_bb3poll_votes;
<br>nuke_bb3poll_options;
<br>nuke_bb3modules;
<br>nuke_bb3moderator_cache;
<br>nuke_bb3login_attempts;
<br>nuke_bb3log;
<br>nuke_bb3lang;
<br>nuke_bb3icons;
<br>nuke_bb3groups;
<br>nuke_bb3forums_watch;
<br>nuke_bb3forums_track;
<br>nuke_bb3forums_access;
<br>nuke_bb3forums;
<br>nuke_bb3extensions;
<br>nuke_bb3extension_groups;
<br>nuke_bb3drafts;
<br>nuke_bb3disallow;
<br>nuke_bb3confirm;
<br>nuke_bb3config;
<br>nuke_bb3bots;
<br>nuke_bb3bookmarks;
<br>nuke_bb3bbcodes;
<br>nuke_bb3banlist;
<br>nuke_bb3attachments;
<br>nuke_bb3acl_users;
<br>nuke_bb3acl_roles_data;
<br>nuke_bb3acl_roles;
<br>nuke_bb3acl_options;
<br>nuke_bb3acl_groups;
<br>nuke_autonews;
<br>nuke_antiflood;
<br>nuke_admins_menu;
	</div>
	
	<input type="checkbox" name="deleteallrows" value="1" CHECKED> موافقم با حذف این جداول 
	</p>
	</center>
	<?php
	$pagetitle = "برنامه تبدیل مشهدتیم به نیوک لرن";
	echo "<table align='center' border='0'>\n";
	echo "<form action='install.php' method='GET'>\n";
	echo "<tr><td align='center'><font color='red'></font><br>
       	<br></td></tr>\n";
	echo "<tr><td></td></tr>\n";
	echo "<tr><td align='center'>
  	<input type='submit' value='شروع تبدیل پرتال'>
	<a href='install.php?act=mt_convert&convert=1' class='button' style='background:#f2f2f2'>اتمام تبدیل</a></td></tr>\n";
	echo "
	<input type='hidden' name='act' value='mt_convert'>
	<input type='hidden' name='convert' value='1'>
	<input type='hidden' name='confirm' value='1'>
	</form>";
	echo "</table>\n";
	
	list($nlVersion) = $db->sql_fetchrow($db->sql_query("SELECT USV_Version FROM  ".$prefix."_config LIMIT 1"));
	if(!empty($nlVersion)){
	echo "<br><div style='background:green;color:white;weight:600;padding:20px;'>
	اکنون پرتال شما نیوک لرن نسخه  $nlVersion است.
	
	<p>
	<a href='index.php' class='button'>صفحه نخست سایت</a>
	<a href='admin.php' class='button'>صفحه مدیریت سایت</a>
	</p>
	</div>
	";
	}
		
		
if($_GET['confirm']) {
		$sql_queue = array(
"
DROP TABLE nuke_users_invites;
",
"
DROP TABLE nuke_user_fildes;
",
"
DROP TABLE nuke_subscriptions;
",
"
DROP TABLE nuke_stories_score;
",
"
DROP TABLE nuke_stories_comments_moderated;
",
"
DROP TABLE nuke_stories_comments_fildes;
",
"
DROP TABLE nuke_stories_comments;
",
"
DROP TABLE nuke_stats_year;
",
"
DROP TABLE nuke_stats_month;
",
"
DROP TABLE nuke_stats_hour;
",
"
DROP TABLE nuke_stats_date;
",
"
DROP TABLE nuke_staticpages_comments_fildes;
",
"
DROP TABLE nuke_staticpages_comments;
",
"
DROP TABLE nuke_staticpages;
",
"
DROP TABLE nuke_sms_settings;
",
"
DROP TABLE nuke_sms_sent;
",
"
DROP TABLE nuke_sms_scheduled;
",
"
DROP TABLE nuke_sms_readyforsend;
",
"
DROP TABLE nuke_sms_outbox;
",
"
DROP TABLE nuke_sms_inbox;
",
"
DROP TABLE nuke_sms_groups;
",
"
DROP TABLE nuke_sms_folders_text;
",
"
DROP TABLE nuke_sms_folders;
",
"
DROP TABLE nuke_sms_draft;
",
"
DROP TABLE nuke_sms_contacts;
",
"
DROP TABLE nuke_seo;
",
"
DROP TABLE nuke_reports;
",
"
DROP TABLE nuke_referer;
",
"
DROP TABLE nuke_queue;
",
"
DROP TABLE nuke_products_topics;
",
"
DROP TABLE nuke_products_score;
",
"
DROP TABLE nuke_products_related;
",
"
DROP TABLE nuke_products_comments_moderated;
",
"
DROP TABLE nuke_products_comments_fildes;
",
"
DROP TABLE nuke_products_comments;
",
"
DROP TABLE nuke_products;
",
"
DROP TABLE nuke_preloader_configs;
",
"
DROP TABLE nuke_pollcomments_fildes;
",
"
DROP TABLE nuke_pages_score;
",
"
DROP TABLE nuke_pages_comments_fildes;
",
"
DROP TABLE nuke_pages_comments;
",
"
DROP TABLE nuke_pages_categories;
",
"
DROP TABLE nuke_pages;
",
"
DROP TABLE nuke_nukesql;
",
"
DROP TABLE nuke_mttos;
",
"
DROP TABLE nuke_mtsn_ipban;
",
"
DROP TABLE nuke_mtsn_config;
",
"
DROP TABLE nuke_mtsn;
",
"
DROP TABLE nuke_mtgalpic;
",
"
DROP TABLE nuke_mtgalcat;
",
"
DROP TABLE nuke_mtconfig;
",
"
DROP TABLE nuke_mostonline;
",
"
DROP TABLE nuke_modules_popups;
",
"
DROP TABLE nuke_modules_exlinks;
",
"
DROP TABLE nuke_modules_config;
",
"
DROP TABLE nuke_modules_categories;
",
"
DROP TABLE nuke_meta;
",
"
DROP TABLE nuke_message;
",
"
DROP TABLE nuke_journal_stats;
",
"
DROP TABLE nuke_journal_comments;
",
"
DROP TABLE nuke_journal;
",
"
DROP TABLE nuke_headlines;
",
"
DROP TABLE nuke_groups_points;
",
"
DROP TABLE nuke_groups_info;
",
"
DROP TABLE nuke_galconfig;
",
"
DROP TABLE nuke_feedbacks;
",
"
DROP TABLE nuke_feedback_depts;
",
"
DROP TABLE nuke_feedback_config;
",
"
DROP TABLE nuke_faqcategories;
",
"
DROP TABLE nuke_faqanswer;
",
"
DROP TABLE nuke_encyclopedia_text;
",
"
DROP TABLE nuke_encyclopedia;
",
"
DROP TABLE nuke_downloads_votedata;
",
"
DROP TABLE nuke_downloads_newdownload;
",
"
DROP TABLE nuke_downloads_modrequest;
",
"
DROP TABLE nuke_downloads_editorials;
",
"
DROP TABLE nuke_downloads_downloads;
",
"
DROP TABLE nuke_downloads_categories;
",
"
DROP TABLE nuke_costumer_sold;
",
"
DROP TABLE nuke_costumer_code;
",
"
DROP TABLE nuke_costumer;
",
"
DROP TABLE nuke_comments_config;
",
"
DROP TABLE nuke_cache_data;
",
"
DROP TABLE nuke_cache_config;
",
"
DROP TABLE nuke_bookmarksite;
",
"
DROP TABLE nuke_blocks_titles;
",
"
DROP TABLE nuke_blocks_sides;
",
"
DROP TABLE nuke_bb3zebra;
",
"
DROP TABLE nuke_bb3words;
",
"
DROP TABLE nuke_bb3warnings;
",
"
DROP TABLE nuke_bb3user_group;
",
"
DROP TABLE nuke_bb3topics_watch;
",
"
DROP TABLE nuke_bb3topics_track;
",
"
DROP TABLE nuke_bb3topics_posted;
",
"
DROP TABLE nuke_bb3topics;
",
"
DROP TABLE nuke_bb3thanks;
",
"
DROP TABLE nuke_bb3styles_theme;
",
"
DROP TABLE nuke_bb3styles_template_data;
",
"
DROP TABLE nuke_bb3styles_template;
",
"
DROP TABLE nuke_bb3styles_imageset_data;
",
"
DROP TABLE nuke_bb3styles_imageset;
",
"
DROP TABLE nuke_bb3styles;
",
"
DROP TABLE nuke_bb3smilies;
",
"
DROP TABLE nuke_bb3sitelist;
",
"
DROP TABLE nuke_bb3sessions_keys;
",
"
DROP TABLE nuke_bb3sessions;
",
"
DROP TABLE nuke_bb3search_wordmatch;
",
"
DROP TABLE nuke_bb3search_wordlist;
",
"
DROP TABLE nuke_bb3search_results;
",
"
DROP TABLE nuke_bb3reports_reasons;
",
"
DROP TABLE nuke_bb3reports;
",
"
DROP TABLE nuke_bb3ranks;
",
"
DROP TABLE nuke_bb3profile_lang;
",
"
DROP TABLE nuke_bb3profile_fields_lang;
",
"
DROP TABLE nuke_bb3profile_fields_data;
",
"
DROP TABLE nuke_bb3profile_fields;
",
"
DROP TABLE nuke_bb3privmsgs_to;
",
"
DROP TABLE nuke_bb3privmsgs_rules;
",
"
DROP TABLE nuke_bb3privmsgs_folder;
",
"
DROP TABLE nuke_bb3privmsgs;
",
"
DROP TABLE nuke_bb3posts;
",
"
DROP TABLE nuke_bb3poll_votes;
",
"
DROP TABLE nuke_bb3poll_options;
",
"
DROP TABLE nuke_bb3modules;
",
"
DROP TABLE nuke_bb3moderator_cache;
",
"
DROP TABLE nuke_bb3login_attempts;
",
"
DROP TABLE nuke_bb3log;
",
"
DROP TABLE nuke_bb3lang;
",
"
DROP TABLE nuke_bb3icons;
",
"
DROP TABLE nuke_bb3groups;
",
"
DROP TABLE nuke_bb3forums_watch;
",
"
DROP TABLE nuke_bb3forums_track;
",
"
DROP TABLE nuke_bb3forums_access;
",
"
DROP TABLE nuke_bb3forums;
",
"
DROP TABLE nuke_bb3extensions;
",
"
DROP TABLE nuke_bb3extension_groups;
",
"
DROP TABLE nuke_bb3drafts;
",
"
DROP TABLE nuke_bb3disallow;
",
"
DROP TABLE nuke_bb3confirm;
",
"
DROP TABLE nuke_bb3config;
",
"
DROP TABLE nuke_bb3bots;
",
"
DROP TABLE nuke_bb3bookmarks;
",
"
DROP TABLE nuke_bb3bbcodes;
",
"
DROP TABLE nuke_bb3banlist;
",
"
DROP TABLE nuke_bb3attachments;
",
"
DROP TABLE nuke_bb3acl_users;
",
"
DROP TABLE nuke_bb3acl_roles_data;
",
"
DROP TABLE nuke_bb3acl_roles;
",
"
DROP TABLE nuke_bb3acl_options;
",
"
DROP TABLE nuke_bb3acl_groups;
",
"
DROP TABLE nuke_autonews;
",
"
DROP TABLE nuke_antiflood;
",
"
DROP TABLE nuke_admins_menu;
",
"
CREATE TABLE mybb_adminlog (
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  ipaddress VARCHAR(50) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  module VARCHAR(50) NOT NULL DEFAULT '',
  `action` VARCHAR(50) NOT NULL DEFAULT '',
  `data` TEXT NOT NULL,
  INDEX module (module, `action`)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_adminoptions (
  uid INT(11) NOT NULL DEFAULT 0,
  cpstyle VARCHAR(50) NOT NULL DEFAULT '',
  codepress INT(1) NOT NULL DEFAULT 1,
  notes TEXT NOT NULL,
  permissions TEXT NOT NULL,
  defaultviews TEXT NOT NULL,
  loginattempts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  loginlockoutexpiry INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_adminsessions (
  sid VARCHAR(32) NOT NULL DEFAULT '',
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  loginkey VARCHAR(50) NOT NULL DEFAULT '',
  ip VARCHAR(40) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  lastactive BIGINT(30) NOT NULL DEFAULT 0,
  `data` TEXT NOT NULL
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_adminviews (
  vid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  title VARCHAR(100) NOT NULL DEFAULT '',
  type VARCHAR(6) NOT NULL DEFAULT '',
  visibility INT(1) NOT NULL DEFAULT 0,
  `fields` TEXT NOT NULL,
  conditions TEXT NOT NULL,
  custom_profile_fields TEXT NOT NULL,
  sortby VARCHAR(20) NOT NULL DEFAULT '',
  sortorder VARCHAR(4) NOT NULL DEFAULT '',
  perpage INT(4) NOT NULL DEFAULT 0,
  view_type VARCHAR(6) NOT NULL DEFAULT '',
  PRIMARY KEY (vid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_announcements (
  aid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  fid INT(10) NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  subject VARCHAR(120) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  startdate BIGINT(30) NOT NULL DEFAULT 0,
  enddate BIGINT(30) NOT NULL DEFAULT 0,
  allowhtml INT(1) NOT NULL DEFAULT 0,
  allowmycode INT(1) NOT NULL DEFAULT 0,
  allowsmilies INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (aid),
  INDEX fid (fid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_attachments (
  aid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid INT(10) NOT NULL DEFAULT 0,
  posthash VARCHAR(50) NOT NULL DEFAULT '',
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  filename VARCHAR(120) NOT NULL DEFAULT '',
  filetype VARCHAR(120) NOT NULL DEFAULT '',
  filesize INT(10) NOT NULL DEFAULT 0,
  attachname VARCHAR(120) NOT NULL DEFAULT '',
  downloads INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateuploaded BIGINT(30) NOT NULL DEFAULT 0,
  visible INT(1) NOT NULL DEFAULT 0,
  thumbnail VARCHAR(120) NOT NULL DEFAULT '',
  PRIMARY KEY (aid),
  INDEX pid (pid, visible),
  INDEX posthash (posthash),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_attachtypes (
  atid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL DEFAULT '',
  mimetype VARCHAR(120) NOT NULL DEFAULT '',
  extension VARCHAR(10) NOT NULL DEFAULT '',
  maxsize INT(15) NOT NULL DEFAULT 0,
  icon VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (atid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_awaitingactivation (
  aid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  code VARCHAR(100) NOT NULL DEFAULT '',
  type CHAR(1) NOT NULL DEFAULT '',
  oldgroup BIGINT(30) NOT NULL DEFAULT 0,
  misc VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (aid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_backup_attachments (
  aid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid INT(10) NOT NULL DEFAULT 0,
  posthash VARCHAR(50) NOT NULL DEFAULT '',
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  filename VARCHAR(120) NOT NULL DEFAULT '',
  filetype VARCHAR(120) NOT NULL DEFAULT '',
  filesize INT(10) NOT NULL DEFAULT 0,
  attachname VARCHAR(120) NOT NULL DEFAULT '',
  downloads INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateuploaded BIGINT(30) NOT NULL DEFAULT 0,
  visible INT(1) NOT NULL DEFAULT 0,
  thumbnail VARCHAR(120) NOT NULL DEFAULT '',
  PRIMARY KEY (aid),
  INDEX pid (pid, visible),
  INDEX posthash (posthash),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_backup_polls (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  question VARCHAR(200) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  options TEXT NOT NULL,
  votes TEXT NOT NULL,
  numoptions SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  numvotes SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  timeout BIGINT(30) NOT NULL DEFAULT 0,
  closed INT(1) NOT NULL DEFAULT 0,
  multiple INT(1) NOT NULL DEFAULT 0,
  public INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_backup_pollvotes (
  vid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  voteoption SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (vid),
  INDEX pid (pid, uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_backup_posts (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  replyto INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  subject VARCHAR(120) NOT NULL DEFAULT '',
  icon SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  username VARCHAR(80) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  message TEXT NOT NULL,
  ipaddress VARCHAR(30) NOT NULL DEFAULT '',
  longipaddress INT(11) NOT NULL DEFAULT 0,
  includesig INT(1) NOT NULL DEFAULT 0,
  smilieoff INT(1) NOT NULL DEFAULT 0,
  edituid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  edittime INT(10) NOT NULL DEFAULT 0,
  visible INT(1) NOT NULL DEFAULT 0,
  posthash VARCHAR(32) NOT NULL DEFAULT '',
  pthx INT(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid),
  INDEX dateline (dateline),
  INDEX longipaddress (longipaddress),
  FULLTEXT INDEX message (message),
  INDEX tid (tid, uid),
  INDEX uid (uid),
  INDEX visible (visible)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_backup_threads (
  tid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  subject VARCHAR(120) NOT NULL DEFAULT '',
  prefix SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  icon SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  poll INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  username VARCHAR(80) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  firstpost INT(10) UNSIGNED NOT NULL DEFAULT 0,
  lastpost BIGINT(30) NOT NULL DEFAULT 0,
  lastposter VARCHAR(120) NOT NULL DEFAULT '',
  lastposteruid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  views INT(100) NOT NULL DEFAULT 0,
  replies INT(100) NOT NULL DEFAULT 0,
  closed VARCHAR(30) NOT NULL DEFAULT '',
  sticky INT(1) NOT NULL DEFAULT 0,
  numratings SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  totalratings SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  notes TEXT NOT NULL,
  visible INT(1) NOT NULL DEFAULT 0,
  unapprovedposts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  attachmentcount INT(10) UNSIGNED NOT NULL DEFAULT 0,
  deletetime INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (tid),
  INDEX dateline (dateline),
  INDEX fid (fid, visible, sticky),
  INDEX firstpost (firstpost),
  INDEX lastpost (lastpost, fid),
  FULLTEXT INDEX subject (subject),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_backup_threadsubscriptions (
  sid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  notification INT(1) NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  subscriptionkey VARCHAR(32) NOT NULL DEFAULT '',
  PRIMARY KEY (sid),
  INDEX tid (tid, notification),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_badwords (
  bid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  badword VARCHAR(100) NOT NULL DEFAULT '',
  replacement VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (bid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_banfilters (
  fid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  filter VARCHAR(200) NOT NULL DEFAULT '',
  type INT(1) NOT NULL DEFAULT 0,
  lastuse BIGINT(30) NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (fid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_banned (
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  gid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  oldgroup INT(10) UNSIGNED NOT NULL DEFAULT 0,
  oldadditionalgroups TEXT NOT NULL,
  olddisplaygroup INT(11) NOT NULL DEFAULT 0,
  admin INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  bantime VARCHAR(50) NOT NULL DEFAULT '',
  lifted BIGINT(30) NOT NULL DEFAULT 0,
  reason VARCHAR(255) NOT NULL DEFAULT '',
  INDEX dateline (dateline),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_calendarpermissions (
  cid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  gid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  canviewcalendar INT(1) NOT NULL DEFAULT 0,
  canaddevents INT(1) NOT NULL DEFAULT 0,
  canbypasseventmod INT(1) NOT NULL DEFAULT 0,
  canmoderateevents INT(1) NOT NULL DEFAULT 0
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_calendars (
  cid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  disporder INT(10) UNSIGNED NOT NULL DEFAULT 0,
  startofweek INT(1) NOT NULL DEFAULT 0,
  showbirthdays INT(1) NOT NULL DEFAULT 0,
  eventlimit INT(3) NOT NULL DEFAULT 0,
  moderation INT(1) NOT NULL DEFAULT 0,
  allowhtml INT(1) NOT NULL DEFAULT 0,
  allowmycode INT(1) NOT NULL DEFAULT 0,
  allowimgcode INT(1) NOT NULL DEFAULT 0,
  allowvideocode INT(1) NOT NULL DEFAULT 0,
  allowsmilies INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (cid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_captcha (
  imagehash VARCHAR(32) NOT NULL DEFAULT '',
  imagestring VARCHAR(8) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  INDEX dateline (dateline),
  INDEX imagehash (imagehash)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_datacache (
  title VARCHAR(50) NOT NULL DEFAULT '',
  cache MEDIUMTEXT NOT NULL,
  PRIMARY KEY (title)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_delayedmoderation (
  did INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  type VARCHAR(30) NOT NULL DEFAULT '',
  delaydateline BIGINT(30) NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  tids TEXT NOT NULL,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  inputs TEXT NOT NULL,
  PRIMARY KEY (did)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_events (
  eid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  cid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  name VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  visible INT(1) NOT NULL DEFAULT 0,
  private INT(1) NOT NULL DEFAULT 0,
  dateline INT(10) UNSIGNED NOT NULL DEFAULT 0,
  starttime INT(10) UNSIGNED NOT NULL DEFAULT 0,
  endtime INT(10) UNSIGNED NOT NULL DEFAULT 0,
  timezone VARCHAR(4) NOT NULL DEFAULT '0',
  ignoretimezone INT(1) NOT NULL DEFAULT 0,
  usingtime INT(1) NOT NULL DEFAULT 0,
  repeats TEXT NOT NULL,
  PRIMARY KEY (eid),
  INDEX daterange (starttime, endtime),
  INDEX private (private)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_forumpermissions (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  fid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  gid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  canview INT(1) NOT NULL DEFAULT 0,
  canviewthreads INT(1) NOT NULL DEFAULT 0,
  canonlyviewownthreads INT(1) NOT NULL DEFAULT 0,
  candlattachments INT(1) NOT NULL DEFAULT 0,
  canpostthreads INT(1) NOT NULL DEFAULT 0,
  canpostreplys INT(1) NOT NULL DEFAULT 0,
  canpostattachments INT(1) NOT NULL DEFAULT 0,
  canratethreads INT(1) NOT NULL DEFAULT 0,
  caneditposts INT(1) NOT NULL DEFAULT 0,
  candeleteposts INT(1) NOT NULL DEFAULT 0,
  candeletethreads INT(1) NOT NULL DEFAULT 0,
  caneditattachments INT(1) NOT NULL DEFAULT 0,
  canpostpolls INT(1) NOT NULL DEFAULT 0,
  canvotepolls INT(1) NOT NULL DEFAULT 0,
  cansearch INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_forums (
  fid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  linkto VARCHAR(180) NOT NULL DEFAULT '',
  type CHAR(1) NOT NULL DEFAULT '',
  pid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  parentlist TEXT NOT NULL,
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  active INT(1) NOT NULL DEFAULT 0,
  open INT(1) NOT NULL DEFAULT 0,
  threads INT(10) UNSIGNED NOT NULL DEFAULT 0,
  posts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  lastpost INT(10) UNSIGNED NOT NULL DEFAULT 0,
  lastposter VARCHAR(120) NOT NULL DEFAULT '',
  lastposteruid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  lastposttid INT(10) NOT NULL DEFAULT 0,
  lastpostsubject VARCHAR(120) NOT NULL DEFAULT '',
  allowhtml INT(1) NOT NULL DEFAULT 0,
  allowmycode INT(1) NOT NULL DEFAULT 0,
  allowsmilies INT(1) NOT NULL DEFAULT 0,
  allowimgcode INT(1) NOT NULL DEFAULT 0,
  allowvideocode INT(1) NOT NULL DEFAULT 0,
  allowpicons INT(1) NOT NULL DEFAULT 0,
  allowtratings INT(1) NOT NULL DEFAULT 0,
  status INT(4) NOT NULL DEFAULT 1,
  usepostcounts INT(1) NOT NULL DEFAULT 0,
  `password` VARCHAR(50) NOT NULL DEFAULT '',
  showinjump INT(1) NOT NULL DEFAULT 0,
  modposts INT(1) NOT NULL DEFAULT 0,
  modthreads INT(1) NOT NULL DEFAULT 0,
  mod_edit_posts INT(1) NOT NULL DEFAULT 0,
  modattachments INT(1) NOT NULL DEFAULT 0,
  style SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  overridestyle INT(1) NOT NULL DEFAULT 0,
  rulestype SMALLINT(1) NOT NULL DEFAULT 0,
  rulestitle VARCHAR(200) NOT NULL DEFAULT '',
  rules TEXT NOT NULL,
  unapprovedthreads INT(10) UNSIGNED NOT NULL DEFAULT 0,
  unapprovedposts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  defaultdatecut SMALLINT(4) UNSIGNED NOT NULL DEFAULT 0,
  defaultsortby VARCHAR(10) NOT NULL DEFAULT '',
  defaultsortorder VARCHAR(4) NOT NULL DEFAULT '',
  PRIMARY KEY (fid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_forumsread (
  fid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline INT(10) NOT NULL DEFAULT 0,
  INDEX dateline (dateline),
  UNIQUE INDEX fid (fid, uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_forumsubscriptions (
  fsid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (fsid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_google_seo (
  active TINYINT(3) UNSIGNED DEFAULT NULL,
  idtype TINYINT(3) UNSIGNED NOT NULL,
  id INT(10) UNSIGNED NOT NULL,
  url VARCHAR(120) NOT NULL,
  UNIQUE INDEX active (active, idtype, id),
  UNIQUE INDEX idtype (idtype, url)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_groupleaders (
  lid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  gid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  canmanagemembers INT(1) NOT NULL DEFAULT 0,
  canmanagerequests INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (lid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_helpdocs (
  hid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  sid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  name VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  document TEXT NOT NULL,
  usetranslation INT(1) NOT NULL DEFAULT 0,
  enabled INT(1) NOT NULL DEFAULT 0,
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (hid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_helpsections (
  sid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  usetranslation INT(1) NOT NULL DEFAULT 0,
  enabled INT(1) NOT NULL DEFAULT 0,
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_icons (
  iid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL DEFAULT '',
  path VARCHAR(220) NOT NULL DEFAULT '',
  PRIMARY KEY (iid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_joinrequests (
  rid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  gid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  reason VARCHAR(250) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (rid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_lastvisitor (
  uid VARCHAR(10) NOT NULL,
  vid VARCHAR(10) NOT NULL,
  `time` VARCHAR(50) NOT NULL
)
ENGINE = MYISAM
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
",
"
CREATE TABLE mybb_mailerrors (
  eid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  subject VARCHAR(200) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  toaddress VARCHAR(150) NOT NULL DEFAULT '',
  fromaddress VARCHAR(150) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  error TEXT NOT NULL,
  smtperror VARCHAR(200) NOT NULL DEFAULT '',
  smtpcode INT(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (eid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_maillogs (
  mid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  subject VARCHAR(200) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  fromuid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fromemail VARCHAR(200) NOT NULL DEFAULT '',
  touid BIGINT(30) NOT NULL DEFAULT 0,
  toemail VARCHAR(200) NOT NULL DEFAULT '',
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  ipaddress VARCHAR(20) NOT NULL DEFAULT '',
  PRIMARY KEY (mid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_mailqueue (
  mid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  mailto VARCHAR(200) NOT NULL,
  mailfrom VARCHAR(200) NOT NULL,
  subject VARCHAR(200) NOT NULL,
  message TEXT NOT NULL,
  headers TEXT NOT NULL,
  PRIMARY KEY (mid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_massemails (
  mid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  subject VARCHAR(200) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  htmlmessage TEXT NOT NULL,
  type TINYINT(1) NOT NULL DEFAULT 0,
  format TINYINT(1) NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  senddate BIGINT(30) NOT NULL DEFAULT 0,
  status TINYINT(1) NOT NULL DEFAULT 0,
  sentcount INT(10) UNSIGNED NOT NULL DEFAULT 0,
  totalcount INT(10) UNSIGNED NOT NULL DEFAULT 0,
  conditions TEXT NOT NULL,
  perpage SMALLINT(4) NOT NULL DEFAULT 50,
  PRIMARY KEY (mid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_moderatorlog (
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  pid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `action` TEXT NOT NULL,
  `data` TEXT NOT NULL,
  ipaddress VARCHAR(50) NOT NULL DEFAULT '',
  INDEX tid (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_moderators (
  mid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  id INT(10) UNSIGNED NOT NULL DEFAULT 0,
  isgroup INT(1) UNSIGNED NOT NULL DEFAULT 0,
  caneditposts INT(1) NOT NULL DEFAULT 0,
  candeleteposts INT(1) NOT NULL DEFAULT 0,
  canviewips INT(1) NOT NULL DEFAULT 0,
  canopenclosethreads INT(1) NOT NULL DEFAULT 0,
  canmanagethreads INT(1) NOT NULL DEFAULT 0,
  canmovetononmodforum INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (mid),
  INDEX uid (id, fid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_modtools (
  tid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  forums TEXT NOT NULL,
  type CHAR(1) NOT NULL DEFAULT '',
  postoptions TEXT NOT NULL,
  threadoptions TEXT NOT NULL,
  PRIMARY KEY (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_mycode (
  cid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  regex TEXT NOT NULL,
  replacement TEXT NOT NULL,
  active INT(1) NOT NULL DEFAULT 0,
  parseorder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (cid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_polls (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  question VARCHAR(200) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  options TEXT NOT NULL,
  votes TEXT NOT NULL,
  numoptions SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  numvotes SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  timeout BIGINT(30) NOT NULL DEFAULT 0,
  closed INT(1) NOT NULL DEFAULT 0,
  multiple INT(1) NOT NULL DEFAULT 0,
  public INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_pollvotes (
  vid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  voteoption SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (vid),
  INDEX pid (pid, uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_posts (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  replyto INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  subject VARCHAR(120) NOT NULL DEFAULT '',
  icon SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  username VARCHAR(80) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  message TEXT NOT NULL,
  ipaddress VARCHAR(30) NOT NULL DEFAULT '',
  longipaddress INT(11) NOT NULL DEFAULT 0,
  includesig INT(1) NOT NULL DEFAULT 0,
  smilieoff INT(1) NOT NULL DEFAULT 0,
  edituid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  edittime INT(10) NOT NULL DEFAULT 0,
  visible INT(1) NOT NULL DEFAULT 0,
  posthash VARCHAR(32) NOT NULL DEFAULT '',
  pthx INT(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid),
  INDEX dateline (dateline),
  INDEX longipaddress (longipaddress),
  FULLTEXT INDEX message (message),
  INDEX tid (tid, uid),
  INDEX uid (uid),
  INDEX visible (visible)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_privatemessages (
  pmid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  toid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fromid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  recipients TEXT NOT NULL,
  folder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1,
  subject VARCHAR(120) NOT NULL DEFAULT '',
  icon SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  message TEXT NOT NULL,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  deletetime BIGINT(30) NOT NULL DEFAULT 0,
  status INT(1) NOT NULL DEFAULT 0,
  statustime BIGINT(30) NOT NULL DEFAULT 0,
  includesig INT(1) NOT NULL DEFAULT 0,
  smilieoff INT(1) NOT NULL DEFAULT 0,
  receipt INT(1) NOT NULL DEFAULT 0,
  readtime BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (pmid),
  INDEX toid (toid),
  INDEX uid (uid, folder)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_profilefields (
  fid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  type TEXT NOT NULL,
  length SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  maxlength SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  required INT(1) NOT NULL DEFAULT 0,
  editable INT(1) NOT NULL DEFAULT 0,
  hidden INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (fid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_promotionlogs (
  plid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  oldusergroup VARCHAR(200) NOT NULL DEFAULT '0',
  newusergroup SMALLINT(6) NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  type VARCHAR(9) NOT NULL DEFAULT 'primary',
  PRIMARY KEY (plid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_promotions (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  enabled TINYINT(1) NOT NULL DEFAULT 1,
  logging TINYINT(1) NOT NULL DEFAULT 0,
  posts INT(11) NOT NULL DEFAULT 0,
  posttype CHAR(2) NOT NULL DEFAULT '',
  registered INT(11) NOT NULL DEFAULT 0,
  registeredtype VARCHAR(20) NOT NULL DEFAULT '',
  reputations INT(11) NOT NULL DEFAULT 0,
  reputationtype CHAR(2) NOT NULL DEFAULT '',
  referrals INT(11) NOT NULL DEFAULT 0,
  referralstype CHAR(2) NOT NULL DEFAULT '',
  requirements VARCHAR(200) NOT NULL DEFAULT '',
  originalusergroup VARCHAR(120) NOT NULL DEFAULT '0',
  newusergroup SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  usergrouptype VARCHAR(120) NOT NULL DEFAULT '0',
  PRIMARY KEY (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_reportedposts (
  rid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  pid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  reportstatus INT(1) NOT NULL DEFAULT 0,
  reason VARCHAR(250) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (rid),
  INDEX dateline (dateline),
  INDEX fid (fid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_reputation (
  rid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  adduid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  pid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  reputation BIGINT(30) NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  comments TEXT NOT NULL,
  PRIMARY KEY (rid),
  INDEX dateline (dateline),
  INDEX pid (pid),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_searchlog (
  sid VARCHAR(32) NOT NULL DEFAULT '',
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  ipaddress VARCHAR(120) NOT NULL DEFAULT '',
  threads LONGTEXT NOT NULL,
  posts LONGTEXT NOT NULL,
  resulttype VARCHAR(10) NOT NULL DEFAULT '',
  querycache TEXT NOT NULL,
  keywords TEXT NOT NULL,
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_sessions (
  sid VARCHAR(32) NOT NULL DEFAULT '',
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  ip VARCHAR(40) NOT NULL DEFAULT '',
  `time` BIGINT(30) NOT NULL DEFAULT 0,
  location VARCHAR(150) NOT NULL DEFAULT '',
  useragent VARCHAR(100) NOT NULL DEFAULT '',
  anonymous INT(1) NOT NULL DEFAULT 0,
  nopermission INT(1) NOT NULL DEFAULT 0,
  location1 INT(10) NOT NULL DEFAULT 0,
  location2 INT(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (sid),
  INDEX ip (ip),
  INDEX location1 (location1),
  INDEX location2 (location2),
  INDEX `time` (`time`),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_settinggroups (
  gid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  title VARCHAR(220) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  isdefault INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (gid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_settings (
  sid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL DEFAULT '',
  title VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  optionscode TEXT NOT NULL,
  value TEXT NOT NULL,
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  gid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  isdefault INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_smilies (
  sid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL DEFAULT '',
  find VARCHAR(120) NOT NULL DEFAULT '',
  image VARCHAR(220) NOT NULL DEFAULT '',
  disporder SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  showclickable INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_spiders (
  sid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  theme INT(10) UNSIGNED NOT NULL DEFAULT 0,
  language VARCHAR(20) NOT NULL DEFAULT '',
  usergroup INT(10) UNSIGNED NOT NULL DEFAULT 0,
  useragent VARCHAR(200) NOT NULL DEFAULT '',
  lastvisit BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_stats (
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  numusers INT(10) UNSIGNED NOT NULL DEFAULT 0,
  numthreads INT(10) UNSIGNED NOT NULL DEFAULT 0,
  numposts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (dateline)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_tasklog (
  lid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  `data` TEXT NOT NULL,
  PRIMARY KEY (lid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_tasks (
  tid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  file VARCHAR(30) NOT NULL DEFAULT '',
  minute VARCHAR(200) NOT NULL DEFAULT '',
  hour VARCHAR(200) NOT NULL DEFAULT '',
  day VARCHAR(100) NOT NULL DEFAULT '',
  month VARCHAR(30) NOT NULL DEFAULT '',
  weekday VARCHAR(15) NOT NULL DEFAULT '',
  nextrun BIGINT(30) NOT NULL DEFAULT 0,
  lastrun BIGINT(30) NOT NULL DEFAULT 0,
  enabled INT(1) NOT NULL DEFAULT 1,
  logging INT(1) NOT NULL DEFAULT 0,
  locked BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_templategroups (
  gid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  prefix VARCHAR(50) NOT NULL DEFAULT '',
  title VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (gid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_templates (
  tid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL DEFAULT '',
  template TEXT NOT NULL,
  sid INT(10) NOT NULL DEFAULT 0,
  version VARCHAR(20) NOT NULL DEFAULT '0',
  status VARCHAR(10) NOT NULL DEFAULT '',
  dateline INT(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_templatesets (
  sid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL DEFAULT '',
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_themes (
  tid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL DEFAULT '',
  pid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  def SMALLINT(1) NOT NULL DEFAULT 0,
  properties TEXT NOT NULL,
  stylesheets TEXT NOT NULL,
  allowedgroups TEXT NOT NULL,
  PRIMARY KEY (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_themestylesheets (
  sid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(30) NOT NULL DEFAULT '',
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  attachedto TEXT NOT NULL,
  stylesheet TEXT NOT NULL,
  cachefile VARCHAR(100) NOT NULL DEFAULT '',
  lastmodified BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (sid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_threadprefixes (
  pid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  prefix VARCHAR(120) NOT NULL DEFAULT '',
  displaystyle VARCHAR(200) NOT NULL DEFAULT '',
  forums TEXT NOT NULL,
  groups TEXT NOT NULL,
  PRIMARY KEY (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_threadratings (
  rid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  rating SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  ipaddress VARCHAR(30) NOT NULL DEFAULT '',
  PRIMARY KEY (rid),
  INDEX tid (tid, uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_threads (
  tid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  fid SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  subject VARCHAR(120) NOT NULL DEFAULT '',
  prefix SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  icon SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  poll INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  username VARCHAR(80) NOT NULL DEFAULT '',
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  firstpost INT(10) UNSIGNED NOT NULL DEFAULT 0,
  lastpost BIGINT(30) NOT NULL DEFAULT 0,
  lastposter VARCHAR(120) NOT NULL DEFAULT '',
  lastposteruid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  views INT(100) NOT NULL DEFAULT 0,
  replies INT(100) NOT NULL DEFAULT 0,
  closed VARCHAR(30) NOT NULL DEFAULT '',
  sticky INT(1) NOT NULL DEFAULT 0,
  numratings SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  totalratings SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  notes TEXT NOT NULL,
  visible INT(1) NOT NULL DEFAULT 0,
  unapprovedposts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  attachmentcount INT(10) UNSIGNED NOT NULL DEFAULT 0,
  deletetime INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (tid),
  INDEX dateline (dateline),
  INDEX fid (fid, visible, sticky),
  INDEX firstpost (firstpost),
  INDEX lastpost (lastpost, fid),
  FULLTEXT INDEX subject (subject),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_threadsread (
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  dateline INT(10) NOT NULL DEFAULT 0,
  INDEX dateline (dateline),
  UNIQUE INDEX tid (tid, uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_threadsubscriptions (
  sid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  notification INT(1) NOT NULL DEFAULT 0,
  dateline BIGINT(30) NOT NULL DEFAULT 0,
  subscriptionkey VARCHAR(32) NOT NULL DEFAULT '',
  PRIMARY KEY (sid),
  INDEX tid (tid, notification),
  INDEX uid (uid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_threadviews (
  tid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  INDEX tid (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_thx (
  txid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  uid INT(10) UNSIGNED NOT NULL,
  adduid INT(10) UNSIGNED NOT NULL,
  pid INT(10) UNSIGNED NOT NULL,
  `time` BIGINT(30) NOT NULL DEFAULT 0,
  PRIMARY KEY (txid),
  INDEX adduid (adduid, pid, `time`)
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
",
"
CREATE TABLE mybb_upgrade_data (
  title VARCHAR(30) NOT NULL,
  contents TEXT NOT NULL,
  UNIQUE INDEX title (title)
)
ENGINE = MYISAM
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
",
"
CREATE TABLE mybb_userfields (
  ufid INT(10) UNSIGNED NOT NULL DEFAULT 0,
  fid1 TEXT NOT NULL,
  fid2 TEXT NOT NULL,
  fid3 TEXT NOT NULL,
  PRIMARY KEY (ufid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_usergroups (
  gid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  type SMALLINT(2) NOT NULL DEFAULT 2,
  title VARCHAR(120) NOT NULL DEFAULT '',
  description TEXT NOT NULL,
  namestyle VARCHAR(200) NOT NULL DEFAULT '{username}',
  usertitle VARCHAR(120) NOT NULL DEFAULT '',
  stars SMALLINT(4) NOT NULL DEFAULT 0,
  starimage VARCHAR(120) NOT NULL DEFAULT '',
  image VARCHAR(120) NOT NULL DEFAULT '',
  disporder SMALLINT(6) UNSIGNED NOT NULL,
  isbannedgroup INT(1) NOT NULL DEFAULT 0,
  canview INT(1) NOT NULL DEFAULT 0,
  canviewthreads INT(1) NOT NULL DEFAULT 0,
  canviewprofiles INT(1) NOT NULL DEFAULT 0,
  candlattachments INT(1) NOT NULL DEFAULT 0,
  canpostthreads INT(1) NOT NULL DEFAULT 0,
  canpostreplys INT(1) NOT NULL DEFAULT 0,
  canpostattachments INT(1) NOT NULL DEFAULT 0,
  canratethreads INT(1) NOT NULL DEFAULT 0,
  caneditposts INT(1) NOT NULL DEFAULT 0,
  candeleteposts INT(1) NOT NULL DEFAULT 0,
  candeletethreads INT(1) NOT NULL DEFAULT 0,
  caneditattachments INT(1) NOT NULL DEFAULT 0,
  canpostpolls INT(1) NOT NULL DEFAULT 0,
  canvotepolls INT(1) NOT NULL DEFAULT 0,
  canundovotes INT(1) NOT NULL DEFAULT 0,
  canusepms INT(1) NOT NULL DEFAULT 0,
  cansendpms INT(1) NOT NULL DEFAULT 0,
  cantrackpms INT(1) NOT NULL DEFAULT 0,
  candenypmreceipts INT(1) NOT NULL DEFAULT 0,
  pmquota INT(3) NOT NULL DEFAULT 0,
  maxpmrecipients INT(4) NOT NULL DEFAULT 5,
  cansendemail INT(1) NOT NULL DEFAULT 0,
  maxemails INT(3) NOT NULL DEFAULT 5,
  canviewmemberlist INT(1) NOT NULL DEFAULT 0,
  canviewcalendar INT(1) NOT NULL DEFAULT 0,
  canaddevents INT(1) NOT NULL DEFAULT 0,
  canbypasseventmod INT(1) NOT NULL DEFAULT 0,
  canmoderateevents INT(1) NOT NULL DEFAULT 0,
  canviewonline INT(1) NOT NULL DEFAULT 0,
  canviewwolinvis INT(1) NOT NULL DEFAULT 0,
  canviewonlineips INT(1) NOT NULL DEFAULT 0,
  cancp INT(1) NOT NULL DEFAULT 0,
  issupermod INT(1) NOT NULL DEFAULT 0,
  cansearch INT(1) NOT NULL DEFAULT 0,
  canusercp INT(1) NOT NULL DEFAULT 0,
  canuploadavatars INT(1) NOT NULL DEFAULT 0,
  canratemembers INT(1) NOT NULL DEFAULT 0,
  canchangename INT(1) NOT NULL DEFAULT 0,
  showforumteam INT(1) NOT NULL DEFAULT 0,
  usereputationsystem INT(1) NOT NULL DEFAULT 0,
  cangivereputations INT(1) NOT NULL DEFAULT 0,
  reputationpower BIGINT(30) NOT NULL DEFAULT 0,
  maxreputationsday BIGINT(30) NOT NULL DEFAULT 0,
  maxreputationsperuser BIGINT(30) NOT NULL DEFAULT 0,
  maxreputationsperthread BIGINT(30) NOT NULL DEFAULT 0,
  candisplaygroup INT(1) NOT NULL DEFAULT 0,
  attachquota BIGINT(30) NOT NULL DEFAULT 0,
  cancustomtitle INT(1) NOT NULL DEFAULT 0,
  canwarnusers INT(1) NOT NULL DEFAULT 0,
  canreceivewarnings INT(1) NOT NULL DEFAULT 0,
  maxwarningsday INT(3) NOT NULL DEFAULT 3,
  canmodcp INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (gid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_users (
  uid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(120) NOT NULL DEFAULT '',
  `password` VARCHAR(120) NOT NULL DEFAULT '',
  salt VARCHAR(10) NOT NULL DEFAULT '',
  loginkey VARCHAR(50) NOT NULL DEFAULT '',
  email VARCHAR(220) NOT NULL DEFAULT '',
  postnum INT(10) NOT NULL DEFAULT 0,
  avatar VARCHAR(200) NOT NULL DEFAULT '',
  avatardimensions VARCHAR(10) NOT NULL DEFAULT '',
  avatartype VARCHAR(10) NOT NULL DEFAULT '0',
  usergroup SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  additionalgroups VARCHAR(200) NOT NULL DEFAULT '',
  displaygroup SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  usertitle VARCHAR(250) NOT NULL DEFAULT '',
  regdate BIGINT(30) NOT NULL DEFAULT 0,
  lastactive BIGINT(30) NOT NULL DEFAULT 0,
  lastvisit BIGINT(30) NOT NULL DEFAULT 0,
  lastpost BIGINT(30) NOT NULL DEFAULT 0,
  website VARCHAR(200) NOT NULL DEFAULT '',
  icq VARCHAR(10) NOT NULL DEFAULT '',
  aim VARCHAR(50) NOT NULL DEFAULT '',
  yahoo VARCHAR(50) NOT NULL DEFAULT '',
  msn VARCHAR(75) NOT NULL DEFAULT '',
  birthday VARCHAR(15) NOT NULL DEFAULT '',
  birthdayprivacy VARCHAR(4) NOT NULL DEFAULT 'all',
  signature TEXT NOT NULL,
  allownotices INT(1) NOT NULL DEFAULT 0,
  hideemail INT(1) NOT NULL DEFAULT 0,
  subscriptionmethod INT(1) NOT NULL DEFAULT 0,
  invisible INT(1) NOT NULL DEFAULT 0,
  receivepms INT(1) NOT NULL DEFAULT 0,
  receivefrombuddy INT(1) NOT NULL DEFAULT 0,
  pmnotice INT(1) NOT NULL DEFAULT 0,
  pmnotify INT(1) NOT NULL DEFAULT 0,
  threadmode VARCHAR(8) NOT NULL DEFAULT '',
  showsigs INT(1) NOT NULL DEFAULT 0,
  showavatars INT(1) NOT NULL DEFAULT 0,
  showquickreply INT(1) NOT NULL DEFAULT 0,
  showredirect INT(1) NOT NULL DEFAULT 0,
  ppp SMALLINT(6) NOT NULL DEFAULT 0,
  tpp SMALLINT(6) NOT NULL DEFAULT 0,
  daysprune SMALLINT(6) NOT NULL DEFAULT 0,
  dateformat VARCHAR(4) NOT NULL DEFAULT '',
  timeformat VARCHAR(4) NOT NULL DEFAULT '',
  timezone VARCHAR(4) NOT NULL DEFAULT '',
  dst INT(1) NOT NULL DEFAULT 0,
  dstcorrection INT(1) NOT NULL DEFAULT 0,
  buddylist TEXT NOT NULL,
  ignorelist TEXT NOT NULL,
  style SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0,
  away INT(1) NOT NULL DEFAULT 0,
  awaydate INT(10) UNSIGNED NOT NULL DEFAULT 0,
  returndate VARCHAR(15) NOT NULL DEFAULT '',
  awayreason VARCHAR(200) NOT NULL DEFAULT '',
  pmfolders TEXT NOT NULL,
  notepad TEXT NOT NULL,
  referrer INT(10) UNSIGNED NOT NULL DEFAULT 0,
  referrals INT(10) UNSIGNED NOT NULL DEFAULT 0,
  reputation BIGINT(30) NOT NULL DEFAULT 0,
  regip VARCHAR(50) NOT NULL DEFAULT '',
  lastip VARCHAR(50) NOT NULL DEFAULT '',
  longregip INT(11) NOT NULL DEFAULT 0,
  longlastip INT(11) NOT NULL DEFAULT 0,
  language VARCHAR(50) NOT NULL DEFAULT '',
  timeonline BIGINT(30) NOT NULL DEFAULT 0,
  showcodebuttons INT(1) NOT NULL DEFAULT 1,
  totalpms INT(10) NOT NULL DEFAULT 0,
  unreadpms INT(10) NOT NULL DEFAULT 0,
  warningpoints INT(3) NOT NULL DEFAULT 0,
  moderateposts INT(1) NOT NULL DEFAULT 0,
  moderationtime BIGINT(30) NOT NULL DEFAULT 0,
  suspendposting INT(1) NOT NULL DEFAULT 0,
  suspensiontime BIGINT(30) NOT NULL DEFAULT 0,
  suspendsignature INT(1) NOT NULL DEFAULT 0,
  suspendsigtime BIGINT(30) NOT NULL DEFAULT 0,
  coppauser INT(1) NOT NULL DEFAULT 0,
  classicpostbit INT(1) NOT NULL DEFAULT 0,
  loginattempts TINYINT(2) NOT NULL DEFAULT 1,
  failedlogin BIGINT(30) NOT NULL DEFAULT 0,
  usernotes TEXT NOT NULL,
  mood INT(11) NOT NULL DEFAULT 0,
  thx INT(11) NOT NULL,
  thxcount INT(11) NOT NULL,
  thxpost INT(11) NOT NULL,
  lastmark INT(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (uid),
  INDEX birthday (birthday),
  INDEX longlastip (longlastip),
  INDEX longregip (longregip),
  INDEX postnum (postnum),
  INDEX usergroup (usergroup),
  UNIQUE INDEX username (username)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_usertitles (
  utid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  posts INT(10) UNSIGNED NOT NULL DEFAULT 0,
  title VARCHAR(250) NOT NULL DEFAULT '',
  stars SMALLINT(4) NOT NULL DEFAULT 0,
  starimage VARCHAR(120) NOT NULL DEFAULT '',
  PRIMARY KEY (utid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE mybb_warninglevels (
  lid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  percentage INT(3) NOT NULL DEFAULT 0,
  `action` TEXT NOT NULL,
  PRIMARY KEY (lid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
ALTER TABLE nuke_authors
  DROP COLUMN aadminsuper,
  CHANGE COLUMN aid aid VARCHAR(25) NOT NULL,
  CHANGE COLUMN name name VARCHAR(50) DEFAULT NULL,
  CHANGE COLUMN url url VARCHAR(255) NOT NULL,
  CHANGE COLUMN email email VARCHAR(255) NOT NULL,
  CHANGE COLUMN pwd pwd VARCHAR(40) DEFAULT NULL,
  CHANGE COLUMN counter counter INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN radminsuper radminsuper TINYINT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN admlanguage admlanguage VARCHAR(30) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_banned_ip
  CHANGE COLUMN id id INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN ip_address ip_address VARCHAR(15) NOT NULL,
  CHANGE COLUMN reason reason VARCHAR(255) NOT NULL,
  CHANGE COLUMN `date` `date` DATE NOT NULL DEFAULT '0000-00-00',
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_banner
  CHANGE COLUMN bid bid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN cid cid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN name name VARCHAR(50) NOT NULL,
  CHANGE COLUMN imptotal imptotal INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN impmade impmade INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN clicks clicks INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN imageurl imageurl VARCHAR(100) NOT NULL,
  CHANGE COLUMN clickurl clickurl VARCHAR(200) NOT NULL,
  CHANGE COLUMN alttext alttext VARCHAR(255) NOT NULL,
  CHANGE COLUMN `date` `date` DATETIME DEFAULT NULL,
  CHANGE COLUMN dateend dateend DATETIME DEFAULT NULL,
  CHANGE COLUMN position position INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN active active TINYINT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN ad_class ad_class VARCHAR(5) NOT NULL,
  CHANGE COLUMN ad_code ad_code TEXT NOT NULL,
  CHANGE COLUMN ad_width ad_width INT(4) DEFAULT 0,
  CHANGE COLUMN ad_height ad_height INT(4) DEFAULT 0,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_banner_clients
  CHANGE COLUMN cid cid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN name name VARCHAR(60) NOT NULL,
  CHANGE COLUMN contact contact VARCHAR(60) NOT NULL,
  CHANGE COLUMN email email VARCHAR(60) NOT NULL,
  CHANGE COLUMN login login VARCHAR(10) NOT NULL,
  CHANGE COLUMN passwd passwd VARCHAR(10) NOT NULL,
  CHANGE COLUMN extrainfo extrainfo TEXT NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_banner_plans
  CHANGE COLUMN pid pid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN active active TINYINT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN name name VARCHAR(255) NOT NULL,
  CHANGE COLUMN description description TEXT NOT NULL,
  CHANGE COLUMN delivery delivery VARCHAR(10) NOT NULL,
  CHANGE COLUMN delivery_type delivery_type VARCHAR(25) NOT NULL,
  CHANGE COLUMN price price VARCHAR(25) NOT NULL DEFAULT '0',
  CHANGE COLUMN buy_links buy_links TEXT NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_banner_positions
  CHANGE COLUMN apid apid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN position_number position_number INT(5) NOT NULL DEFAULT 0,
  CHANGE COLUMN position_name position_name VARCHAR(255) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_banner_terms
  CHANGE COLUMN terms_body terms_body TEXT NOT NULL,
  CHANGE COLUMN country country VARCHAR(255) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_blocks
  DROP COLUMN themeview,
  DROP COLUMN blocks_sides,
  CHANGE COLUMN bid bid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN bkey bkey VARCHAR(15) NOT NULL,
  CHANGE COLUMN title title VARCHAR(60) NOT NULL,
  CHANGE COLUMN content content TEXT NOT NULL,
  CHANGE COLUMN url url VARCHAR(200) NOT NULL,
  CHANGE COLUMN bposition bposition CHAR(1) NOT NULL,
  CHANGE COLUMN weight weight INT(10) NOT NULL DEFAULT 1,
  CHANGE COLUMN active active INT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN refresh refresh INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN `time` `time` VARCHAR(14) NOT NULL DEFAULT '0',
  CHANGE COLUMN blanguage blanguage VARCHAR(30) NOT NULL,
  CHANGE COLUMN blockfile blockfile VARCHAR(255) NOT NULL,
  CHANGE COLUMN view view INT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN expire expire VARCHAR(14) NOT NULL DEFAULT '0' AFTER view,
  CHANGE COLUMN `action` `action` CHAR(1) NOT NULL AFTER expire,
  CHANGE COLUMN subscription subscription INT(1) NOT NULL DEFAULT 0 AFTER `action`,
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_blogs (
  bid INT(10) NOT NULL AUTO_INCREMENT,
  tid INT(10) NOT NULL DEFAULT 0,
  content VARCHAR(255) NOT NULL,
  `date` VARCHAR(14) DEFAULT NULL,
  sender INT(10) NOT NULL,
  sender_name VARCHAR(25) DEFAULT NULL,
  reciever INT(10) NOT NULL,
  reciever_name VARCHAR(25) DEFAULT NULL,
  `like` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  unlike INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (bid),
  INDEX bid (bid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_cnbya_config
  CHANGE COLUMN config_name config_name VARCHAR(255) NOT NULL,
  CHANGE COLUMN config_value config_value LONGTEXT DEFAULT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_cnbya_field
  CHANGE COLUMN fid fid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN name name VARCHAR(255) NOT NULL DEFAULT 'field',
  CHANGE COLUMN value value VARCHAR(255) DEFAULT NULL,
  CHANGE COLUMN size size INT(3) DEFAULT NULL,
  CHANGE COLUMN need need INT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN pos pos INT(3) DEFAULT NULL,
  CHANGE COLUMN public public INT(1) NOT NULL DEFAULT 1,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_cnbya_tos
  CHANGE COLUMN id id INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN `data` `data` TEXT NOT NULL,
  CHANGE COLUMN status status TINYINT(4) NOT NULL DEFAULT 0,
  CHANGE COLUMN des des TEXT NOT NULL,
  CHANGE COLUMN language language VARCHAR(25) NOT NULL,
  CHANGE COLUMN `time` `time` TEXT NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_cnbya_value
  CHANGE COLUMN vid vid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN uid uid INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN fid fid INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN value value VARCHAR(255) DEFAULT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_cnbya_value_temp
  CHANGE COLUMN vid vid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN uid uid INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN fid fid INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN value value VARCHAR(255) DEFAULT NULL,
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_comments_moderated (
  tid INT(11) NOT NULL AUTO_INCREMENT,
  pid INT(11) NOT NULL DEFAULT 0,
  sid INT(11) NOT NULL DEFAULT 0,
  active INT(1) NOT NULL DEFAULT 0,
  `date` DATETIME DEFAULT NULL,
  name VARCHAR(60) NOT NULL,
  email VARCHAR(60) DEFAULT NULL,
  url VARCHAR(60) DEFAULT NULL,
  host_name VARCHAR(60) DEFAULT NULL,
  subject VARCHAR(85) NOT NULL,
  `comment` TEXT NOT NULL,
  score TINYINT(4) NOT NULL DEFAULT 0,
  reason TINYINT(4) NOT NULL DEFAULT 0,
  last_moderation_ip VARCHAR(15) DEFAULT '0',
  PRIMARY KEY (tid),
  INDEX pid (pid),
  INDEX sid (sid),
  INDEX tid (tid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_config
  DROP COLUMN overwrite_theme,
  DROP COLUMN httprefmode,
  DROP COLUMN Version_Num,
  DROP COLUMN display_errors,
  DROP COLUMN gtset,
  DROP COLUMN userurl,
  DROP COLUMN productscomm,
  DROP COLUMN staticcomm,
  DROP COLUMN contentcom,
  DROP COLUMN align,
  DROP COLUMN show_links,
  DROP COLUMN datetype,
  DROP COLUMN contenthome,
  DROP COLUMN producthome,
  DROP COLUMN show_effect,
  DROP COLUMN votetype,
  DROP COLUMN preloader,
  DROP COLUMN comment_editor,
  DROP COLUMN confirm_need,
  DROP COLUMN filemaneger_pass,
  DROP COLUMN sitecookies,
  DROP COLUMN last_patch_install,
  CHANGE COLUMN sitename sitename VARCHAR(255) NOT NULL,
  CHANGE COLUMN nukeurl nukeurl VARCHAR(255) NOT NULL,
  CHANGE COLUMN site_logo site_logo VARCHAR(255) NOT NULL,
  CHANGE COLUMN slogan slogan VARCHAR(255) NOT NULL,
  CHANGE COLUMN startdate startdate VARCHAR(50) NOT NULL,
  CHANGE COLUMN adminmail adminmail VARCHAR(255) NOT NULL,
  CHANGE COLUMN anonpost anonpost TINYINT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN Default_Theme Default_Theme VARCHAR(255) NOT NULL,
  CHANGE COLUMN foot1 foot1 TEXT NOT NULL AFTER Default_Theme,
  CHANGE COLUMN foot2 foot2 TEXT NOT NULL AFTER foot1,
  CHANGE COLUMN foot3 foot3 TEXT NOT NULL AFTER foot2,
  CHANGE COLUMN commentlimit commentlimit INT(9) NOT NULL DEFAULT 10 AFTER foot3,
  CHANGE COLUMN anonymous anonymous VARCHAR(255) NOT NULL AFTER commentlimit,
  CHANGE COLUMN minpass minpass TINYINT(1) NOT NULL DEFAULT 5 AFTER anonymous,
  CHANGE COLUMN pollcomm pollcomm TINYINT(1) NOT NULL DEFAULT 1 AFTER minpass,
  CHANGE COLUMN articlecomm articlecomm TINYINT(1) NOT NULL DEFAULT 1 AFTER pollcomm,
  CHANGE COLUMN broadcast_msg broadcast_msg TINYINT(1) NOT NULL DEFAULT 1 AFTER articlecomm,
  CHANGE COLUMN my_headlines my_headlines TINYINT(1) NOT NULL DEFAULT 1 AFTER broadcast_msg,
  CHANGE COLUMN top top INT(3) NOT NULL DEFAULT 10 AFTER my_headlines,
  CHANGE COLUMN storyhome storyhome INT(2) NOT NULL DEFAULT 10 AFTER top,
  CHANGE COLUMN user_news user_news TINYINT(1) NOT NULL DEFAULT 1 AFTER storyhome,
  CHANGE COLUMN oldnum oldnum INT(2) NOT NULL DEFAULT 30 AFTER user_news,
  CHANGE COLUMN ultramode ultramode TINYINT(1) NOT NULL DEFAULT 0 AFTER oldnum,
  ADD COLUMN loading TINYINT(1) NOT NULL DEFAULT 0 AFTER ultramode,
  ADD COLUMN nextg TINYINT(1) NOT NULL DEFAULT 0 AFTER loading,
  CHANGE COLUMN banners banners TINYINT(1) NOT NULL DEFAULT 1 AFTER nextg,
  CHANGE COLUMN backend_title backend_title VARCHAR(255) NOT NULL AFTER banners,
  CHANGE COLUMN backend_language backend_language VARCHAR(10) NOT NULL AFTER backend_title,
  CHANGE COLUMN language language VARCHAR(100) NOT NULL AFTER backend_language,
  CHANGE COLUMN locale locale VARCHAR(10) NOT NULL AFTER language,
  CHANGE COLUMN multilingual multilingual TINYINT(1) NOT NULL DEFAULT 0 AFTER locale,
  CHANGE COLUMN useflags useflags TINYINT(1) NOT NULL DEFAULT 0 AFTER multilingual,
  CHANGE COLUMN notify notify TINYINT(1) NOT NULL DEFAULT 0 AFTER useflags,
  ADD COLUMN notify_email VARCHAR(255) NOT NULL AFTER notify,
  CHANGE COLUMN notify_subject notify_subject VARCHAR(255) NOT NULL AFTER notify_email,
  CHANGE COLUMN notify_message notify_message VARCHAR(255) NOT NULL AFTER notify_subject,
  CHANGE COLUMN notify_from notify_from VARCHAR(255) NOT NULL AFTER notify_message,
  CHANGE COLUMN moderate moderate TINYINT(1) NOT NULL DEFAULT 0 AFTER notify_from,
  CHANGE COLUMN admingraphic admingraphic TINYINT(1) NOT NULL DEFAULT 1 AFTER moderate,
  CHANGE COLUMN httpref httpref TINYINT(1) NOT NULL DEFAULT 1 AFTER admingraphic,
  CHANGE COLUMN httprefmax httprefmax INT(5) NOT NULL DEFAULT 1000 AFTER httpref,
  CHANGE COLUMN CensorMode CensorMode TINYINT(1) NOT NULL DEFAULT 3 AFTER httprefmax,
  CHANGE COLUMN CensorReplace CensorReplace VARCHAR(10) NOT NULL AFTER CensorMode,
  CHANGE COLUMN copyright copyright TEXT NOT NULL AFTER CensorReplace,
  ADD COLUMN USV_Version VARCHAR(15) NOT NULL AFTER copyright,
  ADD COLUMN support VARCHAR(30) NOT NULL AFTER USV_Version,
  CHANGE COLUMN gfx_chk gfx_chk TINYINT(1) NOT NULL DEFAULT 1 AFTER support,
  ADD COLUMN use_question INT(1) NOT NULL DEFAULT 0 AFTER gfx_chk,
  ADD COLUMN codesize INT(1) NOT NULL DEFAULT 4 AFTER use_question,
  ADD COLUMN cache_system INT(1) NOT NULL DEFAULT 0 AFTER codesize,
  ADD COLUMN cache_lifetime INT(1) NOT NULL DEFAULT 120 AFTER cache_system,
  CHANGE COLUMN nuke_editor nuke_editor INT(1) NOT NULL DEFAULT 1 AFTER cache_lifetime,
  ADD COLUMN tracking INT(1) NOT NULL DEFAULT 0 AFTER nuke_editor,
  ADD COLUMN sec_pass VARCHAR(40) DEFAULT NULL AFTER tracking,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_confirm
  CHANGE COLUMN confirm_id confirm_id CHAR(32) NOT NULL,
  CHANGE COLUMN session_id session_id CHAR(32) NOT NULL,
  CHANGE COLUMN code code CHAR(6) NOT NULL,
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_contact_us (
  pid INT(3) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) DEFAULT NULL,
  phone_num VARCHAR(60) DEFAULT NULL,
  fax_num VARCHAR(255) DEFAULT NULL,
  yahoo_id VARCHAR(255) NOT NULL,
  gmail_id VARCHAR(255) NOT NULL,
  dept_name VARCHAR(255) NOT NULL,
  dept_email VARCHAR(255) NOT NULL,
  address TEXT NOT NULL,
  showaddress INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid),
  INDEX pid (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_counter
  CHANGE COLUMN type type VARCHAR(80) NOT NULL,
  CHANGE COLUMN var var VARCHAR(80) NOT NULL,
  CHANGE COLUMN count count INT(10) UNSIGNED NOT NULL DEFAULT 0,
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_extpages (
  pid INT(10) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  slug TEXT NOT NULL,
  `text` TEXT NOT NULL,
  counter INT(10) NOT NULL DEFAULT 0,
  perm INT(1) NOT NULL DEFAULT 0,
  nav INT(1) NOT NULL DEFAULT 0,
  post_time DATETIME NOT NULL,
  active INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (pid),
  INDEX pid (pid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_groups
  DROP COLUMN points,
  CHANGE COLUMN name name VARBINARY(255) DEFAULT NULL,
  CHANGE COLUMN description description BLOB DEFAULT NULL,
  ADD COLUMN post_min INT(8) NOT NULL AFTER description,
  ADD COLUMN post_max INT(11) NOT NULL AFTER post_min,
  ADD COLUMN point_min INT(11) NOT NULL AFTER post_max,
  ADD COLUMN point_max INT(11) NOT NULL AFTER point_min,
  ADD COLUMN members BLOB DEFAULT NULL AFTER point_max,
  ADD COLUMN point_amount VARBINARY(255) DEFAULT NULL AFTER members,
  ADD COLUMN color VARCHAR(9) DEFAULT '#000000' AFTER point_amount,
  COLLATE utf8_persian_ci;
",
"
CREATE TABLE nuke_iptracking (
  ipid INT(10) NOT NULL AUTO_INCREMENT,
  username VARCHAR(25) DEFAULT NULL,
  date_time DATETIME NOT NULL,
  ip_address VARCHAR(15) NOT NULL,
  hostname VARCHAR(100) NOT NULL,
  referer VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  page VARCHAR(150) NOT NULL,
  page_title VARCHAR(150) NOT NULL,
  PRIMARY KEY (ipid),
  INDEX i1iptracking (ip_address, hostname),
  INDEX ipid (ipid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE nuke_jcalendar_events (
  eid SMALLINT(4) NOT NULL AUTO_INCREMENT,
  title VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  start_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  end_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  repeat_type ENUM('off','daily','weekly','monthly','yearly') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'off',
  approved TINYINT(1) NOT NULL DEFAULT 0,
  holiday ENUM('yes','no') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'no',
  linkstr VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (eid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE nuke_keywords (
  mid INT(10) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL DEFAULT '',
  keywords TEXT NOT NULL,
  description TEXT NOT NULL,
  PRIMARY KEY (mid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
CREATE TABLE nuke_keywords_main (
  keywords TEXT NOT NULL,
  description TEXT NOT NULL
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
ALTER TABLE nuke_links_categories
  CHANGE COLUMN cid cid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN title title VARCHAR(50) NOT NULL,
  CHANGE COLUMN cdescription cdescription TEXT NOT NULL,
  CHANGE COLUMN parentid parentid INT(11) NOT NULL DEFAULT 0,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_links_editorials
  CHANGE COLUMN linkid linkid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN adminid adminid VARCHAR(60) NOT NULL,
  CHANGE COLUMN editorialtimestamp editorialtimestamp DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  CHANGE COLUMN editorialtext editorialtext TEXT NOT NULL,
  CHANGE COLUMN editorialtitle editorialtitle VARCHAR(100) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_links_links
  CHANGE COLUMN lid lid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN cid cid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN sid sid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN title title VARCHAR(100) NOT NULL,
  CHANGE COLUMN url url VARCHAR(100) NOT NULL,
  CHANGE COLUMN description description TEXT NOT NULL,
  CHANGE COLUMN `date` `date` DATETIME DEFAULT NULL,
  CHANGE COLUMN name name VARCHAR(100) NOT NULL,
  CHANGE COLUMN email email VARCHAR(100) NOT NULL,
  CHANGE COLUMN hits hits INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN submitter submitter VARCHAR(60) NOT NULL,
  CHANGE COLUMN linkratingsummary linkratingsummary DOUBLE(6, 4) NOT NULL DEFAULT 0.0000,
  CHANGE COLUMN totalvotes totalvotes INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN totalcomments totalcomments INT(11) NOT NULL DEFAULT 0,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_links_modrequest
  CHANGE COLUMN requestid requestid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN lid lid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN cid cid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN sid sid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN title title VARCHAR(100) NOT NULL,
  CHANGE COLUMN url url VARCHAR(100) NOT NULL,
  CHANGE COLUMN description description TEXT NOT NULL,
  CHANGE COLUMN modifysubmitter modifysubmitter VARCHAR(60) NOT NULL,
  CHANGE COLUMN brokenlink brokenlink INT(3) NOT NULL DEFAULT 0,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_links_newlink
  CHANGE COLUMN lid lid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN cid cid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN sid sid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN title title VARCHAR(100) NOT NULL,
  CHANGE COLUMN url url VARCHAR(100) NOT NULL,
  CHANGE COLUMN description description TEXT NOT NULL,
  CHANGE COLUMN name name VARCHAR(100) NOT NULL,
  CHANGE COLUMN email email VARCHAR(100) NOT NULL,
  CHANGE COLUMN submitter submitter VARCHAR(60) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_links_votedata
  CHANGE COLUMN ratingdbid ratingdbid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN ratinglid ratinglid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN ratinguser ratinguser VARCHAR(60) NOT NULL,
  CHANGE COLUMN rating rating INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN ratinghostname ratinghostname VARCHAR(60) NOT NULL,
  CHANGE COLUMN ratingcomments ratingcomments TEXT NOT NULL,
  CHANGE COLUMN ratingtimestamp ratingtimestamp DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_linktous (
  l_id INT(11) NOT NULL AUTO_INCREMENT,
  l_zipurl VARCHAR(255) NOT NULL DEFAULT '',
  l_image VARCHAR(255) NOT NULL DEFAULT '',
  l_mouseover VARCHAR(255) NOT NULL DEFAULT '',
  l_status INT(1) NOT NULL DEFAULT 0,
  l_size_width CHAR(3) NOT NULL DEFAULT '0',
  l_size_height CHAR(3) NOT NULL DEFAULT '0',
  l_hits BIGINT(20) NOT NULL DEFAULT 0,
  l_linktype INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (l_id),
  INDEX l_id (l_id)
)
ENGINE = MYISAM
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
",
"
CREATE TABLE nuke_linktous_config (
  config_name VARCHAR(255) NOT NULL,
  config_value VARCHAR(255) NOT NULL,
  PRIMARY KEY (config_name)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_linktous_resources (
  r_id INT(11) NOT NULL AUTO_INCREMENT,
  r_name VARCHAR(60) NOT NULL,
  r_url VARCHAR(255) NOT NULL,
  r_image VARCHAR(255) NOT NULL,
  r_status INT(1) NOT NULL DEFAULT 0,
  r_size_width CHAR(3) NOT NULL DEFAULT '0',
  r_size_height CHAR(3) NOT NULL DEFAULT '0',
  r_hits BIGINT(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (r_id),
  INDEX r_id (r_id)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_main
  CHANGE COLUMN main_module main_module VARCHAR(255) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_modules
  DROP COLUMN mcid,
  DROP COLUMN url,
  DROP COLUMN leftblock,
  CHANGE COLUMN mid mid INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN title title VARCHAR(255) NOT NULL,
  CHANGE COLUMN custom_title custom_title VARCHAR(255) NOT NULL,
  CHANGE COLUMN active active INT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN view view INT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN inmenu inmenu TINYINT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN mod_group mod_group INT(10) DEFAULT 0,
  CHANGE COLUMN admins admins VARCHAR(255) NOT NULL,
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_msconfig (
  id VARCHAR(50) NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_msmodules (
  name TEXT NOT NULL,
  `use` TEXT NOT NULL
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_accesses (
  username VARCHAR(60) NOT NULL,
  downloads INT(11) NOT NULL DEFAULT 0,
  uploads INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (username)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_categories (
  cid INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(50) NOT NULL,
  cdescription TEXT NOT NULL,
  parentid INT(11) NOT NULL DEFAULT 0,
  whoadd TINYINT(2) NOT NULL DEFAULT 0,
  uploaddir VARCHAR(255) NOT NULL,
  canupload TINYINT(2) NOT NULL DEFAULT 0,
  active TINYINT(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (cid),
  INDEX cid (cid),
  INDEX title (title)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_config (
  config_name VARCHAR(255) NOT NULL,
  config_value TEXT NOT NULL,
  PRIMARY KEY (config_name)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_downloads (
  lid INT(11) NOT NULL AUTO_INCREMENT,
  cid INT(11) NOT NULL DEFAULT 0,
  sid INT(11) NOT NULL DEFAULT 0,
  title VARCHAR(100) NOT NULL,
  url VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  `date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  hits INT(11) NOT NULL DEFAULT 0,
  submitter VARCHAR(60) NOT NULL,
  sub_ip VARCHAR(16) NOT NULL DEFAULT '0.0.0.0',
  filesize BIGINT(20) NOT NULL DEFAULT 0,
  version VARCHAR(20) NOT NULL,
  homepage VARCHAR(255) NOT NULL,
  active TINYINT(2) NOT NULL DEFAULT 1,
  `password` VARCHAR(255) NOT NULL,
  `source` VARCHAR(255) NOT NULL,
  tags VARCHAR(256) NOT NULL,
  rate INT(8) NOT NULL DEFAULT 0,
  rates_count INT(8) NOT NULL DEFAULT 0,
  PRIMARY KEY (lid),
  INDEX cid (cid),
  INDEX lid (lid),
  INDEX sid (sid),
  INDEX title (title)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_extensions (
  eid INT(11) NOT NULL AUTO_INCREMENT,
  ext VARCHAR(6) NOT NULL,
  file TINYINT(1) NOT NULL DEFAULT 0,
  image TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (eid),
  INDEX ext (eid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_mods (
  rid INT(11) NOT NULL AUTO_INCREMENT,
  lid INT(11) NOT NULL DEFAULT 0,
  cid INT(11) NOT NULL DEFAULT 0,
  sid INT(11) NOT NULL DEFAULT 0,
  title VARCHAR(100) NOT NULL,
  url VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  modifier VARCHAR(60) NOT NULL,
  sub_ip VARCHAR(16) NOT NULL DEFAULT '0.0.0.0',
  brokendownload INT(3) NOT NULL DEFAULT 0,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  filesize BIGINT(20) NOT NULL DEFAULT 0,
  version VARCHAR(20) NOT NULL,
  homepage VARCHAR(255) NOT NULL,
  PRIMARY KEY (rid),
  UNIQUE INDEX rid (rid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsngd_new (
  lid INT(11) NOT NULL AUTO_INCREMENT,
  cid INT(11) NOT NULL DEFAULT 0,
  sid INT(11) NOT NULL DEFAULT 0,
  title VARCHAR(100) NOT NULL,
  url VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  `date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  submitter VARCHAR(60) NOT NULL,
  sub_ip VARCHAR(16) NOT NULL DEFAULT '0.0.0.0',
  filesize BIGINT(20) NOT NULL DEFAULT 0,
  version VARCHAR(20) NOT NULL,
  homepage VARCHAR(255) NOT NULL,
  PRIMARY KEY (lid),
  INDEX cid (cid),
  INDEX lid (lid),
  INDEX sid (sid),
  INDEX title (title)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_nsnst_config (
  config_name VARCHAR(255) NOT NULL,
  config_value LONGTEXT NOT NULL,
  PRIMARY KEY (config_name)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_poll_check
  CHANGE COLUMN ip ip VARCHAR(20) NOT NULL,
  CHANGE COLUMN `time` `time` VARCHAR(14) NOT NULL,
  CHANGE COLUMN pollID pollID INT(10) NOT NULL DEFAULT 0,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_poll_data
  CHANGE COLUMN pollID pollID INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN optionText optionText CHAR(50) NOT NULL,
  CHANGE COLUMN optionCount optionCount INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN voteID voteID INT(11) NOT NULL DEFAULT 0,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_poll_desc
  CHANGE COLUMN pollID pollID INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN pollTitle pollTitle VARCHAR(100) NOT NULL,
  CHANGE COLUMN `timeStamp` `timeStamp` INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN voters voters MEDIUMINT(9) NOT NULL DEFAULT 0,
  CHANGE COLUMN planguage planguage VARCHAR(30) NOT NULL,
  CHANGE COLUMN artid artid INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN comments comments INT(11) DEFAULT 0,
  ADD COLUMN active INT(1) NOT NULL DEFAULT 0 AFTER comments,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_pollcomments
  DROP COLUMN act,
  CHANGE COLUMN tid tid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN pid pid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN pollID pollID INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN `date` `date` DATETIME DEFAULT NULL,
  CHANGE COLUMN name name VARCHAR(60) NOT NULL,
  CHANGE COLUMN email email VARCHAR(60) DEFAULT NULL,
  CHANGE COLUMN url url VARCHAR(60) DEFAULT NULL,
  CHANGE COLUMN host_name host_name VARCHAR(60) DEFAULT NULL,
  ADD COLUMN subject VARCHAR(60) NOT NULL AFTER host_name,
  CHANGE COLUMN `comment` `comment` TEXT NOT NULL AFTER subject,
  CHANGE COLUMN score score TINYINT(4) NOT NULL DEFAULT 0 AFTER `comment`,
  CHANGE COLUMN reason reason TINYINT(4) NOT NULL DEFAULT 0 AFTER score,
  CHANGE COLUMN last_moderation_ip last_moderation_ip VARCHAR(15) DEFAULT '0' AFTER reason,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_pollcomments_moderated
  CHANGE COLUMN tid tid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN pid pid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN pollID pollID INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN `date` `date` DATETIME DEFAULT NULL,
  CHANGE COLUMN name name VARCHAR(60) NOT NULL,
  CHANGE COLUMN email email VARCHAR(60) DEFAULT NULL,
  CHANGE COLUMN url url VARCHAR(60) DEFAULT NULL,
  CHANGE COLUMN host_name host_name VARCHAR(60) DEFAULT NULL,
  CHANGE COLUMN subject subject VARCHAR(60) NOT NULL,
  CHANGE COLUMN `comment` `comment` TEXT NOT NULL,
  CHANGE COLUMN score score TINYINT(4) NOT NULL DEFAULT 0,
  CHANGE COLUMN reason reason TINYINT(4) NOT NULL DEFAULT 0,
  CHANGE COLUMN last_moderation_ip last_moderation_ip VARCHAR(15) DEFAULT '0',
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_public_messages (
  mid INT(10) NOT NULL AUTO_INCREMENT,
  content VARCHAR(255) NOT NULL,
  `date` DATETIME DEFAULT NULL,
  who VARCHAR(25) NOT NULL,
  PRIMARY KEY (mid),
  INDEX mid (mid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_quotes (
  qid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  quote TEXT DEFAULT NULL,
  PRIMARY KEY (qid),
  INDEX qid (qid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_ratings (
  id INT(11) NOT NULL AUTO_INCREMENT,
  rating_id INT(11) NOT NULL DEFAULT 0,
  rating_num INT(11) NOT NULL DEFAULT 0,
  section INT(1) NOT NULL DEFAULT 0,
  ip VARCHAR(25) NOT NULL,
  voter VARCHAR(256) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_related
  CHANGE COLUMN rid rid INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN tid tid INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN name name VARCHAR(30) NOT NULL,
  CHANGE COLUMN url url VARCHAR(200) NOT NULL,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_session
  DROP COLUMN uname,
  DROP COLUMN `time`,
  DROP COLUMN host_addr,
  DROP COLUMN guest,
  DROP COLUMN module,
  DROP COLUMN url,
  DROP INDEX guest,
  DROP INDEX `time`,
  ADD COLUMN session_id VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL FIRST,
  ADD COLUMN session_user_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0 AFTER session_id,
  ADD COLUMN session_last_visit INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER session_user_id,
  ADD COLUMN session_start INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER session_last_visit,
  ADD COLUMN session_time INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER session_start,
  ADD COLUMN session_ip VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' AFTER session_time,
  ADD COLUMN session_browser VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' AFTER session_ip,
  ADD COLUMN session_page VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' AFTER session_browser,
  ADD COLUMN session_admin TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER session_page;
",
"
ALTER TABLE nuke_session
  ADD INDEX session_ip (session_ip);
",
"
ALTER TABLE nuke_session
  ADD UNIQUE INDEX session_ip_2 (session_ip);
",
"
ALTER TABLE nuke_session
  ADD INDEX session_time (session_time);
",
"
ALTER TABLE nuke_session
  ADD INDEX session_user_id (session_user_id);
",
"
ALTER TABLE nuke_session
  ADD PRIMARY KEY (session_id);
",
"
CREATE TABLE nuke_shoutbox (
  id INT(5) NOT NULL AUTO_INCREMENT,
  `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  user VARCHAR(25) NOT NULL DEFAULT 'anonimous',
  message VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_sitemap_config (
  config_name VARCHAR(255) NOT NULL,
  config_value TEXT NOT NULL,
  PRIMARY KEY (config_name)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
CREATE TABLE nuke_squestions (
  qid INT(2) NOT NULL AUTO_INCREMENT,
  question VARCHAR(256) NOT NULL,
  answer VARCHAR(256) NOT NULL,
  PRIMARY KEY (qid)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_bin;
",
"
ALTER TABLE nuke_stories
  DROP COLUMN newslevel,
  DROP COLUMN news_group,
  DROP COLUMN newsurl,
  DROP COLUMN score,
  DROP COLUMN ratings,
  DROP COLUMN rating_ip,
  DROP COLUMN position,
  DROP COLUMN story_pass,
  DROP COLUMN topic_link,
  DROP INDEX counter,
  CHANGE COLUMN sid sid INT(11) NOT NULL AUTO_INCREMENT,
  ADD COLUMN catid INT(11) NOT NULL DEFAULT 0 AFTER sid,
  CHANGE COLUMN aid aid VARCHAR(30) NOT NULL AFTER catid,
  CHANGE COLUMN title title VARCHAR(80) DEFAULT NULL AFTER aid,
  CHANGE COLUMN `time` `time` DATETIME DEFAULT NULL AFTER title,
  CHANGE COLUMN hometext hometext TEXT DEFAULT NULL AFTER `time`,
  CHANGE COLUMN bodytext bodytext TEXT NOT NULL AFTER hometext,
  ADD COLUMN newsref VARCHAR(100) DEFAULT NULL AFTER bodytext,
  ADD COLUMN newsreflink VARCHAR(200) DEFAULT NULL AFTER newsref,
  CHANGE COLUMN comments comments INT(11) NOT NULL DEFAULT 0,
  CHANGE COLUMN counter counter MEDIUMINT(8) NOT NULL DEFAULT 0,
  CHANGE COLUMN topic topic INT(3) NOT NULL DEFAULT 1,
  CHANGE COLUMN informant informant VARCHAR(25) NOT NULL,
  CHANGE COLUMN notes notes TEXT NOT NULL,
  CHANGE COLUMN ihome ihome INT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN alanguage alanguage VARCHAR(30) NOT NULL,
  CHANGE COLUMN acomm acomm INT(1) NOT NULL DEFAULT 0,
  ADD COLUMN hotnews INT(1) NOT NULL DEFAULT 0 AFTER acomm,
  CHANGE COLUMN haspoll haspoll INT(1) NOT NULL DEFAULT 0 AFTER hotnews,
  CHANGE COLUMN pollID pollID INT(10) NOT NULL DEFAULT 0 AFTER haspoll,
  ADD COLUMN associated TEXT NOT NULL AFTER pollID,
  ADD COLUMN tags VARCHAR(255) NOT NULL AFTER associated,
  ADD COLUMN approved TINYINT(1) NOT NULL DEFAULT 1 AFTER tags,
  ADD COLUMN section VARCHAR(15) NOT NULL DEFAULT 'news' AFTER approved,
  ADD COLUMN rate INT(8) NOT NULL DEFAULT 0 AFTER section,
  ADD COLUMN rates_count INT(8) NOT NULL DEFAULT 0 AFTER rate,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_stories
  ADD INDEX catid (catid);
",
"
ALTER TABLE nuke_tags
  DROP COLUMN tag_id,
  DROP COLUMN counter,
  ADD COLUMN tid INT(5) NOT NULL AUTO_INCREMENT FIRST,
  CHANGE COLUMN tag tag VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  ADD COLUMN slug VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER tag,
  ADD COLUMN count INT(6) NOT NULL AFTER slug,
  DROP PRIMARY KEY,
  ADD PRIMARY KEY (tid);
",
"
ALTER TABLE nuke_topics
  DROP COLUMN parent_id,
  CHANGE COLUMN topicid topicid INT(3) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN topicname topicname VARCHAR(70) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  ADD COLUMN slug TEXT CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL AFTER topicname,
  CHANGE COLUMN topicimage topicimage VARCHAR(100) DEFAULT NULL AFTER slug,
  CHANGE COLUMN topictext topictext VARCHAR(40) DEFAULT NULL AFTER topicimage,
  ADD COLUMN parent BIGINT(20) UNSIGNED NOT NULL DEFAULT 0 AFTER topictext,
  CHANGE COLUMN counter counter INT(11) NOT NULL DEFAULT 0 AFTER parent,
  COLLATE utf8_bin;
",
"
CREATE TABLE nuke_tree_elements (
  Id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  lang VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  position INT(10) UNSIGNED NOT NULL DEFAULT 0,
  ownerEl INT(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'parent',
  slave BINARY(1) NOT NULL DEFAULT '0',
  link TEXT NOT NULL,
  module VARCHAR(255) NOT NULL,
  icon VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Icon URI',
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET utf8
COLLATE utf8_general_ci;
",
"
ALTER TABLE nuke_users
  DROP COLUMN user_type,
  DROP COLUMN group_id,
  DROP COLUMN user_permissions,
  DROP COLUMN user_perm_from,
  DROP COLUMN user_ip,
  DROP COLUMN username_clean,
  DROP COLUMN user_passchg,
  DROP COLUMN user_pass_convert,
  DROP COLUMN user_email_hash,
  DROP COLUMN user_birthday,
  DROP COLUMN user_lastmark,
  DROP COLUMN user_lastpost_time,
  DROP COLUMN user_lastpage,
  DROP COLUMN user_last_confirm_key,
  DROP COLUMN user_last_search,
  DROP COLUMN user_warnings,
  DROP COLUMN user_last_warning,
  DROP COLUMN user_login_attempts,
  DROP COLUMN user_inactive_reason,
  DROP COLUMN user_inactive_time,
  DROP COLUMN user_dst,
  DROP COLUMN user_colour,
  DROP COLUMN user_message_rules,
  DROP COLUMN user_full_folder,
  DROP COLUMN user_topic_show_days,
  DROP COLUMN user_topic_sortby_type,
  DROP COLUMN user_topic_sortby_dir,
  DROP COLUMN user_post_show_days,
  DROP COLUMN user_post_sortby_type,
  DROP COLUMN user_post_sortby_dir,
  DROP COLUMN user_notify_type,
  DROP COLUMN user_allow_viewemail,
  DROP COLUMN user_allow_massemail,
  DROP COLUMN user_options,
  DROP COLUMN user_avatar_width,
  DROP COLUMN user_avatar_height,
  DROP COLUMN user_sig_bbcode_bitfield,
  DROP COLUMN user_jabber,
  DROP COLUMN user_form_salt,
  DROP COLUMN user_new,
  DROP COLUMN user_reminded,
  DROP COLUMN user_reminded_time,
  DROP COLUMN user_timezone2,
  DROP COLUMN user_sdateformat,
  DROP COLUMN user_thanks_received,
  DROP COLUMN user_thanks_given,
  DROP COLUMN user_allow_thanks_pm,
  DROP COLUMN user_allow_thanks_email,
  CHANGE COLUMN user_id user_id INT(11) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN name name VARCHAR(60) DEFAULT NULL AFTER user_id,
  CHANGE COLUMN username username VARCHAR(25) DEFAULT NULL AFTER name,
  CHANGE COLUMN user_email user_email VARCHAR(255) DEFAULT NULL AFTER username,
  CHANGE COLUMN femail femail VARCHAR(255) DEFAULT NULL AFTER user_email,
  CHANGE COLUMN user_website user_website VARCHAR(255) DEFAULT NULL AFTER femail,
  CHANGE COLUMN user_avatar user_avatar VARCHAR(255) DEFAULT NULL AFTER user_website,
  CHANGE COLUMN user_regdate user_regdate VARCHAR(20) DEFAULT NULL AFTER user_avatar,
  CHANGE COLUMN user_icq user_icq VARCHAR(15) DEFAULT NULL AFTER user_regdate,
  CHANGE COLUMN user_occ user_occ VARCHAR(100) DEFAULT NULL AFTER user_icq,
  CHANGE COLUMN user_from user_from VARCHAR(100) DEFAULT NULL AFTER user_occ,
  ADD COLUMN user_from_flag VARCHAR(25) DEFAULT NULL AFTER user_from,
  CHANGE COLUMN user_interests user_interests VARCHAR(150) DEFAULT NULL AFTER user_from_flag,
  CHANGE COLUMN user_sig user_sig VARCHAR(255) DEFAULT NULL AFTER user_interests,
  CHANGE COLUMN user_viewemail user_viewemail TINYINT(2) DEFAULT NULL AFTER user_sig,
  CHANGE COLUMN user_theme user_theme INT(3) DEFAULT NULL AFTER user_viewemail,
  CHANGE COLUMN user_aim user_aim VARCHAR(18) DEFAULT NULL AFTER user_theme,
  CHANGE COLUMN user_yim user_yim VARCHAR(25) DEFAULT NULL AFTER user_aim,
  CHANGE COLUMN user_msnm user_msnm VARCHAR(25) DEFAULT NULL AFTER user_yim,
  CHANGE COLUMN user_password user_password VARCHAR(40) DEFAULT NULL AFTER user_msnm,
  CHANGE COLUMN storynum storynum TINYINT(4) NOT NULL DEFAULT 10 AFTER user_password,
  CHANGE COLUMN umode umode VARCHAR(10) DEFAULT NULL AFTER storynum,
  CHANGE COLUMN uorder uorder TINYINT(1) NOT NULL DEFAULT 0 AFTER umode,
  CHANGE COLUMN thold thold TINYINT(1) NOT NULL DEFAULT 0 AFTER uorder,
  CHANGE COLUMN noscore noscore TINYINT(1) NOT NULL DEFAULT 0 AFTER thold,
  CHANGE COLUMN bio bio TINYTEXT DEFAULT NULL AFTER noscore,
  CHANGE COLUMN ublockon ublockon TINYINT(1) NOT NULL DEFAULT 0 AFTER bio,
  CHANGE COLUMN ublock ublock TINYTEXT DEFAULT NULL AFTER ublockon,
  CHANGE COLUMN theme theme VARCHAR(255) DEFAULT NULL AFTER ublock,
  CHANGE COLUMN commentmax commentmax INT(11) NOT NULL DEFAULT 255 AFTER theme,
  CHANGE COLUMN counter counter INT(11) NOT NULL DEFAULT 0 AFTER commentmax,
  CHANGE COLUMN newsletter newsletter INT(1) NOT NULL DEFAULT 0 AFTER counter,
  CHANGE COLUMN user_posts user_posts INT(10) NOT NULL DEFAULT 0 AFTER newsletter,
  CHANGE COLUMN user_attachsig user_attachsig INT(2) NOT NULL DEFAULT 0 AFTER user_posts,
  CHANGE COLUMN user_rank user_rank INT(10) NOT NULL DEFAULT 0 AFTER user_attachsig,
  CHANGE COLUMN user_level user_level INT(10) NOT NULL DEFAULT 1 AFTER user_rank,
  CHANGE COLUMN broadcast broadcast TINYINT(1) NOT NULL DEFAULT 1 AFTER user_level,
  CHANGE COLUMN popmeson popmeson TINYINT(1) NOT NULL DEFAULT 0 AFTER broadcast,
  CHANGE COLUMN user_active user_active TINYINT(1) DEFAULT 1 AFTER popmeson,
  CHANGE COLUMN user_session_time user_session_time INT(11) NOT NULL DEFAULT 0 AFTER user_active,
  CHANGE COLUMN user_session_page user_session_page SMALLINT(5) NOT NULL DEFAULT 0 AFTER user_session_time,
  CHANGE COLUMN user_lastvisit user_lastvisit INT(11) NOT NULL DEFAULT 0 AFTER user_session_page,
  CHANGE COLUMN user_timezone user_timezone TINYINT(4) NOT NULL DEFAULT 10 AFTER user_lastvisit,
  CHANGE COLUMN user_style user_style TINYINT(4) DEFAULT NULL AFTER user_timezone,
  CHANGE COLUMN user_lang user_lang VARCHAR(255) NOT NULL DEFAULT 'persian' AFTER user_style,
  CHANGE COLUMN user_dateformat user_dateformat VARCHAR(14) NOT NULL DEFAULT 'D M d, Y g:i a' AFTER user_lang,
  CHANGE COLUMN user_new_privmsg user_new_privmsg SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0 AFTER user_dateformat,
  CHANGE COLUMN user_unread_privmsg user_unread_privmsg SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0 AFTER user_new_privmsg,
  CHANGE COLUMN user_last_privmsg user_last_privmsg INT(11) NOT NULL DEFAULT 0 AFTER user_unread_privmsg,
  CHANGE COLUMN user_emailtime user_emailtime INT(11) DEFAULT NULL AFTER user_last_privmsg,
  CHANGE COLUMN user_allowhtml user_allowhtml TINYINT(1) DEFAULT 1 AFTER user_emailtime,
  CHANGE COLUMN user_allowbbcode user_allowbbcode TINYINT(1) DEFAULT 1 AFTER user_allowhtml,
  CHANGE COLUMN user_allowsmile user_allowsmile TINYINT(1) DEFAULT 1 AFTER user_allowbbcode,
  CHANGE COLUMN user_allowavatar user_allowavatar TINYINT(1) NOT NULL DEFAULT 1 AFTER user_allowsmile,
  CHANGE COLUMN user_allow_pm user_allow_pm TINYINT(1) NOT NULL DEFAULT 1 AFTER user_allowavatar,
  CHANGE COLUMN user_allow_viewonline user_allow_viewonline TINYINT(1) NOT NULL DEFAULT 1 AFTER user_allow_pm,
  CHANGE COLUMN user_notify user_notify TINYINT(1) NOT NULL DEFAULT 0 AFTER user_allow_viewonline,
  CHANGE COLUMN user_notify_pm user_notify_pm TINYINT(1) NOT NULL DEFAULT 0 AFTER user_notify,
  CHANGE COLUMN user_popup_pm user_popup_pm TINYINT(1) NOT NULL DEFAULT 0 AFTER user_notify_pm,
  CHANGE COLUMN user_avatar_type user_avatar_type TINYINT(4) NOT NULL DEFAULT 3 AFTER user_popup_pm,
  CHANGE COLUMN user_sig_bbcode_uid user_sig_bbcode_uid VARCHAR(10) DEFAULT NULL AFTER user_avatar_type,
  CHANGE COLUMN user_actkey user_actkey VARCHAR(32) DEFAULT NULL AFTER user_sig_bbcode_uid,
  CHANGE COLUMN user_newpasswd user_newpasswd VARCHAR(32) DEFAULT NULL AFTER user_actkey,
  CHANGE COLUMN points points INT(10) DEFAULT 0 AFTER user_newpasswd,
  CHANGE COLUMN last_ip last_ip VARCHAR(15) NOT NULL DEFAULT '0' AFTER points,
  ADD COLUMN agreedtos TINYINT(1) NOT NULL DEFAULT 0 AFTER last_ip,
  CHANGE COLUMN user_group_cp user_group_cp INT(11) NOT NULL DEFAULT 1 AFTER agreedtos,
  CHANGE COLUMN user_group_list_cp user_group_list_cp VARCHAR(100) NOT NULL DEFAULT '2' AFTER user_group_cp,
  CHANGE COLUMN user_active_cp user_active_cp ENUM('YES','NO') NOT NULL DEFAULT 'YES' AFTER user_group_list_cp,
  ADD COLUMN admin_allow_points TINYINT(1) NOT NULL DEFAULT 1 AFTER user_active_cp,
  CHANGE COLUMN karma karma TINYINT(1) DEFAULT 0 AFTER admin_allow_points,
  ADD COLUMN user_level2 SMALLINT(6) NOT NULL DEFAULT 2 AFTER karma,
  ADD COLUMN user_allowemails TINYINT(1) NOT NULL DEFAULT 1 AFTER user_level2,
  ADD COLUMN user_invisible TINYINT(1) NOT NULL DEFAULT 0 AFTER user_allowemails,
  ADD COLUMN user_lastaction INT(11) NOT NULL DEFAULT 0 AFTER user_invisible,
  ADD COLUMN user_location VARCHAR(255) DEFAULT NULL AFTER user_lastaction,
  ADD COLUMN user_comments SMALLINT(6) UNSIGNED NOT NULL DEFAULT 0 AFTER user_location,
  ADD COLUMN user_blog_colors VARCHAR(255) NOT NULL DEFAULT '#F9F1A9#EEE4C6#EDFAC8' AFTER user_comments,
  ADD COLUMN user_blog_password VARCHAR(255) NOT NULL AFTER user_blog_colors,
  ADD COLUMN rate INT(8) NOT NULL DEFAULT 0 AFTER user_blog_password,
  ADD COLUMN rates_count INT(8) NOT NULL DEFAULT 0 AFTER rate,
  COLLATE utf8_bin;
",
"
ALTER TABLE nuke_users
  DROP INDEX uname,
  ADD INDEX uname (username);
",
"
ALTER TABLE nuke_users
  ADD UNIQUE INDEX username (username);
",
"
ALTER TABLE nuke_users_temp
  CHANGE COLUMN user_id user_id INT(10) NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN username username VARCHAR(25) NOT NULL,
  CHANGE COLUMN realname realname VARCHAR(255) NOT NULL,
  CHANGE COLUMN user_email user_email VARCHAR(255) NOT NULL,
  CHANGE COLUMN user_password user_password VARCHAR(40) NOT NULL,
  CHANGE COLUMN user_regdate user_regdate VARCHAR(20) NOT NULL,
  CHANGE COLUMN check_num check_num VARCHAR(50) NOT NULL,
  CHANGE COLUMN `time` `time` VARCHAR(14) NOT NULL,
  COLLATE utf8_bin;
",
"
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
		
	}
} else {
	echo "<b><img src='images/icon/note.png'>تنها مدیرکل سایت امکان اجرای ارتقا سایت را دارد . <br>
	در صورتی که مدیر این سایت هستید . به بخش مدیریت خود وارد شوید و مجدد این بخش را اجرا کنید.<br><br><br>
	<img src='images/icon/user.png'><a href='install.php' class='button'>بازگشت به صفحه اول نصب کننده</a>
	</b>\n";
}
?>