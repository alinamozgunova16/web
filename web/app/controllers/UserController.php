<?php
session_start();
require_once 'models/User.php';
require_once 'models/Database.php';

class UserController {

    // Универсальный рендер страницы
    private function render($view, $params = []) {
        extract($params);
        require "views/$view.php";
    }

    // ---------------------- РЕГИСТРАЦИЯ ----------------------
    public function register() {
        $this->render('users/register');
    }

    public function registerPost() {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $pass = $_POST['password'];
        $pass2 = $_POST['password_confirm'];

        // ----- ВАЛИДАЦИЯ -----
        if ($pass !== $pass2) {
            return $this->render("users/register", [
                "error" => "Пароли не совпадают!"
            ]);
        }

        if (strlen($username) < 3) {
            return $this->render("users/register", [
                "error" => "Имя должно содержать минимум 3 символа"
            ]);
        }

        if (strlen($pass) < 6) {
            return $this->render("users/register", [
                "error" => "Пароль должен быть минимум 6 символов"
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render("users/register", [
                "error" => "Некорректный email"
            ]);
        }

        if (User::findByName($username)) {
            return $this->render("users/register", [
                "error" => "Пользователь с таким именем уже существует!"
            ]);
        }

        if (User::findByEmail($email)) {
            return $this->render("users/register", [
                "error" => "Этот email уже используется!"
            ]);
        }

        // ---- СОЗДАЁМ ПОЛЬЗОВАТЕЛЯ ----
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        User::create($username, $email, $hash);

        return $this->render("users/register", [
        "message" => "Пользователь успешно создан!"
        ]);

    }


    // ---------------------- ВХОД ----------------------
    public function login() {
        $this->render('users/login');
    }

    public function loginPost() {
        $login = trim($_POST['username']); // имя или email
        $pass = $_POST['password'];

        // Ищем по имени
        $user = User::findByName($login);

        // Если не нашли — ищем по email
        if (!$user) {
            $user = User::findByEmail($login);
        }

        if (!$user || !password_verify($pass, $user['password'])) {
            return $this->render("users/login", [
                "error" => "Неверные данные для входа"
            ]);
        }

        // Создаем сессию
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        header("Location: /?route=user/cabinet");
        exit;
    }


    // ---------------------- ЛИЧНЫЙ КАБИНЕТ ----------------------
    public function cabinet() {
        if (!isset($_SESSION['user'])) {
            die("Вы не авторизованы");
        }

        $this->render('users/cabinet');
    }


    // ---------------------- ВЫХОД ----------------------
    public function logout() {
        session_destroy();
        header("Location: /?route=user/login");
        exit;
    }


    // ---------------------- РЕДАКТИРОВАНИЕ ----------------------
    public function edit() {
        if (!isset($_SESSION['user'])) {
            die("Вы не авторизованы");
        }

        $this->render('users/edit');
    }

    public function editPost() {
        if (!isset($_SESSION['user'])) {
            die("Вы не авторизованы");
        }

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $pass = $_POST['password'];
        $pass2 = $_POST['password_confirm'];

        // Проверка паролей (если меняют)
        if ($pass !== "" && $pass !== $pass2) {
            return $this->render("users/edit", [
                "error" => "Пароли не совпадают!"
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render("users/edit", [
                "error" => "Некорректный email"
            ]);
        }

        $db = Database::getConnection();

        // Если пароль меняют
        if ($pass !== "") {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
            $stmt->execute([$username, $email, $hash, $_SESSION['user']['id']]);
        } else {
            $stmt = $db->prepare("UPDATE users SET username=?, email=? WHERE id=?");
            $stmt->execute([$username, $email, $_SESSION['user']['id']]);
        }

        // Обновляем сессию
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;

        return $this->render("users/edit", [
            "message" => "Данные успешно обновлены!"
        ]);
    }

    public function updateField()
{
    $id = $_POST['id'] ?? null;
    $field = $_POST['field'] ?? null;
    $value = $_POST['value'] ?? null;

    if (!$id || !$field) {
        echo "error";
        return;
    }

    Products::updateField($id, $field, $value);

    echo "ok";
    }   

}
