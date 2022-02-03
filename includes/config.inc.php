<?php

/**
 *
 * @package config	
 * load site config from .env file										
 * @version 1.0.0		
 * @author pfndesigen@gmail.com		
 */
try {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    // show error page
    echo $e->getMessage();
    exit;
}
// required env variables
try {
    $dotenv->required('db_type')->allowedValues(['mysql', 'mssql', 'sqlite', 'pgsql', 'sybase', 'oracle']);
    $dotenv->required(['db_host', 'db_name', 'db_username'])->notEmpty();
    $dotenv->required('db_password');
    $dotenv->ifPresent(['db_charset', 'db_collation', 'db_socket'])->notEmpty();
    $dotenv->ifPresent(['db_port', 'db_dsn_port', 'db_mssql_connection_pooling', 'db_mssql_connection_pooling', 'db_mssql_login_timeout', 'db_mssql_multiple_active_result_sets', 'db_mssql_trace_on', 'db_mssql_trust_server_certificate'])->isInteger();
    $dotenv->ifPresent(['db_logging', 'db_testmode', 'db_mssql_column_encryption', 'db_mssql_multi_subnet_failover', 'db_mssql_transparent_network_ip_resolution'])->isBoolean();
    $dotenv->ifPresent('db_error')->allowedValues(['silent', 'warning', 'exception']);
    $dotenv->ifPresent(['db_dsn_driver', 'db_dsn_server'])->notEmpty();
    $dotenv->ifPresent(['db_mssql_appname', 'db_mssql_application_intent', 'db_mssql_attach_db_file_name', 'db_mssql_failover_partner', 'db_mssql_failover_partner', 'db_mssql_key_store_authentication', 'db_mssql_key_store_principal_id', 'db_mssql_key_store_secret', 'db_mssql_scrollable', 'db_mssql_trace_file', 'db_mssql_wsid'])->notEmpty();
    $dotenv->ifPresent('db_mssql_transaction_isolation')->allowedValues(['uncommitted', 'committed', 'repeatable', 'snapshot', 'serializable']);
    $dotenv->required(['admin_file', 'domain', 'timezone'])->notEmpty();
    $dotenv->ifPresent('display_errors')->isBoolean();
    $dotenv->ifPresent('benchmark')->isBoolean();
} catch (RuntimeException $e) {
    // show error page
    echo $e->getMessage();
    exit;
}
// subject to change
$prefix = $_ENV['db_prefix'];
$admin_file = $_ENV['admin_file'];
$display_errors = $_ENV['display_errors'] == "true" ? true : false;
//subject to change
define('BENCHMARK', $_ENV['benchmark'] == "true" ? true : false);
define('USV_DOMAIN', $_ENV['domain'] ? $_ENV['domain'] : false);
