<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com

   Filename      : SMLimits.php
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

$pagetitle = _SMADMIN.": "._SMLIMITS;
include_once("header.php");
    GraphicAdmin();
$sm_config = sitemap_get_configs();

title($pagetitle);
SMadminmain();

echo "<br />\n";

OpenTable();

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr width='100%'><td><center><b>"._SMLIMITSDESC.":</b></center></td></tr>\n";
echo "<tr><td></td></tr>\n";
echo "</table>\n";

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";

echo "<tr><td>"._SMLIMITNEWS."</td><td>\n";
echo "<input type='text'  name='xlimit_news' value='".$sm_config['limit_news']."'>\n";
echo "</td></tr>\n";

if (is_active("phpBB3")) {
echo "<tr><td>"._SMLIMITFORUMTOPICS."</td><td>\n";
echo "<input type='text'  name='xlimit_forum_topics' value='".$sm_config['limit_forum_topics']."' ></td></tr>\n";
}
echo "<tr><td>"._SMLIMITDL."</td><td>\n";
echo "<input type='text'  value='".$sm_config['limit_downloads']."' name='xlimit_downloads'>\n";
echo "</td></tr>\n";

echo "<tr><td>"._SMLIMITWL."</td><td>\n";
echo "<input type='text'  name='xlimit_weblinks' value='".$sm_config['limit_weblinks']."' >\n";
echo "</td></tr>\n";

/*
echo "<tr><td>"._SMLIMITCONTENT."</td><td><select name='xlimit_content'>\n";
echo "<option value='".$sm_config['limit_content']."' selected> ".$sm_config['limit_content']." </option>\n";
for ($i=1; $i <= 8; $i++) { $j = $i * 25; echo "<option value='$j'> $j </option>\n"; }
echo "</select></td></tr>\n";

echo "<tr><td>"._SMLIMITREVIEWS."</td><td><select name='xlimit_reviews'>\n";
echo "<option value='".$sm_config['limit_reviews']."' selected> ".$sm_config['limit_reviews']." </option>\n";
for ($i=1; $i <= 8; $i++) { $j = $i * 25; echo "<option value='$j'> $j </option>\n"; }
echo "</select></td></tr>\n";

echo "<tr><td>"._SMLIMITTUTORIALS."</td><td><select name='xlimit_tutorials'>\n";
echo "<option value='".$sm_config['limit_tutorials']."' selected> ".$sm_config['limit_tutorials']." </option>\n";
for ($i=1; $i <= 8; $i++) { $j = $i * 25; echo "<option value='$j'> $j </option>\n"; }
echo "</select></td></tr>\n";

echo "<tr><td>"._SMLIMITPJ."</td><td><select name='xlimit_projects'>\n";
echo "<option value='".$sm_config['limit_projects']."' selected> ".$sm_config['limit_projects']." </option>\n";
for ($i=1; $i <= 8; $i++) { $j = $i * 25; echo "<option value='$j'> $j </option>\n"; }
echo "</select></td></tr>\n";
*/

echo "<tr><td>"._SMLIMITSHOUTS."</td><td>\n";
echo "<input type='text'  name='xlimit_shouts' value='".$sm_config['limit_shouts']."' >\n";
echo "</td></tr>\n";

echo "<tr><td>"._SMLIMITUSERS."</td><td>\n";
echo "<input type='text'  name='xlimit_supporters' value='".$sm_config['limit_supporters']."' >\n";
echo "</td></tr>\n";

echo "<tr><td></td></tr>\n";

echo "<input type='hidden' name='op' value='SMLimitsSave'>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SAVECHANGES."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";

CloseTable();

include_once("footer.php");

?>