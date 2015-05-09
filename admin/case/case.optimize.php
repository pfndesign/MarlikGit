<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV NUKELEARN PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.nukelearn.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|	* Copyright (c) 2005 - 2006 by http://www.irannuke.net										|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}

switch($op) {

    case "optimize":
    @include("admin/modules/optimize.php");
    break;
 
}

?>