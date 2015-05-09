<?php

/**
*
* @package NEWS														
* @version  $Id:  $ 2:12 AM 12/25/2009	$Aneeshtan					
* @copyright (c)Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}


global $prefix, $db,$aid,$admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='News'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
	if ($row2['name'] == "$admins[$i]" AND !empty($row['admins'])) {
		$auth_user = 1;
	}
}

adminmenu("".$admin_file.".php?op=ShowNewsPanel", ""._SHOW_NEWSPANE."", "stories.png");
if ($auth_user == 1) {
adminmenu("".$admin_file.".php?op=moderation_news", ""._MOSHAKHASEYESYSTEMEMODIRIYAT."", "moderation.png");
}


?>