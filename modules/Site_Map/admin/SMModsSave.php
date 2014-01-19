<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright © 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : SMModsSave.php
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
/* Copyright © 2000-2005 by NukeScripts Network                        */
/***********************************************************************/

if(!defined('IN_SITEMAP')) {
  exit('Access Denied');
}

sitemap_save_config("show_news",$xshow_news);
sitemap_save_config("show_fna",$xshow_fna);
sitemap_save_config("show_forum_cat",$xshow_forum_cat);
sitemap_save_config("show_forums",$xshow_forums);
sitemap_save_config("show_forum_topics",$xshow_forum_topics);
sitemap_save_config("show_kb",$xshow_kb);
sitemap_save_config("show_downloads",$xshow_downloads);
sitemap_save_config("show_weblinks",$xshow_weblinks);
sitemap_save_config("show_faq",$xshow_faq);
sitemap_save_config("show_content",$xshow_content);
sitemap_save_config("show_reviews",$xshow_reviews);
sitemap_save_config("show_tutorials",$xshow_tutorials);
sitemap_save_config("show_projects",$xshow_projects);
sitemap_save_config("show_supporters",$xshow_supporters);
sitemap_save_config("show_shouts",$xshow_shouts);
sitemap_save_config("show_coppermine",$xshow_coppermine);
sitemap_save_config("show_spchat",$xshow_spchat);
sitemap_save_config("show_arcade",$xshow_arcade);
sitemap_save_config("show_rss",$xshow_rss);
Header("Location: ".$admin_file.".php?op=SMMods");

?>