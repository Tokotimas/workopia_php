<?php

$router->get(uri:'/', controller: 'HomeController@index');
$router->get(uri: '/listings', controller: 'ListingsController@index');
$router->get(uri: '/listings/create', controller: 'ListingsController@create', middleware: ['auth']);
$router->get(uri: '/listings/{id}', controller: 'ListingsController@show');
$router->get(uri: '/listings/edit/{id}', controller: 'ListingsController@edit', middleware: ['auth']);

$router->post(uri: '/listings', controller: 'ListingsController@store', middleware: ['auth']);
$router->delete(uri: '/listings/{id}', controller: 'ListingsController@destroy', middleware: ['auth']);
$router->put(uri: '/listings/{id}', controller: 'ListingsController@update', middleware: ['auth']);

$router->get(uri: '/auth/register', controller: 'UserController@create', middleware: ['guest']);
$router->get(uri: '/auth/login', controller: 'UserController@login', middleware: ['guest']);

$router->post(uri: '/auth/register', controller: 'UserController@store', middleware: ['guest']);
$router->post(uri: '/auth/logout', controller: 'UserController@logout', middleware: ['auth']);
$router->post(uri: '/auth/login', controller: 'UserController@authenticate', middleware: ['guest']);