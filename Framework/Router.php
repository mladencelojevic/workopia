<?php

namespace Framework;

use App\Controllers\ErrorController; // because we used ErrorController::notFound(); down below.
use Framework\Middleware\Authorize;

class Router
{

    public $routes = [];


    public function get($uri, $controller, $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }
    public function post($uri,  $controller, $middleware = [])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }
    public function put($uri, $controller, $middleware = [])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }
    public function delete($uri,  $controller, $middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    public function registerRoute($httpMethod, $uri, $action, $middleware = [])
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'httpMethod' => $httpMethod,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware

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

                    foreach ($route['middleware'] as $middleware) {
                        (new Authorize())->handle($middleware);
                    }
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
