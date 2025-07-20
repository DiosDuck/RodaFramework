<?php

use Framework\Router\IRouter;
use Framework\DependencyInjection\Container;

/** @var IRouter $router */
$router = Container::get(IRouter::class);

$router->get('', 'HomeController@index');
$router->get('/api/welcome/{name}', 'ApiController@welcome');
$router->post('/api/json-body', 'ApiController@jsonBody');

return $router;
