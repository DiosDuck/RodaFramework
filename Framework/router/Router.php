<?php

namespace Framework\Router;

use App\Controllers\ErrorController;
use Framework\Controllers\AbstractController;
use Framework\Exceptions\RouteException;
use Framework\Logger;

class Router {
    /** @var Route[] $routes */
    protected array $routes = [];

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
        $requestMethod = $this->getRequestMethodName();

        foreach($this->routes as $route) {
            $params = $this->isRouteMatched($route, $uri, $requestMethod);
            
            if ($params !== false) {
                try {
                    $this->callMethod($route, $params);
                } catch (\Exception $e) {
                    Logger::exceptionLog($e);
                    ErrorController::internalServerError();
                } finally {
                    return;
                }
            }
        }
        ErrorController::notFound();
        Logger::log("Route '$uri' not found", Logger::WARNING_LOG);
    }

    /**
     * Add a new route (made private to push using the other methods)
     */
    private function registerRoute(string $method, string $uri, string $action): void 
    {
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = new Route(
            $method,
            $uri,
            $controller,
            $controllerMethod,
        );
    }

    /**
     * Get request method's name (GET, POST, PUT, DELETE)
     */
    private function getRequestMethodName(): string
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        return $requestMethod;
    }


    /** 
     * Check if route is matched with request
     * 
     * @return false if route not matched
     * @return array if route matched and get parameters from it
     */
    private function isRouteMatched(Route $route, string $requestUri, string $requestMethod): array|false
    {
        $uriSegmnets = explode('/', trim($requestUri, '/'));
        $routeSegmnets = explode('/', trim($route->getUri(), '/'));
        $match = false;

        if (
            count($uriSegmnets) !== count($routeSegmnets) || 
            strtoupper($route->getMethod()) !== $requestMethod    
        ) {
            return false;
        }

        $params = [];
        for ($i = 0; $i < count($uriSegmnets); $i++) {
            if (
                $routeSegmnets[$i] !== $uriSegmnets[$i] &&
                !preg_match('/\{(.+?)\}/', $routeSegmnets[$i])
            ) {
                return false;
            }
                    
            if(preg_match('/\{(.+?)\}/', $routeSegmnets[$i], $matches)) {
                $params[$matches[1]] = $uriSegmnets[$i];
            }
        }
        
        return $params;
    }

    /**
     * Call controller's method
     * 
     * @throws RouteException when the class or method does not exist
     */
    private function callMethod(Route $route, array $params): void 
    {
        $controller = 'App\\Controllers\\' . $route->getController();
        if (!class_exists($controller)) {
            throw new RouteException("Class $controller does not exist!");
        }

        $controllerInstance = new $controller();
        if (!$controllerInstance instanceof AbstractController) {
            throw new RouteException("Class $controller does not inherit " . AbstractController::class);
        }

        $controllerMethod = $route->getControllerMethod();
        if (!method_exists($controllerInstance, $controllerMethod)) {
            throw new RouteException("Class $controller does not contain method with name $controllerMethod");
        }

        $controllerInstance->setQuery($_GET);
        $controllerInstance->setRawBody(file_get_contents('php://input'));
        $controllerInstance->$controllerMethod($params);
    }
}
