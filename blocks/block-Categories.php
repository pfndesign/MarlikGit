<?php

/**
*
* @package Ajax Treeview Of Categories												
* @version $Id:  2:34 AM 5/21/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
*
*/


if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $currentlang, $prefix,$nextg;
define("TOPIC_TABLE","".$prefix."_topics");
require_once("includes/inc_menuBuilder.php");

$menu = new MenuBuilder();
/*---------------MENU CONFIG -----------*/
$sql = 'select * from '.TOPIC_TABLE.' order by topicname,parent asc';
$column_ID = 'topicid';
$column_TITLE = 'topicname';
$column_parent = 'parent';
$ui_id = 'categories';
/*--------------------------------------*/
$content = $menu->get_menu_data($sql,$link,$column_ID,$column_parent,$column_TITLE,$ui_id);
$content = $menu->get_menu_html(0);


$content .= '
	<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview'.($currentlang=="persian" ? ".rtl" : "").'.css" />
	<script src="modules/Topics/includes/jquery.treeview.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#categories").treeview({
			animated: "fast",
			persist: "location",
			collapsed: true,
			unique: true
		});
	});
	</script>
	';

?>