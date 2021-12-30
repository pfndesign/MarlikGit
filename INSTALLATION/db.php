<?php

include('../db/mysql.php');

$con = new sql_db($DB_SERVER, $DB_SERVER_USERNAME, $DB_SERVER_PASSWORD, $DB_DATABASE, false);

if(!$con->db_connection) {
    $problems_DB = 1;
} else {
	$problems_DB = 0;
}

?>