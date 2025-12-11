<style>
/* СТИЛИ ДЛЯ ВСЕЙ СТРАНИЦЫ */
body {
    font-family: Arial, sans-serif;
    background: #f3f4f6;
    margin: 0; padding: 0;
}
.center-wrapper {
    display: flex; justify-content: center; align-items: center;
    min-height: 100vh;
}
.card {
    width: 380px; background: white; padding: 32px;
    border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.1);
}
h2 { text-align: center; margin-top: 0; color: #333; }
input {
    width: 100%; padding: 12px; margin-top: 12px;
    border-radius: 6px; border: 1px solid #ccc; font-size: 15px;
}
.btn {
    width: 100%; padding: 12px; margin-top: 18px;
    background: #222; color:white; border-radius:6px; text-align:center;
    text-decoration:none; display:block;
}
.btn:hover { background:#444; }
.link { display:block; text-align:center; margin-top:15px; color:#444; }
.alert { padding:12px; border-radius:6px; margin-bottom:10px; font-size:14px; }
.alert.error { background:#ffe1e1; color:#a90000; }
</style>

<div class="center-wrapper">
    <div class="card">
        <h2>Вход</h2>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="/?route=user/loginPost">
            <input type="text" name="username" placeholder="Логин или Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button class="btn">Войти</button>
        </form>

        <a class="link" href="/?route=user/register">Создать аккаунт</a>
    </div>
</div>
