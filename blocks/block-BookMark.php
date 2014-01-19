<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV NUKELEARN PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Nukelearn Group															|
	|	* http://www.nukelearn.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

###############################################################################
# nukeSEO Social Bookmarking Copyright (c) 2006 Kevin Guske  http://nukeSEO.com
###############################################################################
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
###############################################################################
if (stristr($_SERVER['SCRIPT_NAME'], "block-BookMark.php"))
{
        Header("Location: ../../index.php");
        die();
}

global $prefix, $db, $name, $pagetitle, $nukeurl;
include_once("includes/inc_bookmark.php");
$content .= "<center>";

$_SERVER['FULL_URL'] = 'http';
if($_SERVER['HTTPS']=='on'){
  $_SERVER['FULL_URL'] .=  's';
}
$_SERVER['FULL_URL'] .=  '://';
if($_SERVER['SERVER_PORT']!='80')
  $_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'];
else
  $_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
if($_SERVER['QUERY_STRING']>' ')
{
  $_SERVER['FULL_URL'] .=  '?'.$_SERVER['QUERY_STRING'];
}

$blogurl = $_SERVER['FULL_URL'];
$blogtitle = $pagetitle;
$content .= getBookmarkHTML($blogurl, $blogtitle, "&nbsp;","small");
$content .= "</center>";
?>
