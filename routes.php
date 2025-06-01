<?php
use Framework\Router\Router;

$router = new Router();
$router->get('', 'HomeController@index');
$router->get('/api/welcom', 'ApiController@welcome');
$router->post('/api/json-body', 'ApiController@jsonBody');

return $router;