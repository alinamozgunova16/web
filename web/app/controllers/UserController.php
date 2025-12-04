<?php
session_start();
require_once 'models/User.php';

class UserController {

    public function register() {
        require 'views/users/register.php';
    }

    public function registerPost() {
        $username = trim($_POST['username']);
        $pass = $_POST['password'];

        if (User::findByName($username)) {
            die("Пользователь уже существует!");
        }

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        User::create($username, $hash);

        echo "Регистрация успешна! <a href='/?route=user/login'>Перейти к входу</a>";
    }

    public function login() {
        require 'views/users/login.php';
    }

    public function loginPost() {
        $username = trim($_POST['username']);
        $pass = $_POST['password'];

        $user = User::findByName($username);

        if (!$user || !password_verify($pass, $user['password'])) {
            die("Неверный логин или пароль");
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        header('Location: /?route=user/cabinet');
        exit;
    }

    public function cabinet() {
        if (!isset($_SESSION['user'])) {
            die("Вы не авторизованы");
        }

        require 'views/users/cabinet.php';
    }

    public function logout() {
        session_destroy();
        header("Location: /?route=user/login");
    }
}
