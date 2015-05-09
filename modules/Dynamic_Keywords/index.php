<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV NUKELEARN PORTAL																|
	|	* @version : 1.0.0.599																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.nukelearn.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|	/* http://slaytanic.sourceforge.net															|
	|	 Copyright (c) 2006-2008 Jonathan Estrella  												|	
	|	 Translate to Persian by Kralpc.com	       													|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/
require_once('mainfile.php');
global $admin, $admin_file,$currentlang;

if(file_exists("modules/Dynamic_Keywords/language/lang-".$currentlang.".php")) {
	include("modules/Dynamic_Keywords/language/lang-".$currentlang.".php");
} else {
	include("modules/Dynamic_Keywords/language/lang-english.php");
}
if(is_admin($admin)) {
	header('Refresh: 7, '.$admin_file.'.php?op=MetaConfig');
	include('header.php');
	OpenTable();
	echo "<center>"._DK_INDEX1."<br />";
	echo ""._DK_INDEX2."<br /><br />";
	echo ""._DK_INDEX3."</center>";
	CloseTable();
	include('footer.php');
} else {
	header('Refresh: 5, index.php');
	include('header.php');
	OpenTable();
	echo "<center>"._DK_INDEX4."<br />";
	echo ""._DK_INDEX5."</center>";
	CloseTable();
	include('footer.php');
}
?>