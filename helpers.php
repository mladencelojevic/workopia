<?php

function basePath(string $path = ''): string
{
    return __DIR__ . ($path ? DIRECTORY_SEPARATOR . $path : '');
}

// load view

function loadView($name, $data = [])
{
    extract($data);
    require_once basePath("views/{$name}.view.php");
}


function loadPartial($name)
{


    require_once basePath("views/partials/{$name}.php");
}

function inspectAndDie($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}
