<?php

/**
*
* @package Ajax Treeview Of Main Menu												
* @version $Id:  2:34 AM 5/21/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}
global $currentlang,$prefix;
define("TREE_MENU_TABLE","".$prefix."_tree_elements");
require_once("includes/inc_menuBuilder.php");

$menu = new MenuBuilder();
$sql = 'select * from '.TREE_MENU_TABLE.' order by ownerEl,position asc';
$column_ID = 'Id';
$column_TITLE = 'name';
$column_parent = 'ownerEl';
$ui_id = 'main_menu';

$content .= $menu->get_menu_data($sql,$link,$column_ID,$column_parent,$column_TITLE,$ui_id);
$content .= $menu->get_menu_html(0);

$content .= '
	<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview'.($currentlang=="persian" ? ".rtl" : "").'.css" />
	<script src="modules/Topics/includes/jquery.treeview.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#'.$ui_id.'").treeview({
			animated: "fast",
			persist: "location",
			collapsed: false,
			control:"#ecmenu",
			unique: false
		});
	});
	</script>
';
	?>