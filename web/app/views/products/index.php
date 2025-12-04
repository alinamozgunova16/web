<h1>Список товаров</h1>

<p>
    <a href="/?route=products/import">Импорт CSV</a>
</p>

<p>
    <a href="/?route=products/csv">Скачать CSV</a>
    <a href="/?route=products/excel">Скачать Excel</a>
    <a href="/?route=products/pdf">Скачать PDF</a>
</p>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Марка</th>
        <th>Название</th>
        <th>Кол-во</th>
        <th>Цена</th>
        <th>Сумма</th>
        <th>Дата</th>
    </tr>

<?php foreach ($products as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['brand']) ?></td>
        <td><?= htmlspecialchars($p['product_name']) ?></td>
        <td><?= $p['quantity'] ?></td>
        <td><?= $p['price'] ?></td>
        <td><?= $p['total'] ?></td>
        <td><?= $p['created_at'] ?></td>
    </tr>
<?php endforeach; ?>
</table>
