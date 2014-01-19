<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : SMConfigSave.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.0
   Date          : 12/20/2005 (mm-dd-yyyy)

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
global $xmatch_theme,$xuse_gt,$xshow_google_block,$xshow_gentime;
sitemap_save_config("match_theme","$xmatch_theme");
sitemap_save_config("use_gt","$xuse_gt");
sitemap_save_config("show_google_block","$xshow_google_block");
sitemap_save_config("show_gentime","$xshow_gentime");
//sitemap_save_config("use_sommaire","$xuse_sommaire");
Header("Location: ".$admin_file.".php?op=SMConfig");


?>