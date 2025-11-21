<?php declare(strict_types=1);

class Router
{
    protected $routes = [];

    /**
     * Add a new route
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function registerRoute($method, $uri, $controller): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
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
        $this->registerRoute(method: 'GET', uri: $uri, controller: $controller);
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
        $this->registerRoute(method: 'POST', uri: $uri, controller: $controller);
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
        $this->registerRoute(method: 'PUT', uri: $uri, controller: $controller);
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
        $this->registerRoute(method: 'DELETE', uri: $uri, controller: $controller);
    }

    /**
     * Load error page
     * @param int $httpCode
     * @return void
     */

    public function error($httpCode = 404): void
    {
        http_response_code(response_code: $httpCode);
        loadView(name: "error/{$httpCode}");
        exit;
    }
    /**
     * Route the eequest
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */

    public function route($uri, $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                require basePath(path: $route['controller']);
                return;
            }
        }
        $this->error();
    }
};