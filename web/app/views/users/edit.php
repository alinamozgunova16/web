<style>
body { font-family:Arial; background:#f3f4f6; margin:0; padding:0; }
.center-wrapper { display:flex; justify-content:center; align-items:center; min-height:100vh; }
.card { width:380px; background:white; padding:32px; border-radius:12px; box-shadow:0 4px 14px rgba(0,0,0,0.1); }
h2 { text-align:center; }
input { width:100%; padding:12px; margin-top:12px; border:1px solid #ccc; border-radius:6px; }
.btn { width:100%; padding:12px; background:#222; color:white; border-radius:6px; margin-top:18px; text-align:center; display:block; }
.btn:hover { background:#444; }
.alert { padding:12px; border-radius:6px; margin-bottom:12px; }
.alert.error { background:#ffe1e1; color:#a90000; }
.alert.success { background:#e2ffe7; color:#006b1f; }
.link { display:block; margin-top:12px; text-align:center; }
</style>

<div class="center-wrapper">
    <div class="card">
        <h2>Редактировать профиль</h2>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="alert success"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="/?route=user/editPost">
            <input type="text" name="username" value="<?= $_SESSION['user']['username'] ?>">
            <input type="email" name="email" value="<?= $_SESSION['user']['email'] ?>">

            <input type="password" name="password" placeholder="Новый пароль (не обязательно)">
            <input type="password" name="password_confirm" placeholder="Повторите пароль">

            <button class="btn">Сохранить</button>
        </form>

        <a class="link" href="/?route=user/cabinet">Назад</a>
    </div>
</div>
