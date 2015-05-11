<?php
/**
*
* @package Tree MENU														
* @version $Id: config section RC-7 11:49 AM 1/2/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

  
$treeManager = NULL;
define("INSIDE_MOD",true);
require_once(''.MODS_PATH.'treemenu/includes/classes/Mysql.php');
require_once('config.php');
require_once(''.MODS_PATH.'treemenu/includes/config.php');
require_once(''.MODS_PATH.'treemenu/includes/functions.php');
require_once(''.MODS_PATH.'treemenu/includes/classes/DBTreeManager.php');
//-----------------------------------LETS CONNECT TO DATABASE ONCE AGAIN ----------------------------------------------------
global $treeManager,$dbhost,$dbuname,$dbpass,$dbname;
$mdb = new MySQL("$dbhost","$dbuname","$dbpass","$dbname");
$treeManager = new DBTreeManager($mdb);

?>