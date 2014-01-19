<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : SMLimitsSave.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.0
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

sitemap_save_config("limit_news",$xlimit_news);
sitemap_save_config("limit_fna",$xlimit_fna);
sitemap_save_config("limit_forum_topics",$xlimit_forum_topics);
sitemap_save_config("limit_kb",$xlimit_kb);
sitemap_save_config("limit_downloads",$xlimit_downloads);
sitemap_save_config("limit_weblinks",$xlimit_weblinks);
sitemap_save_config("limit_content",$xlimit_content);
sitemap_save_config("limit_reviews",$xlimit_reviews);
sitemap_save_config("limit_tutorials",$xlimit_tutorials);
sitemap_save_config("limit_projects",$xlimit_projects);
sitemap_save_config("limit_supporters",$xlimit_supporters);
sitemap_save_config("limit_coppermine_pics",$xlimit_coppermine_pics);
sitemap_save_config("limit_shouts",$xlimit_shouts);
sitemap_save_config("limit_arcade",$xlimit_arcade);
Header("Location: ".$admin_file.".php?op=SMLimits");

?>