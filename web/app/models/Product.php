<?php

require_once 'models/Database.php';

class Product {

    public static function all() {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT * FROM electronics ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

   public static function create($brand, $product_name, $quantity, $price) {
    $db = Database::getConnection();

    $total = $quantity * $price;

    $stmt = $db->prepare("
        INSERT INTO electronics (brand, product_name, quantity, price, total)
        VALUES (?, ?, ?, ?, ?)
    ");

    return $stmt->execute([$brand, $product_name, $quantity, $price, $total]);
}
}
