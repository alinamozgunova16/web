<?php
// Подключение к БД с обработкой ошибок
require 'db.php';

// Инициализация переменных
$message = '';
$products = [];

// Обработка сообщений
if (isset($_GET['success'])) {
    $message = '<div class="success">Товар успешно добавлен!</div>';
} elseif (isset($_GET['error'])) {
    $message = '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
}

// Получение списка товаров
try {
    $stmt = $conn->query("
        SELECT *, 
               DATE_FORMAT(created_at, '%d.%m.%Y %H:%i') as formatted_date 
        FROM electronics 
        ORDER BY created_at DESC
    ");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = '<div class="error">Ошибка загрузки товаров: ' . $e->getMessage() . '</div>';
}

// Сохранение введенных данных при ошибках
$oldInput = [
    'brand' => htmlspecialchars($_GET['brand'] ?? $_POST['brand'] ?? ''),
    'product_name' => htmlspecialchars($_GET['product_name'] ?? $_POST['product_name'] ?? ''),
    'quantity' => htmlspecialchars($_GET['quantity'] ?? $_POST['quantity'] ?? ''),
    'price' => htmlspecialchars($_GET['price'] ?? $_POST['price'] ?? '')
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин электроники - Админ-панель</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-container {
            background: #f9f9f9;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        input[type="text"], 
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52,152,219,0.2);
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .price {
            text-align: right;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h1>Администрирование магазина электроники</h1>
    
    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'успешно') !== false ? 'success' : 'error' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <h2>Добавить новый товар</h2>
        <form method="POST" action="submit.php">
            <div class="form-group">
                <label for="brand">Марка производителя:</label>
                <input type="text" id="brand" name="brand" required
                       value="<?= $oldInput['brand'] ?>">
            </div>
            
            <div class="form-group">
                <label for="product_name">Название товара:</label>
                <input type="text" id="product_name" name="product_name" required
                       value="<?= $oldInput['product_name'] ?>">
            </div>
            
            <div class="form-group">
                <label for="quantity">Количество на складе:</label>
                <input type="number" id="quantity" name="quantity" min="1" required
                       value="<?= $oldInput['quantity'] ?>">
            </div>
            
            <div class="form-group">
                <label for="price">Цена (руб):</label>
                <input type="number" id="price" name="price" min="0.01" step="0.01" required
                       value="<?= $oldInput['price'] ?>">
            </div>
            
            <button type="submit">Добавить товар</button>
        </form>
    </div>

    <h2>Текущий ассортимент</h2>
    <?php if (empty($products)): ?>
        <p>Нет товаров в базе данных.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Марка</th>
                    <th>Название</th>
                    <th>Кол-во</th>
                    <th class="price">Цена</th>
                    <th class="price">Сумма</th>
                    <th>Добавлен</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['brand']) ?></td>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td class="price"><?= number_format($product['price'], 2) ?> ₽</td>
                        <td class="price"><?= number_format($product['total'], 2) ?> ₽</td>
                        <td><?= $product['formatted_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>