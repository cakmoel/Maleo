<?php

define('DS', DIRECTORY_SEPARATOR);

if (!defined('APP_SYSPATH')) define('APP_SYSPATH', realpath(dirname(dirname(__FILE__))) . DS);

if (!defined('PHP_EOL')) define('PHP_EOL', strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? "\r\n" : "\n");

// Site configuration
define('APP_URL', 'http://' . $_SERVER['HTTP_HOST'] . DS .'blogmvc');
define('APP_LIB',  'lib');
define('APP_CONTROLLERS', 'controllers');
define('APP_MODELS', 'models');
define('APP_VIEWS', 'views');
define('APP_LOG', 'log');
define('APP_EMAIL', 'alanmoehammad@gmail.com');

// Database configuration
define('ADAPTER_TYPE', 'PDO');
define('DB_CONNECTION', 'mysql:host=localhost;dbname=blog');
define('DB_USR', 'root');
define('DB_PWD', 'kartatopia');

$key = 'e0aa8df8a945a35a77f617945f3ded43687a3a456f63c7b4fb6c0ae6e7f622b4';
$checkIncKey = sha1(mt_rand(1, 1000000).$key);
define('APP_KEY', $checkIncKey);

error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');