<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../helpers.php';

use App\Controllers\ErrorController;
use Framework\Session;
use Framework\Router;

Session::start();
$router = new Router();
$routes = require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
try {
    $router->route($uri);
} catch (Exception $e) {
    ErrorController::internalServerError();
}
