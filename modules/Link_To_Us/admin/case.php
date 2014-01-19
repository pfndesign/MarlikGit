<?php
/**
*
* @package RSS Feed Class														
* @version $Id: $Kralpc --  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) http://codezwiz.com/  	Revised :  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!defined('ADMIN_FILE')) {
    die('Access Denied');
}

$module_name = basename(dirname(dirname(__FILE__)));

switch ($op) {

    case "linktous_config":
    case "resources":
    case "resswf":
    case "resswfadd":
    case "resadd":
    case "resdel":
    case "resedit":
    case "ressave":
    case "mylinks":
    case "mylinksadd":
    case "mylinksswf":
    case "mylinksswfadd":
    case "mylinksdel":
    case "mylinksedit":
    case "mylinkssave":
    case "zipset":
    case "zipsetadd":
    case "zipsetedit":
    case "zipsetsave":
    case "linktous_install":
    case "linktousconfigsave":
      include_once("modules/".$module_name."/admin/index.php");
      break;

}

?>