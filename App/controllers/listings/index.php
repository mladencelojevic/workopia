<?php

use Framework\Database;

$config = require_once basePath('config/db.php');
$db = new Database($config);
$listings = $db->query("SELECT * FROM listings LIMIT 6")->fetchAll(); // arrows (->) serve the purpose of accessing properties or a method of an object. In here, query() returned a PDOStatement (object) on which we can use fetchAll to access that object.

loadView('listings/index', ['listings' => $listings]);
