<?php
session_start();
//error_reporting(0);
// Include the router and routes
$router = require_once '../config/routes.php';


// Match the current request
$match = $router->match();

if ($match) {
    $controllerName = $match['target']['controller'];
    $action = $match['target']['action'];

    // Include the controller file
    require_once "../app/Controllers/$controllerName.php";

    $controller = new $controllerName();

    // Call the method dynamically
    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], $match['params']);
    } else {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo "Method not found: $action";
    }
} else {
    if (isset($_SESSION['user'])) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo "404 Not Found";
    } else {
        header('Location: /login');
    }
}
