<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../helpers.php';

use App\Controllers\ErrorController;
use Framework\Controllers\AbstractErrorController;
use Framework\DependencyInjection\Container;
use Framework\Logger\ILogService;
use Framework\Router\Router;

Container::construct();

try {
    /** @var Router $router */
    $router = require basePath('routes.php');

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $router->route($uri);
} catch (Throwable $e) {
    /** @var AbstractErrorController $errorController */
    $errorController = Container::get(AbstractErrorController::class);
    $errorController->renderError('internal server error', 500);

    /** @var ILogService $logService */
    $logService = Container::get(ILogService::class);
    $logService->exceptionLog($e);
}
