<?php
// config/database.php

// Database credentials
$DB_HOST = "localhost";
$DB_USER = "root";     // default XAMPP user
$DB_PASS = "";         // default XAMPP password
$DB_NAME = "supershop_mvc";

// Create connection
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Check connection
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Set charset (security + Bangla/Unicode support)
mysqli_set_charset($conn, "utf8mb4");
