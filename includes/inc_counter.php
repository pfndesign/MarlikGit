<?php
/**
*
* @package inc_counter														
* @version $Id: 2:38 AM 12/18/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
if (stristr($_SERVER['PHP_SELF'], "inc_counter.php")) {
    Header("Location: index.php");
    die();
}


// YOU CAN EVEN TURN OFF THIS TRACKING SYSTEM BY DEFINING FALSE VALUE INTO COUNTER_ENABLED
define('COUNTER_ENABELED',true);

//===========================================
// TRACKING SYSTEM
//===========================================
if (COUNTER_ENABELED == true) {
require_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."admin/modules/tracking/tracking.php");
}

//===========================================
// POINT SYSTEM
//===========================================
global $user;
if (is_user($user)) {
update_points(13);//update points for page visits
}
