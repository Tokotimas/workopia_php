<?php declare(strict_types=1);

namespace Framework;

use App\Controllers\ErrorController;

class Router
{
    protected $routes = [];

    /**
     * Add a new route
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action): void
    {
        list($controller, $controllerMethod) = explode(separator: '@', string: $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function get(string $uri, string $controller): void
    {
        $this->registerRoute(method: 'GET', uri: $uri, action: $controller);
    }

    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function post(string $uri, string $controller): void
    {
        $this->registerRoute(method: 'POST', uri: $uri, action: $controller);
    }

    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function put(string $uri, string $controller): void
    {
        $this->registerRoute(method: 'PUT', uri: $uri, action: $controller);
    }

    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function delete(string $uri, string $controller): void
    {
        $this->registerRoute(method: 'DELETE', uri: $uri, action: $controller);
    }

    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */

    public function route($uri): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // Split the current URI into segments
            $uriSegments = explode(separator: '/', string: trim(string: $uri, characters: '/'));

            // Split the route URI into segments
            $routeSegments = explode(separator: '/', string: trim(string: $route['uri'], characters: '/'));

            // Split the route URI into segments
            $routeSegments = explode(separator: '/', string: trim(string: $route['uri'], characters: '/'));

            $match = true;

            if (count(value: $uriSegments) === count(value: $routeSegments) && strtoupper(string: $route['method']) === $requestMethod) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count(value: $uriSegments); $i++) {
                    // If the uri's do not match and there is no param
                    
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match(pattern: '/\{(.+?)\}/', subject: $routeSegments[$i])) {
                        $match = false;
                        break;
                    }
                    // Check for the param and add to $params array
                    if (preg_match(pattern: '/\{(.+?)\}/', subject: $routeSegments[$i], matches: $matches)) {
                        //inspectAndDie($params);
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instatiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }

            }
        }
        ErrorController::notFound();
    }
};