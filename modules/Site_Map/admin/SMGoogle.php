<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : SMGoogle.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.0
   Date          : 12/18/2005 (mm-dd-yyyy)

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

$pagetitle = _SMADMIN.": "._SMGOOGLESETUP;
include_once("header.php");
    GraphicAdmin();
$sm_config = sitemap_get_configs();

title($pagetitle);
SMadminmain();

echo "<br />\n";

OpenTable();

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr width='100%'><td><center><b>"._SMGOOGLESETUPDESC.":</b></center></td></tr>\n";
echo "<tr><td></td></tr>\n";
echo "</table>\n";

echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";

echo "<tr><td>"._SMSITELOGO.":</td>\n<td>";
echo "<input type='text' name='xsite_logo' size='20' value='".$sm_config['site_logo']."'>";

echo "<tr><td>"._SMSITELOGOPATH.":</td>\n<td>";
echo "<input type='text' name='xsite_logo_path' size='35' value='".$sm_config['site_logo_path']."'>";

echo "<tr><td>"._SMSITELOGOHEIGHT.":</td>\n<td>";
echo "<input type='text' name='xgoogle_logo_height' size='3' value='".$sm_config['site_google_logo_height']."'>";

echo "<tr><td>"._SMSITELOGOWIDTH.":</td>\n<td>";
echo "<input type='text' name='xgoogle_logo_width' size='3' value='".$sm_config['site_google_logo_width']."'>";

echo "<tr><td>"._SMSITELOGOHEADER.":</td>\n<td>";
echo "<input type='text' name='xgoogle_header' size='5' value='".$sm_config['site_google_header']."'>";

echo "<tr><td>"._SMSITELOGOBG.":</td>\n<td>";
echo "<input type='text' name='xgoogle_bg' size='5' value='".$sm_config['site_google_bg']."'>";

echo "<tr><td>"._SMGOOGLELOGO.":</td>\n<td>";
echo "<input type='text' name='xgoogle_logo' size='20' value='".$sm_config['google_logo']."'>";

echo "<tr><td>"._SMGOOGLELOGOPATH.":</td>\n<td>";
echo "<input type='text' name='xgoogle_logo_path' size='35' value='".$sm_config['google_logo_path']."'>";

echo "<tr><td></td></tr>\n";

echo "<input type='hidden' name='op' value='SMGoogleSave'>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SAVECHANGES."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";

CloseTable();

include_once("footer.php");

?>