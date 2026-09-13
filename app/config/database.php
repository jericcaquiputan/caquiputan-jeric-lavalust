<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$database = [
    'main' => [
        'driver'   => getenv('DB_DRIVER') === 'mysqli' ? 'mysql' : (getenv('DB_DRIVER') ?: 'mysql'),
        'hostname' => getenv('DB_HOST') ?: 'localhost',
        'port'     => getenv('DB_PORT') ?: '3306',
        'username' => getenv('DB_USERNAME') ?: (getenv('DB_USER') ?: 'root'),
        'password' => getenv('DB_PASSWORD') ?: '',
        'database' => getenv('DB_NAME') ?: 'mydb',
        'charset'  => 'utf8mb4',
        'ssl_ca'   => getenv('DB_SSL_CA') ?: '',
        'ssl_verify' => filter_var(getenv('DB_SSL_VERIFY') ?: 'true', FILTER_VALIDATE_BOOLEAN),
    ]
];