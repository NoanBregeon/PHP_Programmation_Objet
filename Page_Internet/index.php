<?php
session_start();

define('BASE_PATH', __DIR__);

$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = BASE_PATH . '/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerClass();

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        include BASE_PATH . '/views/404.php';
    }
} else {
    include BASE_PATH . '/views/404.php';
}
?>