<?php

$routes = require_once basePath('routes.php'); // contains array of routes


if (array_key_exists($uri, $routes)) {
    require_once basePath($routes[$uri]);
} else {
    http_response_code(404); // necessary, because dev tool will not make the page as an error. 
    require_once basePath($routes['404']);
}
