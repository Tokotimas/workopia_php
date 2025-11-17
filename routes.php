<?php

$router->get(uri: '/', controller: 'controllers/home.php');
$router->get(uri: '/listings', controller: 'controllers/listings/index.php');
$router->get(uri: '/listings/create', controller: 'controllers/listings/create.php');