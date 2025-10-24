<?php
session_start();
require_once __DIR__ . "/../helpers.php";
require_once __DIR__ . '/../vendor/autoload.php';

use Framework\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
$router->get('/listings/edit/{id}', 'ListingController@edit'); // just showing edit form


$router->post('/listings', 'ListingController@store');
$router->put('/listings/{id}', 'ListingController@update'); // when we submit the form.
$router->get('/listings/{id}', 'ListingController@show');
$router->delete('/listings/{id}', 'ListingController@destroy');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // /listings/2
$router->dispatch($uri);
