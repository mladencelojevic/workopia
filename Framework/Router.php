<?php

namespace Framework;

use App\Controllers\ErrorController; // because we used ErrorController::notFound(); down below.

class Router
{

    protected $routes = [];


    public function registerRoute($httpMethod, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'httpMethod' => $httpMethod,  // HTTP verb
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod // method inside controller
        ];
    }





    public function get(string $uri, string $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }
    public function post(string $uri, string $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }
    public function put(string $uri, string $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }
    public function delete(string $uri, string $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri && $route['httpMethod'] === $method) {

                $controllerClass = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

                $controllerInstance = new $controllerClass();
                $controllerInstance->$controllerMethod();

                return; // as soon as url matches, if condition is run and this whole function stops right here where we have the 'return' keyword. If we don't have a match in the 'if' statement, foreach is not even triggered and we don't go inside where the 'return' statement is, so, code will naturally go into the next line which is error printing.
            }
        }


        ErrorController::notFound();
    }
}
