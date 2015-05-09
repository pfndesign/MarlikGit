<?php
/**
*
* @package Extra Page														
* @version $Id: page.php 12:43 PM 3/5/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

require_once("mainfile.php");
require_once(MODULES_PATH."Pages/class.expages.php");
define("blocks_show",false);
if (!defined("USV_VERSION")) {die("This only works on Nukelearn Portal , So why don't You join us<br>http://www.nukelearn.com");}
$cls_page = new expage();
$cls_page->Page_Directory("50","order by pid DESC");

?>