<?php
// can go in init:
session_start();
require_once __DIR__ . "/../helpers.php";
require_once __DIR__ . '/../vendor/autoload.php';
//

use Framework\Router;
use Framework\Session;

Session::start();

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($uri);
