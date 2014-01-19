<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Based on Journey Links Hack                          */
/* Copyright (c) 2000 by James Knickelbein              */
/* Journey Milwaukee (http://www.journeymilwaukee.com)  */
/********************************************************/

if(!defined('MODULE_FILE')) {
  header("Location: ../../index.php");
  die();
}
$module_name = basename(dirname(__FILE__));
@require_once("mainfile.php");
define("blocks_show",true);
define('RATING_IN', true);
define('TAGS_IN', true);
define("MLink","modules.php?name=$module_name");
define("PATH","modules/$module_name/");


get_lang($module_name);
$pagetitle = _DOWNLOADS;
include_once(PATH."public/functions.php");
$result1 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_config");
$dl_config = gdget_configs();
if (!$dl_config OR $dl_config=="") {
    @include("header.php");
    title(_DL_DBCONFIG);
    @include("footer.php");
    die();
}
define('INDEX_FILE', true);
if(isset($d_op)) { $op = $d_op; unset($d_op); }
if(!isset($op)) { $op = "index"; }
if($op == "viewdownload") { $op = "getit"; }
if($op == "viewdownloaddetails") { $op = "getit"; }
switch($op) {
    case "index":@include("modules/$module_name/public/index.php");break;
    case "tags":@include("modules/$module_name/public/tags.php");break;//tags    
    case "NewDownloads":@include("modules/$module_name/public/NewDownloads.php");break;
    case "NewDownloadsDate":@include("modules/$module_name/public/NewDownloadsDate.php");break;
    case "MostPopular":@include("modules/$module_name/public/MostPopular.php");break;
    case "brokendownload":@include("modules/$module_name/public/brokendownload.php");break;
    case "brokendownloadS":@include("modules/$module_name/public/brokendownloadS.php");break;
    case "modifydownloadrequest":@include("modules/$module_name/public/modifydownloadrequest.php");break;
    case "modifydownloadrequestS":@include("modules/$module_name/public/modifydownloadrequestS.php");break;
    case "getit":@include("modules/$module_name/public/getit.php");break;
    case "go":@include("modules/$module_name/public/go.php");break;
    case "search":@include("modules/$module_name/public/search.php");break;
}

?>