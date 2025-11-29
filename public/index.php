<?php declare(strict_types=1);
require __DIR__ .'/../vendor/autoload.php';

use Framework\Router;
use Framework\Session;

Session::start();

require '../helpers.php';

// Instatiating the router
$router = new Router();

// Get routes
$routes = require basePath(path: 'routes.php');

// Get current URI and HTTP method
$uri = parse_url(url: $_SERVER['REQUEST_URI'], component: PHP_URL_PATH) ?? '';

// Route the request
$router->route(uri: $uri);

