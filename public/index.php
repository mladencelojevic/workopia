<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once "../helpers.php";


use Framework\Router;

// Instantiating Router
$router = new Router();

// Get routes
$routes = require_once basePath('routes.php');

// Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // /listings?id=2 when we type this in the url, it will say it cannot find that route, but with parse_url, it will ignore the query part (?id=2) and just take /listings as the correct path. 
$method = $_SERVER['REQUEST_METHOD']; // GET OR POST

// Route the request
$router->route($uri, $method);
