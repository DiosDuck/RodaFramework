<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Controllers\AbstractController;

class Router {
    protected $routes = [];

    /**
     * Add a new route
     */
    public function registerRoute(string $method, string $uri, string $action): void 
    {
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ];
    }

    /**
     * Add a GET route
     */
    public function get(string $uri, string $controller): void 
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add a POST route
     */
    public function post(string $uri, string $controller): void
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add a PUT route
     */
    public function put(string $uri, string $controller): void 
    {
        $this->registerRoute('PUT', $uri, $controller);
    }
        
    /**
     * Add a DELETE route
     */
    public function delete(string $uri, string $controller): void 
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    /**
     * Route the request
     */
    public function route(string $uri): void 
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach($this->routes as $route) {
            $uriSegmnets = explode('/', trim($uri, '/'));
            $routeSegmnets = explode('/', trim($route['uri'], '/'));
            $match = false;

            if (
                count($uriSegmnets) === count($routeSegmnets) && 
                strtoupper($route['method']) === $requestMethod    
            ) {
                $params = [];
                $match = true;

                for ($i = 0; $i < count($uriSegmnets); $i++) {
                    if (
                        $routeSegmnets[$i] !== $uriSegmnets[$i] &&
                        !preg_match('/\{(.+?)\}/', $routeSegmnets[$i])
                    ) {
                        $match = false;
                        break;
                    }
                    
                    if(preg_match('/\{(.+?)\}/', $routeSegmnets[$i], $matches)) {
                        $params[$matches[1]] = $uriSegmnets[$i];
                    }
                }

                if ($match) {
                    try {
                        $controller = 'App\\Controllers\\' . $route['controller'];
                        if (!class_exists($controller)) {
                            throw new \Exception("Class $controller does not exist!");
                        }

                        $controllerInstance = new $controller();
                        if (!$controllerInstance instanceof AbstractController) {
                            throw new \Exception("Class $controller does not inherit " . AbstractController::class);
                        }

                        $controllerMethod = $route['controllerMethod'];
                        if (!method_exists($controllerInstance, $controllerMethod)) {
                            throw new \Exception("Class $controller does not contain method with name $controllerMethod");
                        }

                        $controllerInstance->setQuery($_GET);
                        $controllerInstance->setRawBody(file_get_contents('php://input'));
                        $controllerInstance->$controllerMethod($params);
                    } catch (\Exception $e) {
                        Logger::exceptionLog($e);
                        ErrorController::internalServerError();
                    } finally {
                        return;
                    }
                }
            }
        }
        ErrorController::notFound();
        Logger::log("Route '$uri' not found", Logger::WARNING_LOG);
    }
}
