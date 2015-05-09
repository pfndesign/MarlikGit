<?php
/**
 *
 * @package BAN IPS														
 * @version  ipban.php $Id: Aneeshtan  7:55 PM 5/9/2011					
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "ipban.php" )) {
	show_error ( HACKING_ATTEMPT );
}

global $prefix, $db;
$ip = $_SERVER['REMOTE_ADDR'];
$result = $db->sql_query("SELECT `ip_address`,`reason`,`date` FROM ".$prefix."_banned_ip WHERE `ip_address`='$ip'");
list($ip_address,$ip_reason,$date) = $db->sql_fetchrow($result);
if (!empty($ip_address)) {
	show_error("<img src='images/admin/ipban.gif'>"._BANNED." | $sitename<br>
	"._IP."  : <b>$ip_address</b> <br>
	"._REASON." : <b>$ip_reason</b><br>
	"._DATE." : <b>$date</b><br>");
}
$db->sql_freeresult($result);
?>