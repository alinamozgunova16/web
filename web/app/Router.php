<?php

class Router {

    public function run() {

        // route=products/index  (по умолчанию)
        $route = $_GET['route'] ?? 'products/index';

        list($controllerName, $actionName) = explode('/', $route);

        $controllerClass = ucfirst($controllerName) . 'Controller';
        $controllerPath = "controllers/$controllerClass.php";

        if (!file_exists($controllerPath)) {
            die("Controller not found: $controllerClass");
        }

        if ($controllerName === "user") {
             $controllerClass = "UserController";
             $controllerPath = "controllers/UserController.php";
        }

        require_once $controllerPath;

        $controller = new $controllerClass;

        if (!method_exists($controller, $actionName)) {
            die("Action not found: $actionName");
        }


        $controller->$actionName();
    }
}
