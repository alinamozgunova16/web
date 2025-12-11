<link rel="stylesheet" href="/style.css">

<div class="center-wrapper">
    <div class="card" style="width: 500px;">

        <h2>Товар №<?= $product['id'] ?></h2>

        <div class="cabinet-item"><b>Марка:</b> <?= htmlspecialchars($product['brand']) ?></div>
        <div class="cabinet-item"><b>Название:</b> <?= htmlspecialchars($product['product_name']) ?></div>
        <div class="cabinet-item"><b>Количество:</b> <?= $product['quantity'] ?></div>
        <div class="cabinet-item"><b>Цена:</b> <?= $product['price'] ?></div>
        <div class="cabinet-item"><b>Сумма:</b> <?= $product['total'] ?></div>
        <div class="cabinet-item"><b>Дата создания:</b> <?= $product['created_at'] ?></div>

        <a class="btn" href="/?route=products/index">Назад к списку</a>

        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a class="btn" style="background:#b30000;" 
               href="/?route=products/delete&id=<?= $product['id'] ?>">
                Удалить товар
            </a>
        <?php endif; ?>

    </div>
</div>
