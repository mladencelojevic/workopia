<?php

namespace Framework;


class Router
{

    protected $routes = [];


    public function registerRoute($method, $uri, $controller)
    {
        // routes[] = [] - this adds another element to the existing array. routes = [] - this just overwrittes.
        $this->routes[] = [

            'method' => $method,
            'uri' => $uri,
            'controller' => $controller



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

            if ($route['uri'] === $uri && $route['method'] === $method) {


                require_once basePath('App/' . $route['controller']);
                return;
            }
        }


        http_response_code(404);
        loadView('error/404');
        exit;
    }
}
