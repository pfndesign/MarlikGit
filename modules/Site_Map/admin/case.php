<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright © 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : case.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.0
   Date          : 12/18/2005 (mm-dd-yyyy)

   Description   : Site Map generates a list of useful links from your
                   modules and displays them on one page. Goal is to
                   provide search engines like Google with a static page
                   of links to dynamic pages. You should link to this
                   page from your sites home page somewhere.
************************************************************************/

if(!defined('ADMIN_FILE')) {
    die('Access Denied');
}

$module_name = basename(dirname(dirname(__FILE__)));

switch ($op) {

      case "SMMain":
      case "SMConfig":
      case "SMConfigSave":
      case "SMMods":
      case "SMModsSave":
      case "SMLimits":
      case "SMLimitsSave":
      case "SMGoogle":
      case "SMGoogleSave":
      include_once("modules/".$module_name."/admin/index.php");
      break;

}

?>