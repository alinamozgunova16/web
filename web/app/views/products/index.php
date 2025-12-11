<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Список товаров</title>

<style>
<?php include __DIR__ . "/../../style.css"; ?>
</style>

</head>
<body>

<div class="table-wrapper">

    <h2>Список товаров</h2>

    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <a class="btn" href="/?route=products/import">Импорт CSV</a>
    <?php endif; ?>

    <div class="btn-row">
        <a class="btn btn-small" href="/?route=products/csv">CSV</a>
        <a class="btn btn-small" href="/?route=products/excel">Excel</a>
        <a class="btn btn-small" href="/?route=products/pdf">PDF</a>
    </div>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Марка</th>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Сумма</th>
                <th>Дата</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($products as $p): ?>
            <tr>

                <td><?= $p['id'] ?></td>

                <td class="<?= $_SESSION['user']['role']==='admin' ? 'editable' : '' ?>"
                    data-id="<?= $p['id'] ?>" data-field="brand">
                    <?= htmlspecialchars($p['brand']) ?>
                </td>

                <td class="<?= $_SESSION['user']['role']==='admin' ? 'editable' : '' ?>"
                    data-id="<?= $p['id'] ?>" data-field="product_name">
                    <?= htmlspecialchars($p['product_name']) ?>
                </td>

                <td class="<?= $_SESSION['user']['role']==='admin' ? 'editable' : '' ?>"
                    data-id="<?= $p['id'] ?>" data-field="quantity">
                    <?= $p['quantity'] ?>
                </td>

                <td class="<?= $_SESSION['user']['role']==='admin' ? 'editable' : '' ?>"
                    data-id="<?= $p['id'] ?>" data-field="price">
                    <?= $p['price'] ?>
                </td>

                <td><?= $p['total'] ?></td>
                <td><?= $p['created_at'] ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- Кнопка наверх -->
<a href="#" class="scroll-top">↑</a>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".editable").forEach(td => {

        td.addEventListener("click", function () {

            if (this.classList.contains("editing")) return;
            this.classList.add("editing");

            let oldValue = this.innerText.trim();
            let input = document.createElement("input");
            input.className = "edit-input";
            input.value = oldValue;

            this.innerHTML = "";
            this.appendChild(input);
            input.focus();

            input.addEventListener("blur", () => {
                let newValue = input.value.trim();
                this.classList.remove("editing");
                this.innerText = newValue;

                fetch("/?route=products/updateField", {
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: `id=${this.dataset.id}&field=${this.dataset.field}&value=${encodeURIComponent(newValue)}`
                });
            });
        });

    });
});
</script>

</body>
</html>
