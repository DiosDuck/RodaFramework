<?php

use Framework\Router\IRouter;
use Framework\DependencyInjection\Container;

/** @var IRouter $router */
$router = Container::get(IRouter::class);

$router->get('', 'HomeController@index');
$router->get('/api/welcome/{name}', 'ApiController@welcome');
$router->post('/api/json-body', 'ApiController@jsonBody');

$router->get('/admin', 'AdminController@index', ['admin']);
$router->post('/api/admin/signed', 'AdminApiController@sign');
$router->post('/api/admin/unsigned', 'AdminApiController@unsign', 'admin');

return $router;
