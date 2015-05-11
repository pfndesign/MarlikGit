<?php


/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV MarlikCMS PORTAL																|
	|	* @version : 1.0.0.399																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.MarlikCMS.com																	|
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
if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}

switch($op) {
    case "Tags":
    include("admin/modules/tags.php");
    break;

}

?>
