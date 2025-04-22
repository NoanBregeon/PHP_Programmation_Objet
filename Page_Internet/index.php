<?php
session_start();

// Chemin absolu vers le projet
define('BASE_PATH', __DIR__);

// Chargement du contrôleur et de l'action depuis l'URL
$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Ex: "vehicule" → "VehiculeController"
$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = BASE_PATH . '/controllers/' . $controllerClass . '.php';

// Vérification de l'existence du contrôleur
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerClass();

    // Vérification de la méthode/action
    if (method_exists($controller, $action)) {
        if (isset($_GET['id'])) {
            $controller->$action($_GET['id']);
        } else {
            $controller->$action();
        }
        
    } else {
        http_response_code(404);
        include BASE_PATH . '/views/404.php';
    }
} else {
    http_response_code(404);
    include BASE_PATH . '/views/404.php';
}
?>
<head>
    <link rel="stylesheet" href="public/styles.css">
</head>
