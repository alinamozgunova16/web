<?php
session_start();
require_once 'models/Product.php';

class ProductsController {

    /* ========= РЕДАКТИРОВАНИЕ ЯЧЕЙКИ (AJAX) ========= */
    public function updateField() {

        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            exit("Forbidden");
        }

        $id = intval($_POST['id']);
        $field = $_POST['field'];
        $value = $_POST['value'];

        $allowed = ["brand", "product_name", "quantity", "price"];

        if (!in_array($field, $allowed)) {
            exit("Invalid field");
        }

        Product::updateField($id, $field, $value);

        echo "OK";
    }

    /* ========= СТРАНИЦА СПИСКА ========= */
    public function index() {

        if (!isset($_SESSION['user'])) {
            die("<meta charset='utf-8'>Сначала войдите в систему");
        }

        $products = Product::all();

        require 'views/products/index.php';
    }

    /* ========= СТРАНИЦА ИМПОРТА CSV ========= */
    public function import() {

        if ($_SESSION['user']['role'] !== 'admin') {
            die("<meta charset='utf-8'>Доступ запрещён (только администратор)");
        }

        require 'views/products/import.php';
    }

    /* ========= ЗАГРУЗКА CSV ========= */
    public function uploadCsv() {

        if ($_SESSION['user']['role'] !== 'admin') {
            die("<meta charset='utf-8'>Доступ запрещён");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Invalid request");
        }

        if (!isset($_FILES['csv']) || $_FILES['csv']['error'] !== UPLOAD_ERR_OK) {
            die("<meta charset='utf-8'>Ошибка загрузки файла!");
        }

        $file = $_FILES['csv']['tmp_name'];
        $handle = fopen($file, 'r');

        if (!$handle) {
            die("<meta charset='utf-8'>Не удалось открыть CSV файл");
        }

        fgetcsv($handle);

        while ($row = fgetcsv($handle, 1000, ",")) {

            if (count($row) < 4) continue;

            Product::create(
                trim($row[0]),
                trim($row[1]),
                (int)$row[2],
                (float)$row[3]
            );
        }

        fclose($handle);

        require 'views/products/upload_success.php';
    }

    /* ========= CSV ВЫГРУЗКА ========= */
    public function csv() {
        $products = Product::all();

        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=report.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, ["ID", "Марка", "Название", "Кол-во", "Цена", "Сумма", "Дата"]);

        foreach ($products as $p) {
            fputcsv($output, [
                $p['id'],
                $p['brand'],
                $p['product_name'],
                $p['quantity'],
                $p['price'],
                $p['total'],
                $p['created_at']
            ]);
        }

        fclose($output);
    }

    /* ========= EXCEL ========= */
    public function excel() {
        $products = Product::all();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=report.xls");

        echo "<table border='1'>";
        echo "<tr>
                <th>ID</th><th>Марка</th><th>Название</th>
                <th>Кол-во</th><th>Цена</th><th>Сумма</th><th>Дата</th>
              </tr>";

        foreach ($products as $p) {
            echo "<tr>
                    <td>{$p['id']}</td>
                    <td>{$p['brand']}</td>
                    <td>{$p['product_name']}</td>
                    <td>{$p['quantity']}</td>
                    <td>{$p['price']}</td>
                    <td>{$p['total']}</td>
                    <td>{$p['created_at']}</td>
                  </tr>";
        }

        echo "</table>";
    }

    /* ========= PDF ========= */
    public function pdf() {

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=report.pdf");

        echo "%PDF-1.1
1 0 obj
<<>>
endobj
2 0 obj
<< /Length 44 >>
stream
Report placeholder
endstream
endobj
trailer
<<>>
%%EOF";

        exit;
    }
}
