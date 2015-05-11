<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV MarlikCMS PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.MarlikCMS.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|	* Copyright (c) 2005 - 2006 by http://www.irannuke.net										|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

global $db;

$aid = trim($aid);
$result = $db->sql_query("select name, radminsuper from ".$prefix."_authors where aid='$aid'");
list($name, $radminsuper) = $db->sql_fetchrow($result);

if (!$radminsuper == 1) { die ("Access Denied"); }

function czd_get_lang($module) {
    global $currentlang, $language;
		if (file_exists("language/CZDatabase/lang-$currentlang.php")) {
			include_once("language/CZDatabase/lang-$currentlang.php");
		} else {
			include_once("language/CZDatabase/lang-persian.php");
		}
}
czd_get_lang(admin);

// Dont mess with my work please
function Showdbcc() {
    echo "<br />";

}

switch($op) {
    
    case "BackupDB":
        global $gzip;
        @set_time_limit(600);
        $crlf="\n"; 
        $czdate = date ("m-d-Y");        
        $filename = $dbname."_".$czdate.".sql";
        $do_gzip_compress = ($gzip == 1);
        if($do_gzip_compress) {
           @ob_start();
           @ob_implicit_flush(0);
           header("Content-Type: application/x-gzip; name=\"$filename.gz\"");
           header("Content-disposition: attachment; filename=$filename.gz");
        } else {
           header("Content-Type: text/x-delimtext; name=\"$filename\"");
           header("Content-disposition: attachment; filename=$filename");
        }
        $client = $_SERVER["HTTP_USER_AGENT"];
        if(ereg('[^(]*\((.*)\)[^)]*',$client,$regs)) {
        $os = $regs[1];
        if (eregi("Win",$os)) $crlf="\r\n"; }

        function my_handler($sql_insert) {
            global $crlf;
            echo "$sql_insert;$crlf";
        }
        
        //Get the content of $table as a series of INSERT statements.
        //After every row, a custom callback function $handler gets called.
        //$handler must accept one parameter ($sql_insert);
        function get_table_content($db, $table, $handler) {
            $result = $db->sql_query("SELECT * FROM $table") or mysql_die();
            $i = 0;
            while($row = mysql_fetch_row($result))
            {
                $table_list = "(";
        
                for($j=0; $j<mysql_num_fields($result);$j++)
                    $table_list .= mysql_field_name($result,$j).", ";
        
                $table_list = substr($table_list,0,-2);
                $table_list .= ")";
        
                if(isset($GLOBALS["showcolumns"]))
                    $schema_insert = "INSERT INTO `$table` $table_list VALUES (";
                else
                    $schema_insert = "INSERT INTO `$table` VALUES (";
        
                for($j=0; $j<mysql_num_fields($result);$j++)
                {
                    if(!isset($row[$j]))
                        $schema_insert .= " NULL,";
                    elseif($row[$j] != "")
                        $schema_insert .= " '".addslashes($row[$j])."',";
                    else
                        $schema_insert .= " '',";
                }
                $schema_insert = preg_match("/,$/", "", $schema_insert);
                $schema_insert .= ")";
                $handler(trim($schema_insert));
                $i++;
            }
            return (true);
        }
        
        // Return $table's CREATE definition
        // Returns a string containing the CREATE statement on success
        function get_table_def($db, $table, $crlf) {
            $schema_create = "";
            global $drop;
            if ($drop == 1) {
                $schema_create .= "DROP TABLE IF EXISTS `$table`;$crlf";
            }
            $schema_create .= "CREATE TABLE `$table` ($crlf";
        
            $result = mysql_db_query($db, "SHOW FIELDS FROM $table") or mysql_die();
            while($row = mysql_fetch_array($result))
            {
                $schema_create .= "   `$row[Field]` $row[Type]";
        
                if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0"))
                    $schema_create .= " DEFAULT '$row[Default]'";
                if($row["Null"] != "YES")
                    $schema_create .= " NOT NULL";
                if($row["Extra"] != "")
                    $schema_create .= " $row[Extra]";
                $schema_create .= ",$crlf";
            }
            $schema_create = preg_match("/,".$crlf."$/", "", $schema_create);
            $result = mysql_db_query($db, "SHOW KEYS FROM $table") or mysql_die();
            while($row = mysql_fetch_array($result))
            {
                $kname=$row['Key_name'];
                if (($kname != "PRIMARY") && ($row['Non_unique'] == 0))
                    $kname="UNIQUE|$kname";
                if ($row['Index_type'] == "FULLTEXT")
                    $kname="FULLTEXT|$kname";
                if (!isset($index[$kname]))
                     $index[$kname] = array();
                 $index[$kname][] = $row['Column_name'];
            }
        
            while(list($x, $columns) = @each($index))
            {
                 $schema_create .= ",$crlf";
                 if($x == "PRIMARY")
                     $schema_create .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
                 elseif (substr($x,0,6) == "UNIQUE")
                    $schema_create .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
                 elseif (substr($x,0,8) == "FULLTEXT")
                    $schema_create .= "   FULLTEXT ".substr($x,9)." (" . implode($columns, ", ") . ")";
                 else
                    $schema_create .= "   KEY `$x` (" . implode($columns, ", ") . ")";
            }
        
            $schema_create .= "$crlf) ENGINE=MyISAM   DEFAULT CHARSET=utf8 COLLATE=utf8_bin ;";
            return (stripslashes($schema_create));
        }
        
        function mysql_die($error = "")
        {
            echo "<b> "._ERROR." </b><p>";
            if(isset($sql_query) && !empty($sql_query))
            {
                echo ""._SQLQUERY.": <pre>$sql_query</pre><p>";
            }
            if(empty($error))
                echo ""._MYSQLSAID.": mysql_error()";
            else
                echo ""._MYSQLSAID.": $error";
            echo "<br />"._GOBACK."";
            exit;
        }
        
        global $dbhost, $dbuname, $dbpass, $db, $tablelist;
        mysql_pconnect($dbhost, $dbuname, $dbpass);
        @mysql_select_db("$dbname") or die ("Unable to select database");
        
        if (is_array($tablelist) && count($tablelist) > 0) {
            $tables = $tablelist;
            $num_tables = count($tablelist);
        } else {
            $tablelist = mysql_list_tables($dbname);
            $num_tables = @mysql_numrows($tablelist);
            if($num_tables > 0) for ($i = 0; $i < $num_tables; $i++) {
                $tables[] = mysql_tablename($tablelist, $i);
            }
        }
        
        if($num_tables == 0)
        {
            echo ""._NOTABLESFOUND."";
        }
        else
        {
            $i = 0;
            $czdate2 = date ("H:i");
            print "# ========================================================$crlf";
            print "#$crlf";
            print "# "._DATABASE.": $dbname$crlf";
            print "# "._DONE." $czdate "._AT." $czdate2 "._BY." $name !$crlf";
            print "#$crlf";
            print "# ========================================================$crlf";
            print "$crlf";
            
            foreach($tables AS $table)
            { 
                print $crlf;
                print "# --------------------------------------------------------$crlf";
                print "#$crlf";
                print "# "._TABLESTRUCTURE." '$table'$crlf";
                print "#$crlf";
                print $crlf;
        
                echo get_table_def($dbname, $table, $crlf).";$crlf$crlf";
                
            print "#$crlf";
            print "# "._DUMPINGTABLE." '$table'$crlf";
            print "#$crlf";
            print $crlf;
            
            get_table_content($db, $table, "my_handler");
            }
        }
        exit;
        break;
        
    case "database":
        include("header.php");
        ADMIN_PANE();
        title(""._MENU."");
        OpenTable();
        echo "<center><font class=\"title\"><b>"._DATABASEMANAGE."</b></font></center>";
        CloseTable();
        echo "<br>";
        OpenTable();
        echo "<SCRIPT LANGUAGE=\"JavaScript\">
        <!--
        function setSelectOptions(the_form, the_select, do_check)
        {
        var selectObject = document.forms[the_form].elements[the_select];
        var selectCount  = selectObject.length;

        for (var i = 0; i < selectCount; i++) {
        selectObject.options[i].selected = do_check;
        } // end for

        return true;
        } // end of the 'setSelectOptions()' function
        //  End -->
        </script>";
        echo "<form method=\"post\" name=\"backup\" action=\"".ADMIN_PHP."\">";
        echo "<table><tr>";
        echo "<td><SELECT NAME=\"tablelist[]\" size=\"20\" multiple>";
        $tables = mysql_list_tables($dbname);
        for ($i = 0; $i < mysql_num_rows($tables); $i++) {
            $table = mysql_tablename($tables, $i);
            echo "<OPTION VALUE=\"$table\">$table</OPTION>";
        }
        mysql_free_result($result);
        echo "</SELECT><br /><br /><center>";
        echo "<a href=\"javascript:void(0);\" onclick=\"setSelectOptions('backup', 'tablelist[]', true); return false;\">";
        echo "<b>"._CHECKALL."</b></a>&nbsp;|&nbsp;";
        echo "<a href=\"javascript:void(0);\" onclick=\"setSelectOptions('backup', 'tablelist[]', false); return false;\"><b>"._UNCHECKALL."</b></a></center></td>";
        echo "<td>"._ACTION.":<br><SELECT NAME=\"op\">"
            ."<OPTION VALUE=\"BackupDB\">"._BACKUP."</OPTION>"
            ."<OPTION VALUE=\"OptimizeDB\">"._OPTIMIZE."</OPTION>"
            ."<OPTION VALUE=\"CheckDB\">"._CHECK."</OPTION>"
            ."<OPTION VALUE=\"AnalyzeDB\">"._ANALYZE."</OPTION>"
            ."<OPTION VALUE=\"RepairDB\">"._REPAIR."</OPTION>"
            //."<OPTION VALUE=\"StatusDB\">"._STATUS."</OPTION>"
            ."</SELECT>"
            ."<br /><br />"._FORBACKUPONLY.":<br /><input type=\"checkbox\" value=\"1\" NAME=\"drop\">"
            ."&nbsp;"._INCLUDEDROPSTATEMENT."<br />"
            ."<input type=\"checkbox\" value=\"1\" NAME=\"gzip\">&nbsp;"._USECOMPRESSION."<br /><br />";
        echo "<input type=\"submit\" value=\""._GO."\"></td><td width=\"50%\" valign=\"top\">";
        OpenTable2();
        echo ""._OPTIMIZEEXPLAIN."";
        CloseTable2();
        echo "</td></tr></table></form>";
        CloseTable();
      echo "<br>";
       OpenTable();
             echo "<form ENCTYPE=\"multipart/form-data\" method=\"post\" action=\"".ADMIN_PHP."\" name=\"restore\">";
 echo ""._SELECTFILETOIMPORT."<br />";
echo "<input type=\"file\" name=\"sqlfile\" size=80>";
 echo "&nbsp;&nbsp;<input type=\"hidden\" name=\"op\" value=\"RestoreDB\">";
   echo "<input type=\"submit\" value=\""._STARTSQL."\">";
    echo "</form>";
      CloseTable();
       Showdbcc();
        include("footer.php");
        break;

    case "OptimizeDB":
    case "CheckDB":
    case "AnalyzeDB":
    case "RepairDB":
    case "StatusDB":
        $type = strtoupper(substr($op,0,-2));
        include ("header.php");
        title(""._MENU."");
        OpenTable();
        echo "<center><font class=\"title\"><b>$type "._TABLES."</b></font></center>";
        CloseTable();
        echo "<br>";
        OpenTable();
        global $dbhost, $dbuname, $dbpass, $dbname, $tablelist;
        mysql_pconnect($dbhost, $dbuname, $dbpass);
        @mysql_select_db("$dbname") or die ("Unable to select database");

        if (is_array($tablelist) && count($tablelist) > 0) {
            $tables = $tablelist;
            $num_tables = count($tablelist);
        } else {
            $tablelist = mysql_list_tables($dbname);
            $num_tables = @mysql_numrows($tablelist);
            if($num_tables > 0) for ($i = 0; $i < $num_tables; $i++) {
                $tables[] = mysql_tablename($tablelist, $i);
            }
        }

        if ($num_tables > 0) {
            if ($type == "STATUS") {
                $query = 'SHOW TABLE STATUS FROM '.$dbname;
            } else {
            $query = "$type TABLE ";
            foreach($tables AS $table) {
                if ($query != "$type TABLE ") $query .= ", ";
                $query .= $table;
            }
        }

            $result = mysql_query($query);

            $numfields = mysql_num_fields($result);
            echo "<table width=\"100%\" border=\"0\" bgcolor=\"$textcolor1\" cellspacing=\"1\" cellpadding=\"2\"><tr bgcolor=\"$bgcolor2\">";
            for($j=0; $j<$numfields;$j++) {
                echo "<td align=\"center\"><b>".mysql_field_name($result,$j)."</b></td>";
            }
            echo "</tr>";
            while($row = mysql_fetch_row($result)) {
                echo "<tr bgcolor=\"$bgcolor2\">";
                for($j=0; $j<$numfields;$j++) {
                    echo "<td>".$row[$j]."</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        CloseTable();
        Showdbcc();
        include("footer.php");
        break;
            
    case "RestoreDB":
        include("header.php");
        include("includes/sql_parse.php");
        $sqlfile_tmpname = $HTTP_POST_FILES['sqlfile']['tmp_name'];
        $sqlfile_name = $HTTP_POST_FILES['sqlfile']['name'];
        $sqlfile_type = (!empty($HTTP_POST_FILES['sqlfile']['type'])) ? $HTTP_POST_FILES['sqlfile']['type'] : "";
              if ($sqlfile_tmpname == '' || $sqlfile_name == '') { echo  OpenTable();echo""._NOINPUT."<br />"._GOBACK."";CloseTable();include("footer.php");}
        if( (substr($sqlfile_name, -4) == ".sql") || (substr($sqlfile_name, -4) == ".zip") || (substr($sqlfile_name, -4) == ".gz") )
        {
            if( preg_match("/\.gz$/i",$sqlfile_name) )
            {
                $do_gzip_compress = FALSE;
                $phpver = phpversion();
                if($phpver >= "4.0")
                {
                    if(extension_loaded("zlib"))
                    {
                        $do_gzip_compress = TRUE;
                    }
                }

                if($do_gzip_compress)
                {
                    $gz_ptr = gzopen($sqlfile_tmpname, 'rb');
                    $sql_query = "";
                    while( !gzeof($gz_ptr) )
                    {
                        $sql_query .= gzgets($gz_ptr, 100000);
                    }
                }
                else
                {
                    die(""._ERRORCANTDECOMPRESS."");
                }
            }
            else
            {
                $sql_query = fread(fopen($sqlfile_tmpname, 'r'), filesize($sqlfile_tmpname));
            }
        }
        else {
            die("ERROR filename incorrect $sqlfile_type <b>$sqlfile_name</b>");
        }

        if($sql_query != "")
        {
            $sql_query = remove_remarks($sql_query);
            $pieces = split_sql_file($sql_query, ";\n");

            foreach($pieces AS $query) {
                set_time_limit(30);
                $db->sql_query($query);
            }
        }
        title(""._MENU."");
        OpenTable();
        echo "<font class=\"option\">"._FINISHEDADDING." $sqlfile_name "._TOTHEDB." <br />"._GOBACK."</font>";
        CloseTable();
        Showdbcc();
       include("footer.php");
        break;
}

?>