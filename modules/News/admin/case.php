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
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

$module_name = "News";
include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");

switch($op) {

    case "YesDelCategory":
    case "subdelete":
    case "DelCategory":
    case "NoMoveCategory":
    case "EditCategory":
    case "SaveEditCategory":
    case "AddCategory":
    case "SaveCategory":
    case "DisplayStory":
    case "PreviewAgain":
    case "PostStory":
    case "EditStory":
    case "RemoveStory":
    case "ChangeStory":
    case "DeleteStory":
    case "adminStory":
    case "PreviewAdminStory":
    case "PostAdminStory":
    case "autoDelete":
    case "autoEdit":
    case "autoSaveEdit":
    case "submissions":
    case "DeleteNewsPicture":
    case "ShowNewsPanel":
    case "multi_task":
    case "q_editstory":
    case "autosave":
    case "save_q_t_a":
    	
    include("modules/$module_name/admin/index.php");
    break;

}

?>