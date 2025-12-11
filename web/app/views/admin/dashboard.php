<link rel="stylesheet" href="/style.css">

<div class="center-wrapper">
    <div class="card" style="width: 450px;">

        <h2>Панель администратора</h2>

        <div class="cabinet-item">
            <b>Всего пользователей:</b> <?= $stats['users'] ?>
        </div>

        <div class="cabinet-item">
            <b>Всего товаров:</b> <?= $stats['products'] ?>
        </div>

        <a class="btn" href="/?route=products/index">Управление товарами</a>
        <a class="btn" href="/?route=admin/users">Управление пользователями</a>
        <a class="btn" href="/?route=products/import">Импорт CSV</a>
        <a class="btn" href="/?route=user/cabinet">Личный кабинет</a>

    </div>
</div>
