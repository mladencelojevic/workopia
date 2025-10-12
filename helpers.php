<?php

echo __DIR__;
function basePath(string $path = ''): string
{
    return __DIR__ . ($path ? DIRECTORY_SEPARATOR . $path : '');
}
