<?php

namespace App\src\Core;

use App\src\Core\Http\{
    Request,
    Response
};

class Router
{
    protected array $routes = [];

    public function addRoute(string $method, string $pattern, object $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    public function run(): void
    {
        $request = new Request();
        $response = new Response();
        
        $url = (parse_url($_SERVER['REQUEST_URI']))["path"];
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach($this->routes as $route) {
            if ($route['method'] == $method && preg_match($route['pattern'], $url, $matches)) {
                $callback = $route['callback'];
                $params = array_slice($matches, 1);
                $callback($response, $request, ...$params);
            }
        }
    }
}