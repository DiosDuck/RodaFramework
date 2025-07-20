<?php

namespace Framework\Router;

use App\Controllers\ErrorController;
use Framework\Controllers\AbstractController;
use Framework\DependencyInjection\Container;
use Framework\Exceptions\RouteException;
use Framework\Logger\ILogService;
use Framework\Logger\LogType;
use Framework\Session\ISession;

class Router implements IRouter {
    /** @var Route[] $routes */
    protected array $routes = [];

    public function __construct(
        private ILogService $logService,
        private ISession $session,
    ) { }

    public function get(string $uri, string $controller): void 
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): void
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    public function put(string $uri, string $controller): void 
    {
        $this->registerRoute('PUT', $uri, $controller);
    }
        
    public function delete(string $uri, string $controller): void 
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    public function route(string $uri): void 
    {
        $requestMethod = $this->getRequestMethodName();

        foreach($this->routes as $route) {
            $params = $this->isRouteMatched($route, $uri, $requestMethod);
            
            if ($params !== false) {
                try {
                    $this->callMethod($route, $params);
                } catch (\Exception $e) {
                    $this->logService->exceptionLog($e);
                    ErrorController::internalServerError();
                } finally {
                    return;
                }
            }
        }
        ErrorController::notFound();
        $this->logService->log("Route '$uri' not found", LogType::WARNING);
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
}
