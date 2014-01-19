<?php
/********************************************************/
/* Site Admin Backup & Optimize Module for PHP-Nuke     */
/* Version 1.0.0         10-24-04                       */
/* By: Telli (telli@codezwiz.com)                       */
/* http://codezwiz.com/                                 */
/* Copyright © 2000-2004 by Codezwiz                    */
/********************************************************/
define("_OPTIMIZEEXPLAIN","<b>OPTIMIZE</b><br>should be used if you have deleted a large part of a table or if you have made many changes to a table with variable-length rows (tables that have VARCHAR, BLOB, or TEXT columns). Deleted records are maintained in a linked list and subsequent INSERT operations reuse old record positions. You can use OPTIMIZE to reclaim the unused space and to defragment the datafile.<br>
In most setups you don\'t have to run OPTIMIZE at all. Even if you do a lot of updates to variable length rows it's not likely that you need to do this more than once a month/week and only on certain tables.<br>
OPTIMIZE works the following way:<ul>
<li>If the table has deleted or split rows, repair the table.
<li>If the index pages are not sorted, sort them.
<li>If the statistics are not up to date (and the repair couldn't be done by sorting the index), update them.
</ul>Note that the table is locked during the time OPTIMIZE is running!");
define("_SELECTFILETOIMPORT","Select a SQL/GZip file to restore/add into the database");
define("_STARTSQL","Submit");
define("_MENU","Menu");

define("_USECOMPRESSION","Use Compression");
define("_INCLUDEDROPSTATEMENT","Include Drop Statement");
define("_FORBACKUPONLY","For Back-up Only");
define("_STATUS","Status");
define("_REPAIR","Repair");
define("_ANALYZE","Analyze");
define("_CHECK","Check");
define("_OPTIMIZE","Optimize");
define("_BACKUP","Back Up Database");
define("_CHECKALL","Select All");
define("_UNCHECKALL","Unselect All");
define("_DATABASEMANAGE","Manage Mysql Database(s)");
define("_TABLES","DB Table(s)");
define("_NOTABLESFOUND","No tables found in database.");
define("_DATABASE","Database ");
define("_TABLESTRUCTURE","Table structure for table");
define("_DUMPINGTABLE","Dumping data for table");
define("_ERROR","Error");
define("_SQLQUERY","Sql Query");
define("_MYSQLSAID","MySQL said");
define("_ACTION","Action");
define("_DONE","On");
define("_AT","at");
define("_BY","by");
define("_FINISHEDADDING","Finished adding");
define("_TOTHEDB","to the database.");
define("_ERRORCANTDECOMPRESS","ERROR Can't decompress the file");
?>