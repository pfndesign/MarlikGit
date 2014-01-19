<?php

include(INSTALL_PATH."mysql.php");

$con = new sql_db($DB_SERVER, $DB_SERVER_USERNAME, $DB_SERVER_PASSWORD, $DB_DATABASE, false);

if(!$con->db_connect_id) {
    $problems_DB = 1;
} else {
	$problems_DB = 0;
}

?>