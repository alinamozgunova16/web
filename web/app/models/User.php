<?php

require_once 'models/Database.php';

class User {

    public static function findByName($username) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public static function create($username, $passwordHash) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $passwordHash]);
    }
}
