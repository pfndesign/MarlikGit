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
	define("CORE_INCLUSION", "../../../");
} elseif (defined('INSIDE_MOD')) {
	define("CORE_INCLUSION", "../../");
} elseif (defined('BRIDGE_MOD')) {
	define("CORE_INCLUSION", "../");
} else {
	define("CORE_INCLUSION", "./");
}

include(CORE_INCLUSION . "db/legacydb.php");
$dbargs = [
	'type' => $_ENV['db_type'],
	'host' => $_ENV['db_host'],
	'database' => $_ENV['db_name'],
	'username' => $_ENV['db_username'],
	'password' => $_ENV['db_password'],
];
if (isset($_ENV['db_charset']))
	$dbargs['charset'] = $_ENV['db_charset'];
if (isset($_ENV['db_collation']))
	$dbargs['collation'] = $_ENV['db_collation'];
if (isset($_ENV['db_port']))
	$dbargs['port'] = $_ENV['db_port'];
if (isset($_ENV['db_prefix']))
	$dbargs['prefix'] = $_ENV['db_prefix']."_";
if (isset($_ENV['db_logging']))
	$dbargs['logging'] = $_ENV['db_logging'] == "true" ? true : false;
if (isset($_ENV['db_error'])) {
	switch ($_ENV['db_error']) {
		case 'silent':
			$dbargs['error'] = PDO::ERRMODE_SILENT;
			break;
		case 'warning':
			$dbargs['error'] = PDO::ERRMODE_WARNING;
			break;
		case 'exception':
			$dbargs['error'] = PDO::ERRMODE_EXCEPTION;
			break;
		default:
			$dbargs['error'] = PDO::ERRMODE_SILENT;
			break;
	}
}
if (isset($_ENV['db_testmode']))
	$dbargs['testMode'] = $_ENV['db_testmode'] == "true" ? true : false;
if (isset($_ENV['db_dsn_driver'], $_ENV['db_dsn_server'], $_ENV['db_dsn_port'])) {
	$dbargs['dsn'] = [
		'driver' => $_ENV['db_dsn_driver'],
		'server' => $_ENV['db_dsn_server'],
		'port' => $_ENV['db_dsn_port']
	];
}
if ($_ENV['db_type'] == 'mysql' && isset($_ENV['db_socket']))
	$dbargs['socket'] = $_ENV['db_socket'];
if ($_ENV['db_type'] == 'mssql' && isset($_ENV['db_mssql_appname']))
	$dbargs['appname'] = $_ENV['db_mssql_appname'];
if ($_ENV['db_type'] == 'mssql' && isset($_ENV['db_mssql_driver'])) {
	$dbargs['driver'] = $_ENV['db_mssql_driver'];
	if ($_ENV['db_mssql_driver'] == 'sqlsrv') {
		if (isset($_ENV['db_mssql_application_intent']))
			$dbargs['application_intent'] = $_ENV['db_mssql_application_intent'];
		if (isset($_ENV['db_mssql_attach_db_file_name']))
			$dbargs['attach_db_file_name'] = $_ENV['db_mssql_attach_db_file_name'];
		if (isset($_ENV['db_mssql_authentication']))
			$dbargs['authentication'] = $_ENV['db_mssql_authentication'];
		if (isset($_ENV['db_mssql_column_encryption']))
			$dbargs['column_encryption'] = $_ENV['db_mssql_column_encryption'] == "true" ? "Enabled" : "Disabled";
		if (isset($_ENV['db_mssql_connection_pooling']))
			$dbargs['connection_pooling'] = $_ENV['db_mssql_connection_pooling'];
		if (isset($_ENV['db_mssql_encrypt']))
			$dbargs['encrypt'] = $_ENV['db_mssql_encrypt'];
		if (isset($_ENV['db_mssql_failover_partner']))
			$dbargs['failover_partner'] = $_ENV['db_mssql_failover_partner'];
		if (isset($_ENV['db_mssql_key_store_authentication']))
			$dbargs['key_store_authentication'] = $_ENV['db_mssql_key_store_authentication'];
		if (isset($_ENV['db_mssql_key_store_principal_id']))
			$dbargs['key_store_principal_id'] = $_ENV['db_mssql_key_store_principal_id'];
		if (isset($_ENV['db_mssql_key_store_secret']))
			$dbargs['key_store_secret'] = $_ENV['db_mssql_key_store_secret'];
		if (isset($_ENV['db_mssql_login_timeout']))
			$dbargs['login_timeout'] = $_ENV['db_mssql_login_timeout'];
		if (isset($_ENV['db_mssql_multiple_active_result_sets']))
			$dbargs['multiple_active_result_sets'] = $_ENV['db_mssql_multiple_active_result_sets'];
		if (isset($_ENV['db_mssql_multi_subnet_failover']))
			$dbargs['multi_subnet_failover'] = $_ENV['db_mssql_multi_subnet_failover'] == "true" ? "Yes" : "No";
		if (isset($_ENV['db_mssql_scrollable']))
			$dbargs['scrollable'] = $_ENV['db_mssql_scrollable'];
		if (isset($_ENV['db_mssql_trace_file']))
			$dbargs['trace_file'] = $_ENV['db_mssql_trace_file'];
		if (isset($_ENV['db_mssql_trace_on']))
			$dbargs['trace_on'] = $_ENV['db_mssql_trace_on'];
		if (isset($_ENV['db_mssql_transaction_isolation'])) {
			switch ($_ENV['db_mssql_transaction_isolation']) {
				case 'uncommitted':
					$dbargs['transaction_isolation'] = PDO::SQLSRV_TXN_READ_UNCOMMITTED;
					break;
				case 'committed':
					$dbargs['transaction_isolation'] = PDO::SQLSRV_TXN_READ_COMMITTED;
					break;
				case 'repeatable':
					$dbargs['transaction_isolation'] = PDO::SQLSRV_TXN_REPEATABLE_READ;
					break;
				case 'snapshot':
					$dbargs['transaction_isolation'] = PDO::SQLSRV_TXN_SNAPSHOT;
					break;
				case 'serializable':
					$dbargs['transaction_isolation'] = PDO::SQLSRV_TXN_SERIALIZABLE;
					break;
				default:
					$dbargs['transaction_isolation'] = PDO::SQLSRV_TXN_SNAPSHOT;
					break;
			}
		}
		if (isset($_ENV['db_mssql_transparent_network_ip_resolution']))
			$dbargs['transparent_network_ip_resolution'] = $_ENV['db_mssql_transparent_network_ip_resolution'] == "true" ? "Enabled" : "Disabled";
		if (isset($_ENV['db_mssql_trust_server_certificate']))
			$dbargs['trust_server_certificate'] = $_ENV['db_mssql_trust_server_certificate'];
		if (isset($_ENV['db_mssql_wsid']))
			$dbargs['wsid'] = $_ENV['db_mssql_wsid'];
	}
}
try {
	$db = new legacydb($dbargs);
} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
