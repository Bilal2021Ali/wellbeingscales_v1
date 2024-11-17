<?php
global $localConfig;
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$common_config = [
    'dsn' => '',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => true,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => [],
    'save_queries' => TRUE,
];

$db['default'] = [
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => $localConfig['DB_USERNAME'] ?? 'root',
    'password' => $localConfig['DB_PASSWORD'] ?? '',
    'database' => 'wellbeingscales2024',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => [],
    'save_queries' => TRUE
];

// Another database
$db['database2'] = [
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'localUser',
    'password' => 'Chocolate#219',
    'database' => 'tdx_face_owl',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => [],
    'save_queries' => TRUE
];

$db['Api_db'] = [
    'dsn' => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'qlicksystems_db_online_vers',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => false,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => [],
    'save_queries' => TRUE
];

$db['active_db'] = $db[$active_group];
$active_db = &$db['active_db'];

// Load any additional database connections if needed
if ($active_group !== 'default') {
    $alt_db = &$db[$active_group];
}
