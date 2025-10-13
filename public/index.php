<?php
require_once "../helpers.php";


require_once basePath('Router.php'); // contains array of routes and condition
$router = new Router();
$routes = require_once basePath('routes.php');
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD']; // GET OR POST


$router->route($uri, $method);
