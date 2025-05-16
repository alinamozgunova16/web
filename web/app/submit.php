<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $data = [];
    
    $data['brand'] = htmlspecialchars(trim($_POST['brand'] ?? ''));
    $data['product_name'] = htmlspecialchars(trim($_POST['product_name'] ?? ''));
    $data['quantity'] = (int)($_POST['quantity'] ?? 0);
    $data['price'] = (float)($_POST['price'] ?? 0);
    
    if (empty($data['brand'])) {
        $errors[] = "Марка товара обязательна для заполнения";
    }
    
    if (empty($data['product_name'])) {
        $errors[] = "Название товара обязательно для заполнения";
    }
    
    if ($data['quantity'] < 1 || $data['quantity'] > 1000) {
        $errors[] = "Количество должно быть от 1 до 1000";
    }
    
    if ($data['price'] < 0.01 || $data['price'] > 1000000) {
        $errors[] = "Цена должна быть от 0.01 до 1 000 000";
    }
    
    if (empty($errors)) {
        $data['total'] = $data['quantity'] * $data['price'];
        
        try {
            $stmt = $conn->prepare('
                INSERT INTO electronics 
                (brand, product_name, quantity, price, total) 
                VALUES (?, ?, ?, ?, ?)
            ');
            
            $result = $stmt->execute([
                $data['brand'],
                $data['product_name'],
                $data['quantity'],
                $data['price'],
                $data['total']
            ]);
            
            $message = "Товар успешно добавлен!";
            echo "<script>alert('$message'); window.location.href='index.php';</script>";
            exit();
        } catch (PDOException $e) {
            $errors[] = "Ошибка базы данных: " . $e->getMessage();
        }
    }
    
    // Если есть ошибки - показываем их
    if (!empty($errors)) {
        $message = implode("\\n", $errors);
        echo "<script>alert('$message'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>