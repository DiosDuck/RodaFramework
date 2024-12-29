<?php
$router->get('', 'HomeController@index');
$router->get('/api/welcome', 'ApiController@welcome');
$router->post('/api/json-body', 'ApiController@jsonBody');