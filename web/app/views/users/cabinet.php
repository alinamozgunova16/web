<style>
body { font-family:Arial; background:#f3f4f6; margin:0; padding:0; }
.center-wrapper { display:flex; justify-content:center; align-items:center; min-height:100vh; }
.card { width:380px; background:white; padding:32px; border-radius:12px; box-shadow:0 4px 14px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#333; }
.cabinet-item { font-size:16px; margin:12px 0; }
.btn { width:100%; padding:12px; background:#222; color:white; border-radius:6px; margin-top:12px; text-align:center; display:block; text-decoration:none; }
.btn:hover { background:#444; }
.btn-row { display:flex; gap:10px; }
</style>

<div class="center-wrapper">
    <div class="card">
        <h2>Личный кабинет</h2>

        <div class="cabinet-item">Логин: <b><?= $_SESSION['user']['username'] ?></b></div>
        <div class="cabinet-item">Email: <b><?= $_SESSION['user']['email'] ?></b></div>
        <div class="cabinet-item">Роль: <b><?= $_SESSION['user']['role'] ?></b></div>

        <a class="btn" href="/?route=user/edit">Редактировать профиль</a>
        <a class="btn" href="/?route=products/index">Список товаров</a>

        <?php if ($_SESSION['user']['role']==='admin'): ?>
            <a class="btn" href="/?route=products/import">Импорт CSV</a>
        <?php endif; ?>

        <a class="btn" href="/?route=user/logout">Выйти</a>
    </div>
</div>
