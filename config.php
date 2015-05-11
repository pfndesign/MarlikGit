<?php 



/**
*
* @package config file														
* @version $Id: RC-7 FINAL $ 2:12 AM 12/25/2009						
* @copyright (c)Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (stristr(htmlentities($_SERVER["PHP_SELF"]), "config.php")) {Header("Location: config.php"); show_error(HACKING_ATTEMPT);}

//-----------------------------------------------------------------------

$dbhost = "localhost"; 
$dbuname = "root";  // Database username
$dbpass = "root";	// Database password
$dbname = "usv61";	// Database NAME

//-----------------------------------------------------------------------
$dbtype = "MySQL";
//-----------------------------------------------------------------------
$prefix = "nuke";
$user_prefix = "nuke";
$nuke_prefix = "nuke_";
//-----------------------------------------------------------------------
$display_errors = true; // Debug System 
define("BENCHMARK",false);//benchmark SYSTEM
//-----------------------------------------------------------------------
$tipath = "images/topics/";
$admin_file = "admin";
$ThemeDef = "Par";
$sitekey = "85b636867d8baf543fc8ba9bce3ce49f-Tigris_1_1_6-usv61";
define("USV_DOMAIN", "http://localhost/usv61");
//-----------------------------------------------------------------------

?>