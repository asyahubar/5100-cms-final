<?php

namespace Cookbook\Core;


class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function get($route, $controller, $auth = false)
    {
        $this->routes['GET'][$route] = [$controller, $auth];
    }

    public function post($route, $controller, $auth = false)
    {
        $this->routes['POST'][$route] = [$controller, $auth];
    }

    public function direct($uri, $requestMethod) {
        // dd($_SESSION['auth']);
        if(array_key_exists($uri, $this->routes[$requestMethod])) {
            if($this->routes[$requestMethod][$uri][1]) {
                if($_SESSION['auth']){
                    $this->callAction(...explode('@', $this->routes[$requestMethod][$uri][0]));
                }else{
                    return redirect("/admin/login");
                }
            }else{
                $this->callAction(...explode('@', $this->routes[$requestMethod][$uri][0]));
            }
            //require $this->routes[$requestMethod][$uri];
        } else {
            require "views/404.view.php";
        }
    }

    public function callAction($controller, $method) {
        $c = "\\App\\Controllers\\{$controller}";
        $c = new $c;

        if(!method_exists($c, $method)) {
            throw new \Exception('No method');
        }
        return $c->$method();
    }
}