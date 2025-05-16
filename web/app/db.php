<?php
$host = "db";
$db = "mydb";
$user = "user";
$pass = "pass";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_TIMEOUT => 10,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    PDO::MYSQL_ATTR_FOUND_ROWS => true
];

try {
    $conn = new PDO("mysql:host=$host;port=3306;dbname=$db", $user, $pass, $options);
    $conn->exec("
        CREATE TABLE IF NOT EXISTS electronics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            brand VARCHAR(50) NOT NULL,
            product_name VARCHAR(100) NOT NULL,
            quantity INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
} catch (PDOException $e) {
    die("Ошибка подключения к MySQL. Проверьте:\n1. Запущен ли контейнер MySQL\n2. Логин/пароль\n3. Ожидание полного запуска MySQL\n" . $e->getMessage());
}
?>