<?php

$router->get(uri: '/', controller: 'controllers/home.php');
$router->get(uri: '/listings', controller: 'controllers/listings/index.php');
$router->get(uri: '/listings/create', controller: 'controllers/listings/create.php');
$router->get(uri: '/listing', controller: 'controllers/listings/show.php');