<?php

use Framework\Database;

$config = require_once basePath('config/db.php');
$db = new Database($config);

$id = $_GET['id'] ?? '';

$params = [
    'id' => $id
];


$listing = $db->query("SELECT * FROM listings WHERE id = :id", $params)->fetch();
loadView('listings/show', ['listing' => $listing]); 
/* 

Before, we used this: 
    $stmt->execute([
    'title' => $title,
    'body' => $body,
    'id' => $id
]);
Now, we are using $params array because it gives us more flexibility:
example:
$params = [
    'title' => $title,
    'price' => $price,
    'id' => $id
];

$db->query(
    "UPDATE listings SET title = :title, price = :price WHERE id = :id",
    $params
);



*/
