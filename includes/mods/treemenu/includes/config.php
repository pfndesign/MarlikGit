<?php
/**************************************
 *   File Name: config.php
 *   Begin: Thursday, June, 06, 2006
 *   Author: Ahmet Oguz Mermerkaya 	
 *   Email: ahmetmermerkaya@hotmail.com
 ***************************************/ 

if (!defined("IN_PHP"))
{
	die();
}
/** target platform types
 *  this script runs for both database(mysql) and file system. 
 *  database is supposed to be mysql
 */
define ("DATABASE_PLATFORM", 0); // Don't edit
define ("FILE_SYSTEM_PLATFORM", 1); // Don't edit
/** 
 * choose target platform according to your needs 
 * it may be DATABASE_PLATFORM or FILE_SYSTEM_PLATFORM
 */
 global $prefix;
 
 $prefix = (empty($prefix) ? "nuke" :  "".$prefix."");
 
define ("TARGET_PLATFORM", DATABASE_PLATFORM);

if (TARGET_PLATFORM == DATABASE_PLATFORM)
{
	define ("TREE_TABLE_PREFIX", "".$prefix."_tree");
}
else {
	die("No known target platform specified, in includes/config.php");
}
define ("SUCCESS", 1);  // Don't edit
define ("FAILED", -1);  // Don't edit
define ("FAILED_FILE_WITH_SAME_NAME_EXIST", -2); // Don't edit, it is only used in FILE_SYSTEM_PLATFORM

?>