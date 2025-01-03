

<?php

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => [],
 
    ];

    // Add a route
    public function add($method, $route, $callback)
    {
        $method = strtoupper($method);

        // Convert the route to a regex for dynamic parameters
        $route = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);

        $this->routes[$method][$route] = $callback;
    }

    // Dispatch the route

    public function dispatch($uri, $method)
    {
        // Remove query strings
        $uri = parse_url($uri, PHP_URL_PATH);
        $method = strtoupper($method);

        foreach ($this->routes[$method] as $route => $callback) {
            // Check if the route matches
            if (preg_match('#^' . $route . '$#', $uri, $matches)) {
                array_shift($matches); // Remove the full match

                // Check if the callback is an array (controller and method)
                if (is_array($callback)) {
                    // Make sure the controller is an instance
                    $controller = new $callback[0]();
                    $method = $callback[1];

                    // Call the controller method
                    return call_user_func_array([$controller, $method], $matches);
                }

                // Otherwise, call the callback directly
                return call_user_func_array($callback, $matches);
            }
        }

        // Handle 404
        http_response_code(404);
     	  echo "404 - Not Found";
    }
}
