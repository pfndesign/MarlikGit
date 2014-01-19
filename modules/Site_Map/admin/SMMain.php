<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : SMain.php
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
  $pagetitle = _SMADMIN;

  include_once("header.php");
    GraphicAdmin();
  title($pagetitle);
  SMadminmain();
  include_once("footer.php");

?>