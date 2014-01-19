<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com

   Filename      : SMConfig.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.1
   Date          : 01/14/2006 (mm-dd-yyyy)

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

$pagetitle = _SMADMIN.": "._SMGENCONFIG;
include_once("header.php");
    GraphicAdmin();
$sm_config = sitemap_get_configs();

title($pagetitle);
SMadminmain();

echo "<br />\n";

OpenTable();

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr width='100%'><td><center><b>"._SMGENCONFIGDESC.":</b></center></td></tr>\n";
echo "<tr><td></td></tr>\n";
echo "</table>\n";

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";

echo "<tr><td>"._SMEMATCHTHEME.":</td><td>\n";
echo "<tr><td>"._SMMATCHTHEME."</td><td><select name='xmatch_theme'>\n";
echo "<option value='0'";
if ($sm_config['match_theme'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['match_theme'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td></td></tr>\n";
/*
echo "<tr><td>"._SMESOMMAIRE.":</td><td>\n";
echo "<tr><td>"._SMSOMMAIRE."</td><td><select name='xuse_sommaire'>\n";
echo "<option value='0'";
if ($sm_config['use_sommaire'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['use_sommaire'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td></td></tr>\n";
*/
echo "<tr><td>"._SMGOTGT.":</td><td>\n";
echo "<tr><td>"._SMGT."</td><td><select name='xuse_gt'>\n";
echo "<option value='0'";
if ($sm_config['use_gt'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['use_gt'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td></td></tr>\n";

echo "<tr><td>"._SMEGOOGLE.":</td><td>\n";
echo "<tr><td>"._SMGOOGLE."</td><td><select name='xshow_google_block'>\n";
echo "<option value='0'";
if ($sm_config['show_google_block'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_google_block'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td></td></tr>\n";

echo "<tr><td>"._SMEGENTIME.":</td><td>\n";
echo "<tr><td>"._SMGENTIME."</td><td><select name='xshow_gentime'>\n";
echo "<option value='0'";
if ($sm_config['show_gentime'] == 0) { echo " selected"; }
echo "> "._NO." </option>\n<option value='1'";
if ($sm_config['show_gentime'] == 1) { echo " selected"; }
echo "> "._YES." </option>\n";
echo "</select></td></tr>\n";

echo "<tr><td></td></tr>\n";

echo "<input type='hidden' name='op' value='SMConfigSave'>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SAVECHANGES."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";

CloseTable();

include_once("footer.php");

?>