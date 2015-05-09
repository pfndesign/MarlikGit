<?php


/**
*
* @package log system														
* @version $Id: cass.logs.php 11:56 AM 12/25/2009 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}

switch($op) {
    case "Logs":
    include("admin/modules/logs.php");
    break;

}

?>
