<?php

/**
*
* @package DB														
* @version $Id: DB 1.1.4 						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (stristr($_SERVER['PHP_SELF'], "db.php")) {
    Header("Location: index.php");
    die();
}

if (defined('FORUM_ADMIN')) {
    define("CORE_INCLUSION","../../../");
} elseif (defined('INSIDE_MOD')) {
    define("CORE_INCLUSION","../../");
} elseif (defined('BRIDGE_MOD')) {
    define("CORE_INCLUSION","../");
} else {
    define("CORE_INCLUSION","./");
}

switch($dbtype) {

	case 'MySQL':
		include(CORE_INCLUSION."db/mysql.php");
		break;

	case 'mysql4':
		include(CORE_INCLUSION."db/mysql4.php");
		break;

	case 'sqlite':
		include(CORE_INCLUSION."db/sqlite.php");
		break;

	case 'postgres':
		include(CORE_INCLUSION."db/postgres7.php");
		break;

	case 'mssql':
		include(CORE_INCLUSION."db/mssql.php");
		break;

	case 'oracle':
		include(CORE_INCLUSION."db/oracle.php");
		break;

	case 'msaccess':
		include(CORE_INCLUSION."db/msaccess.php");
		break;

	case 'mssql-odbc':
		include(CORE_INCLUSION."db/mssql-odbc.php");
		break;
	
	case 'db2':
		include(CORE_INCLUSION."db/db2.php");
		break;

}


$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
if(!$db->db_connect_id || !file_exists(CORE_INCLUSION."config.php")) {
if (!defined('INSTALLATION_FILE')) {
?><style type="text/css">p.error {font-size: 90%;font-weight: bold;}#bd .error, #bd .warning, #bd .info, #bd .message {border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; font-weight: normal; padding: 10px !important; margin: 10px 0 !important; clear: both;}#bd .error {background:#FDD; border:1px solid #FBB;}</style><?php
	if (file_exists(CORE_INCLUSION."install.php")) {
		die("<div id='bd'  class=\"error\"><p class=\"error\"><a href='http://www.MarlikCMS.com'>MarlikCMS CMS</a><br><br>
		<img src='images/icon/exclamation.png' title='Attention' alt='Attention'><b>It seems CMS is not installed yet OR Database is empty . Please install the portal.</b><br><br><font size='5px' color='blue'><a href='install.php' ><b>INSTALL</b></a></font><br> <a href='install.php' > INSTALL NOW </a><br><br>More @ : DATABASE : $dbname</p><div>");
	} else {
		die("<div id='bd'  class=\"error\"><p class=\"error\"><a href='http://www.MarlikCMS.com'>MarlikCMS CMS</a><br><br>
		<img src='images/icon/exclamation.png' title='Attention' alt='Attention'><b>Attention:</b>It seems CMS is not installed yet OR Database is empty . Please install the portal.<br><br>More @ :  : DATABASE : $dbname<br><br>Install File is Absent</p><div>");
	}
}
}


?>