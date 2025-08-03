<?php

namespace Framework\Router;

class Route {
    public function __construct(
        private string $method,
        private string $uri,
        private string $controller,
        private string $controllerMethod,
        private string|array $authorizedRoles,
    ) {}

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getController(): string
    {
        return 'App\\Controllers\\' . $this->controller;
    }

    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    public function getAuthorizedRoles(): string|array
    {
        return $this->authorizedRoles;
    }
}
