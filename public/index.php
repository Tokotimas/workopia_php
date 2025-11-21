<?php declare(strict_types=1);
require '../helpers.php';
require basePath(path: 'Database.php');
require basePath(path: 'Router.php');

// Instatiating the router
$router = new Router();

// Get routes
$routes = require basePath(path: 'routes.php');

// Get current URI and HTTP method
$uri = parse_url(url: $_SERVER['REQUEST_URI'], component: PHP_URL_PATH) ?? '';
$method = $_SERVER['REQUEST_METHOD'] ?? '';

// Route the request
$router->route(uri: $uri, method: $method);

