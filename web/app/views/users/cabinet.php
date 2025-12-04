<?php $u = $_SESSION['user']; ?>

<h1>Личный кабинет</h1>

<p>Логин: <?= $u['username'] ?></p>
<p>Роль: <?= $u['role'] ?></p>

<a href="/?route=products/index">Список товаров</a><br><br>

<a href="/?route=user/logout">Выйти</a>
