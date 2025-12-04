<?php

class Database {

    private static $conn = null;

    public static function getConnection() {

        if (self::$conn === null) {

            self::$conn = new PDO(
                "mysql:host=db;dbname=mydb",
                "user",
                "pass",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );
        }

        return self::$conn;
    }
}
