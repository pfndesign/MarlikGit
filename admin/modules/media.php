<?php
/**
*
* @package Media center														
* @version $Id: Media.php 9:15 PM 1/5/2011 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined("ADMIN_FILE")) {show_error(HACKING_ATTEMPT);}
global $prefix,$currentlang,$db, $admin_file;
if (!defined("USV_VERSION")) {die("This only works on MarlikCMS Portal ,
<br>So why don't You join us<br><a href='http://www.MarlikCMS.com'>MarlikCMS.com</a>");
}
$editorlang = ($currentlang == "persian" ? "fa" : "en");

include("header.php");
GraphicAdmin();

if (is_superadmin($admin)) {
	define("FILE_MANAGER_BASE_URL","includes/elfinder/") ;
	OpenTable();
	echo "<h3><img src='images/admin/media.png' title='"._MEDIA_PANEL."' >"._MEDIA_PANEL."</h3>";
	CloseTable();
	OpenTable();
?>
	<link rel="stylesheet" href="<?php echo FILE_MANAGER_BASE_URL;?>css/jquery-ui.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo FILE_MANAGER_BASE_URL;?>css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo FILE_MANAGER_BASE_URL;?>css/theme.css">
		<script src="<?php echo FILE_MANAGER_BASE_URL;?>js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo FILE_MANAGER_BASE_URL;?>js/elfinder.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo FILE_MANAGER_BASE_URL;?>js/i18n/elfinder.fa.js" type="text/javascript" charset="utf-8"></script>		
<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		var elf = $('#elfinder').elfinder({
			url : '<?php echo FILE_MANAGER_BASE_URL;?>php/connector.php',
			lang : '<?PHP echo $editorlang?>',
		}).elfinder('instance');			
	});
</script>

	<style type="text/css">
#elfinder{background:#F5F6F7;color:#000;font:13px tahoma;}
	</style>
<div id="elfinder"></div>
<?php

}
CloseTable();
include("footer.php");
?>