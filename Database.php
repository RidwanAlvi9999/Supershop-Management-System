<?php
require_once __DIR__ . '/../config/config.php';

class Database {

    private static $conn = null;

    public static function connect() {

        if (self::$conn === null) {

            self::$conn = new mysqli(
                DB_HOST,
                DB_USER,
                DB_PASS,
                DB_NAME
            );

            if (self::$conn->connect_error) {
                die("Database Connection Failed: " . self::$conn->connect_error);
            }

            // Optional but recommended
            self::$conn->set_charset("utf8mb4");
        }

        return self::$conn;
    }
}
