<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : SMGoogleSave.php
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

global $xsite_logo,$xsite_logo_path,$xgoogle_logo_height,$xgoogle_logo_width,$xgoogle_header,$xgoogle_bg,$xgoogle_logo,$xgoogle_logo_path;

sitemap_save_config("site_logo","$xsite_logo");
sitemap_save_config("site_logo_path","$xsite_logo_path");
sitemap_save_config("site_google_logo_height","$xgoogle_logo_height");
sitemap_save_config("site_google_logo_width","$xgoogle_logo_width");
sitemap_save_config("site_google_header","$xgoogle_header");
sitemap_save_config("site_google_bg","$xgoogle_bg");
sitemap_save_config("google_logo","$xgoogle_logo");
sitemap_save_config("google_logo_path","$xgoogle_logo_path");
Header("Location: ".$admin_file.".php?op=SMGoogle");

?>