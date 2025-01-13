<?php

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function add($method, $route, $callback)
    {
        $method = strtoupper($method);
        $route = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
        $this->routes[$method][$route] = $callback;
    }

    public function dispatch($uri, $method)
    {
        // Remove query strings
        $uri = parse_url($uri, PHP_URL_PATH);
        $method = strtoupper($method);

        foreach ($this->routes[$method] as $route => $callback) {
            if (preg_match('#^' . $route . '$#', $uri, $matches)) {
                array_shift($matches);

                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $method = $callback[1];
                    return call_user_func_array([$controller, $method], $matches);
                }

                return call_user_func_array($callback, $matches);
            }
        }

        // Handle 404
        http_response_code(404);
        echo "404 - Not Found";
    }
}
