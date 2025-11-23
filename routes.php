<?php

$router->get(uri:'/', controller: 'HomeController@index');
$router->get(uri: '/listings', controller: 'ListingsController@index');
$router->get(uri: '/listings/create', controller: 'ListingsController@create');
$router->get(uri: '/listing/{id}', controller: 'ListingsController@show');