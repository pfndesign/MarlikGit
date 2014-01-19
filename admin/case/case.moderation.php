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
	|	* Copyright (c) 2005 - 2006 by http://www.irannuke.net										|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }


if (!defined('ADMIN_FILE')) {

	die ("Access Denied");

}



switch($op) {

    case "moderation":

    case "moderation_news":

    case "moderation_news_view":

    case "moderation_surveys":

    case "moderation_surveys_view":

    case "moderation_reviews":

    case "moderation_reviews_view":

    case "moderation_users_list":

	case "moderation_approval":

	case "moderation_reject":

/*|	----patch 3 www.nukelearn.com----Aneeshtan---|*/
	case "moderation_mc_view":

    @include("admin/modules/moderation.php");

    break;



}



?>