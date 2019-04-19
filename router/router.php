<?php
include_once("./router/route.php");
class Router {
    private $url;
    private $routes;

    public function __construct($url) {
        if (!isset($url) || empty($url))
            throw new Exception("Gone", 410);
        $this->url = $url;
    }

    public function get($path, $callable, $name) {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name) {
        return $this->add($path, $callable, $name, 'POST');
    }

    public function put($path, $callable, $name) {
        return $this->add($path, $callable, $name, 'PUT');
    }

    public function delete($path, $callable, $name) {
        return $this->add($path, $callable, $name, 'DELETE');
    }

    private function add($path, $callable, $name, $method) {
        $route = new Route($path, $callable);
        if (isset($this->routes[$method][$name]))
            throw new Exception("Route already exist", 500);
        $this->routes[$method][$name] = $route;
        return $route;
    }

    public function run() {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
            throw new Exception('Unknown route', 404);

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
            if($route->match($this->url))
                return $route->call();

        throw new Exception('Unknown route', 404);
    }
}
?>