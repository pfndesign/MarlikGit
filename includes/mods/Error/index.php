<?php
/**
*
* @package ERRORS														
* @version $Id: 8:00 PM 3/10/2010  Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
*
* 
*/
require_once("mainfile.php");
define("ERROR_PATH","includes/mods/Error/includes/");
define("SITE_INCLUDED",1);
define("blocks_show",false);
function template_error($page){
global $sitename,$adminmail,$nukeurl;
	$page = sql_quote($page);
	$tmpl_file = ERROR_PATH."$page.html";

	if (!file_exists($tmpl_file)) {
	if (is_admin($admin)) {
	show_error( ' If you are the administrator , plz concider changing this error page by  editing or creating '.$page.'.html in Errors include folder');
	}else {
	header("Location: modules.php?app=mod&name=Error&op=show&page=404");
	}
	}
	$thefile = implode("", file($tmpl_file));
	$thefile = addslashes($thefile);
	$thefile = "\$r_file=\"".$thefile."\";";
	eval($thefile);
	print $r_file;

}
function show($page) {
$pagetitle = "$page Error";	
if (SITE_INCLUDED == 1) {
	include("header.php");
	template_error($page);
	include("footer.php");
	
}else {
    echo "<title>$sitename $pagetitle</title>\n";
	template_error($page);
}
}
$page = $_REQUEST['page'];
$page = sql_quote($page);
$page = (empty($page) ? "404" : $page);
die(show($page));
?>