<?php
/**
*
* @package inc_errors														
* @version $Id: 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

global $sentineladmin;
if (file_exists("install.php")){$errorCont .=""._ERROR_INSTALL2."<br>"; }
if (file_exists("INSTALLATION")){$errorCont .=""._ERROR_INSTALL."<br>"; }
if (file_exists("config.php") && is_writeable("config.php")) { $errorCont .=""._ERROR_CONFIG."<br>";}
if (file_exists("upgrade.php")){  $errorCont .=""._ERROR_UPGRADE."<br> ";}
if (ini_get('register_globals'))  {  $errorCont .=""._ERROR_REGISTERGLOBALS."<br>";}
$currentDomain = getenv("HTTP_HOST");
//===========================================
//Sentinel Script
//===========================================
if (defined('ADMIN_FILE')) {
if($sentineladmin > 0) {
	$errorCont .= "<p><img src='images/Guardian/inactive.png' alt='"._SITE_CLOSED."' title='"._SITE_CLOSED."'>"._SITE_CLOSED."</p>";

}
}


	if (!empty($errorCont) AND $currentDomain != "localhost" ) {
		echo "
		<center>
		<div class='error' style='text-align:".langStyle(align).";'>"._ERROR_DANGERS."$errorCont</div>
		</center>
		";

	}



 		?>