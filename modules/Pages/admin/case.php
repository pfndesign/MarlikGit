<?php
/**
*
* @package Extra Page														
* @version $Id: page.php 12:43 PM 3/5/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined("ADMIN_FILE")) {show_error(HACKING_ATTEMPT);}
if (!defined("USV_VERSION")) {die("This only works on Nukelearn Portal , So why don't join us<br>http://www.nukelearn.com");}
switch($op) {

    case "extpage":
    case "add_ep":
    case "del_ep":
    case "edit_ep":
    case "sedit_ep":
	case "add_extpage":
	case "ep_slug_title":
	case "change_status":
	case "quick_delete":
	case "quick_edit":
	
    include("modules/Pages/admin/index.php");
    break;

}

?>