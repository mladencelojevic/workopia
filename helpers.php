<?php

function basePath(string $path = ''): string
{
    return __DIR__ . ($path ? DIRECTORY_SEPARATOR . $path : '');
}

// load view

function loadView($name, $data = [])
{
    extract($data);
    require_once basePath("App/views/{$name}.view.php");
}


function loadPartial($name, $data = [])
{

    extract($data);
    require_once basePath("App/views/partials/{$name}.php"); // $data can be used in this view.
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

function sanitize($dirty)
{
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS); // cleans up special characters, like <, >, ", ', & that can be injected in a form as a code.
}


function redirect($url)
{

    header("Location: {$url}");
    exit;
}
