<?php

$router->get(uri:'/', controller: 'HomeController@index');
$router->get(uri: '/listings', controller: 'ListingsController@index');
$router->get(uri: '/listings/create', controller: 'ListingsController@create');
$router->get(uri: '/listings/{id}', controller: 'ListingsController@show');
$router->get(uri: '/listings/edit/{id}', controller: 'ListingsController@edit');

$router->post(uri: '/listings', controller: 'ListingsController@store');
$router->delete(uri: '/listings/{id}', controller: 'ListingsController@destroy');
$router->put(uri: '/listings/{id}', controller: 'ListingsController@update');