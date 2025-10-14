<?php

$config = require_once basePath('config/db.php');
$db = new Database($config);
$listings = $db->query("SELECT * FROM listings LIMIT 6")->fetchAll(); // arrows (->) serve the purpose of accessing properties or a method of an object. In here, query() returned a PDOStatement (object) on which we can use fetchAll to access that object.

loadView('home', ['listings' => $listings]); // extract in the loadView function will make it so the second parameter array and key inside of it becomes a variable, so $listings. Now, that listings can be used in the home.view.php. $listings = array(6) {[0]=>array(15) {["id"]=>... [1]=>array(15) {["id"]=>
