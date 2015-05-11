<?php

/**
*
* @package Meta Datas														
* @version $Id: meta.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (stristr(htmlentities($_SERVER['PHP_SELF']), "meta.php")) {
    Header("Location: ../index.php");
    die();
}


//===========================================
//Dynamic Keywords generation
//===========================================
include_once('includes/inc_keywords.php');

global $commercial_license, $sitename, $slogan;


//===========================================
//META STRINGS
//===========================================

$metastring = "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset="._CHARSET."\">\n";
$metastring .= "<META HTTP-EQUIV=\"EXPIRES\" CONTENT=\"0\">\n";
$metastring .= "<META NAME=\"RESOURCE-TYPE\" CONTENT=\"DOCUMENT\">\n";
$metastring .= "<META NAME=\"DISTRIBUTION\" CONTENT=\"GLOBAL\">\n";
$metastring .= "<META NAME=\"AUTHOR\" CONTENT=\"$sitename\">\n";
$metastring .= "<META NAME=\"COPYRIGHT\" CONTENT=\"Copyright (c) by $sitename\">\n";
$metastring .= "<META NAME=\"KEYWORDS\" CONTENT=\"".getkeywords()."\">\n";
$metastring .= "<META NAME=\"DESCRIPTION\" CONTENT=\"".getdescription()."\">\n";
$metastring .= "<META NAME=\"ROBOTS\" CONTENT=\"INDEX, FOLLOW\">\n";
$metastring .= "<META NAME=\"REVISIT-AFTER\" CONTENT=\"1 DAYS\">\n";
$metastring .= "<META NAME=\"RATING\" CONTENT=\"GENERAL\">\n";


//===========================================
//COPYRIGHT
//===========================================
// IF YOU REALLY NEED TO REMOVE IT AND HAVE MY WRITTEN AUTHORIZATION CHECK: http://MarlikCMS.com
// PLAY FAIR AND SUPPORT THE DEVELOPMENT, PLEASE!
global $commercial_license;
if ($commercial_license != 1) {
$metastring .= "<META NAME=\"GENERATOR\" CONTENT=\"MarlikCMS Portal Copyright (c) 2009 by MarlikCMS.com.\">\n";
}
echo $metastring;
?>