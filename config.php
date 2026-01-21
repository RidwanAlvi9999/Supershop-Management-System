<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'shop_management');
define('DB_USER', 'root');
define('DB_PASS', '');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
