<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : index.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.0
   Date          : 12/22/2005 (mm-dd-yyyy)

   Description   : Site Map generates a list of useful links from your
                   modules and displays them on one page. Goal is to
                   provide search engines like Google with a static page
                   of links to dynamic pages. You should link to this
                   page from your sites home page somewhere.
************************************************************************/
/* Based on NSN GR Downloads                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)                 */
/* http://www.nukescripts.net                                          */
/* Copyright � 2000-2005 by NukeScripts Network                        */
/***********************************************************************/

if (!defined('ADMIN_FILE')) {
   die ('Access Denied');
}

global $prefix, $db;
$module_name = basename(dirname(dirname(__FILE__)));
get_lang($module_name);
define('IN_SITEMAP', true);
global $prefix, $db,$admin, $admin_file;
$module_name = basename(dirname(dirname(__FILE__)));
$aid = substr("$aid", 0,25);
if (is_superadmin($admin) OR is_admin_of($module_name,$admin)) {



$result = $db->sql_query("SELECT config_name FROM nuke_sitemap_config");
$db->sql_freeresult($result);
if (!$result) {

$result = $db->sql_query("
CREATE TABLE IF NOT EXISTS `nuke_sitemap_config` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `nuke_sitemap_config` (`config_name`, `config_value`) VALUES
('match_theme', '0'),
('use_sommaire', '0'),
('use_gt', '1'),
('show_google_block', '0'),
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
('show_supporters', '0'),
('show_shouts', '0'),
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
");
}

  include_once("modules/".$module_name."/includes/functions.php");
  $sm_config = sitemap_get_configs();
  if(!isset($op)) { $op="SMConfig"; }
  switch ($op) {
    case "SMMain":include_once("modules/".$module_name."/admin/SMMain.php");break;
    case "SMConfig":include_once("modules/".$module_name."/admin/SMConfig.php");break;
    case "SMConfigSave":include_once("modules/".$module_name."/admin/SMConfigSave.php");break;
    case "SMMods":include_once("modules/".$module_name."/admin/SMMods.php");break;
    case "SMModsSave":include_once("modules/".$module_name."/admin/SMModsSave.php");break;
    case "SMLimits":include_once("modules/".$module_name."/admin/SMLimits.php");break;
    case "SMLimitsSave":include_once("modules/".$module_name."/admin/SMLimitsSave.php");break;
    case "SMGoogle":include_once("modules/".$module_name."/admin/SMGoogle.php");break;
    case "SMGoogleSave":include_once("modules/".$module_name."/admin/SMGoogleSave.php");break;
  }

}else {
	die("Access Denied To $module_name administration");
}
?>