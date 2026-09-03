<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$database['main'] = array(
    'driver'   => getenv('DB_DRIVER') ?: 'mysql',
    'hostname' => getenv('DB_HOST') ?: 'localhost',
    'port'     => getenv('DB_PORT') ?: '3306',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'database' => getenv('DB_NAME') ?: 'mydb',
    'charset'  => getenv('DB_CHARSET') ?: 'utf8mb4',
    'dbprefix' => getenv('DB_PREFIX') ?: '',
    'path'     => ''
);
