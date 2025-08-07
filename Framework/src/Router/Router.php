<?php

namespace Framework\Router;

use Framework\Authorization\IAuthorizationService;
use Framework\Controllers\AbstractController;
use Framework\Controllers\AbstractErrorController;
use Framework\DependencyInjection\Container;
use Framework\Exceptions\ForbiddenException;
use Framework\Exceptions\RouteException;
use Framework\Logger\ILogService;
use Framework\Logger\LogType;
use Framework\Session\ISession;

class Router implements IRouter {
    /** @var Route[] $routes */
    protected array $routes = [];

    public function __construct(
        private readonly ILogService $logService,
        private readonly ISession $session,
        private readonly IAuthorizationService $authorizationService,
    ) {
        $this->session->start();
     }

    public function get(string $uri, string $controller, array|string $authorizedRoles = '*'): void 
    {
        $this->registerRoute('GET', $uri, $controller, $authorizedRoles);
    }

    public function post(string $uri, string $controller, array|string $authorizedRoles = '*'): void
    {
        $this->registerRoute('POST', $uri, $controller, $authorizedRoles);
    }

    public function put(string $uri, string $controller, array|string $authorizedRoles = '*'): void 
    {
        $this->registerRoute('PUT', $uri, $controller, $authorizedRoles);
    }
        
    public function delete(string $uri, string $controller, array|string $authorizedRoles = '*'): void 
    {
        $this->registerRoute('DELETE', $uri, $controller, $authorizedRoles);
    }

    public function route(string $uri): void 
    {
        $requestMethod = $this->getRequestMethodName();

        foreach($this->routes as $route) {
            $params = $this->isRouteMatched($route, $uri, $requestMethod);
            
            if ($params !== false) {
                try {
                    $this->checkIfAuthorized($route);
                    $this->callMethod($route, $params);
                } catch (ForbiddenException) {
                    $this->callErrorMethod(401, 'forbidden');
                } catch (\Exception $e) {
                    $this->logService->exceptionLog($e);
                    $this->callErrorMethod(500, 'internal server error');
                } finally {
                    return;
                }
            }
        }
        $this->callErrorMethod(404, 'not found');
        $this->logService->log("Route '$uri' not found", LogType::WARNING);
    }

    /**
     * Add a new route (made private to push using the other methods)
     */
    private function registerRoute(string $method, string $uri, string $action, array|string $authorizedRoles): void 
    {
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = new Route(
            $method,
            $uri,
            $controller,
            $controllerMethod,
            $authorizedRoles,
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
        $controllerName = $route->getController();
        $controller = Container::get($route->getController());
        
        if (!$controller instanceof AbstractController) {
            throw new RouteException("Class $controllerName does not inherit " . AbstractController::class);
        }

        $controllerMethod = $route->getControllerMethod();
        if (!method_exists($controller, $controllerMethod)) {
            throw new RouteException("Class $controllerName does not contain method with name $controllerMethod");
        }

        $controller->setQuery($_GET);
        $controller->setRawBody(file_get_contents('php://input'));
        $controller->$controllerMethod(...$params);
    }

    /**
     * Check if the route can be accessed through Authorization Service
     * 
     * @throws ForbiddenException when the user cannot access respective endpoint
     */
    private function checkIfAuthorized(Route $route): void
    {
        if (!$this->authorizationService->isAuthorized($route)) {
            throw new ForbiddenException('User is not allowed');
        }
    }

    private function callErrorMethod(string $code, string $message): void
    {
        $errorController = Container::getClass(AbstractErrorController::class);
        $errorController->renderError($message, $code);
    }
}
