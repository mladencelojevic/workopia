<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create', ['auth']);
$router->get('/listings/edit/{id}', 'ListingController@edit', ['auth']);
$router->get('/listings/{id}', 'ListingController@show');

$router->post('/listings', 'ListingController@store', ['auth']);
$router->put('/listings/{id}', 'ListingController@update', ['auth']);
$router->delete('/listings/{id}', 'ListingController@destroy', ['auth']);

$router->get('/auth/create', 'UserController@create', ['guest']); // we don't want the user to go to this if they are logged in. 
$router->get('/auth/login', 'UserController@login', ['guest']); // we don't want the user to go to this if they are logged in. 

$router->post('/auth/register', 'UserController@store');

$router->post('/auth/logout', 'UserController@logout');

$router->post('/auth/login', 'UserController@authenticate');
