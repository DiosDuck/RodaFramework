<?php

namespace Framework\Router;

interface IRouter {
    /**
     * Add a GET route
     */
    public function get(string $uri, string $controller): void;

    /**
     * Add a POST route
     */
    public function post(string $uri, string $controller): void;

    /**
     * Add a PUT route
     */
    public function put(string $uri, string $controller): void;
            
    /**
     * Add a DELETE route
     */
    public function delete(string $uri, string $controller): void;
    
    /**
     * Route the request
     */
    public function route(string $uri): void;
}
