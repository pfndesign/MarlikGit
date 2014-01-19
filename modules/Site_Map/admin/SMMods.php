<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com

   Filename      : SMMods.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.1
   Date          : 12/21/2005 (mm-dd-yyyy)

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

if(!defined('IN_SITEMAP')) {
  exit('Access Denied');
}

$pagetitle = _SMADMIN.": "._SMMODS;
include_once("header.php");
    GraphicAdmin();
$sm_config = sitemap_get_configs();

title($pagetitle);
SMadminmain();

echo "<br />\n";

OpenTable();

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr width='100%'><td><center><b>"._SMMODSDESC.":</b></center></td></tr>\n";
echo "<tr><td></td></tr>\n";
echo "</table>\n";

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMNEWS."</td><td><select name='xshow_news'>\n";
echo "<option value='0'";
if ($sm_config['show_news'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_news'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

if (is_active("phpBB3")) {
echo "<tr><td bgcolor='$bgcolor2'>"._SMFORUMCAT."</td><td><select name='xshow_forum_cat'>\n";
echo "<option value='0'";
if ($sm_config['show_forum_cat'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_forum_cat'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMFORUMS."</td><td><select name='xshow_forums'>\n";
echo "<option value='0'";
if ($sm_config['show_forums'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_forums'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMFORUMTOPICS."</td><td><select name='xshow_forum_topics'>\n";
echo "<option value='0'";
if ($sm_config['show_forum_topics'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_forum_topics'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";
	
}
echo "<tr><td bgcolor='$bgcolor2'>"._SMDL."</td><td><select name='xshow_downloads'>\n";
echo "<option value='0'";
if ($sm_config['show_downloads'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_downloads'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMWL."</td><td><select name='xshow_weblinks'>\n";
echo "<option value='0'";
if ($sm_config['show_weblinks'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_weblinks'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";
/*
echo "<tr><td bgcolor='$bgcolor2'>"._SMFAQ."</td><td><select name='xshow_faq'>\n";
echo "<option value='0'";
if ($sm_config['show_faq'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_faq'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMCONTENT."</td><td><select name='xshow_content'>\n";
echo "<option value='0'";
if ($sm_config['show_content'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_content'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMREVIEWS."</td><td><select name='xshow_reviews'>\n";
echo "<option value='0'";
if ($sm_config['show_reviews'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_reviews'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMTUTORIALS."</td><td><select name='xshow_tutorials'>\n";
echo "<option value='0'";
if ($sm_config['show_tutorials'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_tutorials'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMPJ."</td><td><select name='xshow_projects'>\n";
echo "<option value='0'";
if ($sm_config['show_projects'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_projects'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";
//*/
echo "<tr><td bgcolor='$bgcolor2'>"._SMSUSERS."</td><td><select name='xshow_supporters'>\n";
echo "<option value='0'";
if ($sm_config['show_supporters'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_supporters'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMSHOUTS."</td><td><select name='xshow_shouts'>\n";
echo "<option value='0'";
if ($sm_config['show_shouts'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_shouts'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td bgcolor='$bgcolor2'>"._SMRSS."</td><td><select name='xshow_rss'>\n";
echo "<option value='0'";
if ($sm_config['show_rss'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_rss'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td></td></tr>\n";

echo "<input type='hidden' name='op' value='SMModsSave'>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SAVECHANGES."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";

CloseTable();

include_once("footer.php");

?>