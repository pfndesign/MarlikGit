<?php
/**
*
* @package FireWall												
* @version $Id: Media.php 12:42 PM 2/10/2012 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined("ADMIN_FILE")) {show_error(HACKING_ATTEMPT);}
if (!defined("USV_VERSION")) {die("This only works on Nukelearn Portal ,
<br>So why don't You join us<br><a href='http://www.nukelearn.com'>nukelearn.com</a>");
}


switch($op) {

    case "firewall":
    @include("admin/modules/firewall.php");
    break;

}

?>