<?php
require_once "../helpers.php";

$uri = $_SERVER['REQUEST_URI'];

require_once basePath('router.php'); // contains array of routes and condition
