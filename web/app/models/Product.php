<?php
require_once "Database.php";

class Product {

    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT *, (price * quantity) AS total FROM electronics ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($brand, $name, $quantity, $price) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO electronics (brand, product_name, quantity, price) 
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$brand, $name, $quantity, $price]);
    }

    public static function updateField($id, $field, $value) {
    $allowed = ["brand", "product_name", "quantity", "price"];
    if (!in_array($field, $allowed)) return;

    $db = Database::getConnection();
    $stmt = $db->prepare("UPDATE electronics SET $field = :val WHERE id = :id");
    $stmt->execute([
        "val" => $value,
        "id"  => $id
    ]);

    // ← ДОБАВЛЯЕМ автоматический пересчёт total
    $db->prepare("UPDATE electronics 
                  SET total = quantity * price 
                  WHERE id = :id")
       ->execute(["id" => $id]);
    }

}
