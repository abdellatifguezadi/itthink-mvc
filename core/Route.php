<?php
require_once(__DIR__.'./Router.php');
$router = new Router();
class Route
{
    private static $router;

    /**
     * Attach a router instance
     */
    public static function setRouter($router)
    {
        self::$router = $router;
    }

    /**
     * Register a GET route
     */
    public static function get($route, $callback)
    {
        self::addRoute('GET', $route, $callback);
    }

    /**
     * Register a POST route
     */
    public static function post($route, $callback)
    {
        self::addRoute('POST', $route, $callback);
    }

   

    /**
     * Add the route to the router
     */
    private static function addRoute($method, $route, $callback)
    {
        if (!self::$router) {
            throw new Exception('Router not set. Call Route::setRouter() first.');
        }

        self::$router->add($method, $route, $callback);
    }
}
