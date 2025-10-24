<?php

namespace Framework;

use App\Controllers\ErrorController; // because we used ErrorController::notFound(); down below.

class Router
{

    public $routes = [];


    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }
    public function post($uri,  $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }
    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }
    public function delete($uri,  $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    public function registerRoute($httpMethod, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action); // example: [ListingController, create]

        $this->routes[] = [
            'httpMethod' => $httpMethod,  // GET / POST / DELETE / PUT
            'uri' => $uri, // /listings/create
            'controller' => $controller, // ControllerClasses
            'controllerMethod' => $controllerMethod // method inside controller
        ];
    }
    public function dispatch($uri)
    {

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod === 'POST' && isset($_POST['_method'])) {

            // Override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']); // DELETE, because the value attribute of the hidden input is 'DELETE'.


        }




        $uriSegments = explode('/', trim($uri, '/'));

        foreach ($this->routes as $route) {

            $routeSegments = explode('/', trim($route['uri'], '/'));
            $match = false;


            if (count($uriSegments) === count($routeSegments) && strtoupper($route['httpMethod']) === $requestMethod) {
                $params = [];
                $match = true;


                for ($i = 0; $i < count($uriSegments); $i++) {


                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }


                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }


                if ($match) {
                    $controllerClass = 'App\\Controllers\\' . $route['controller'];

                    $controllerMethod = $route['controllerMethod'];

                    $controllerInstance = new $controllerClass();
                    $controllerInstance->$controllerMethod($params);

                    return;
                }
            }
        }


        ErrorController::notFound();
    }
}
