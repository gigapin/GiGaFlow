<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src\Router;

use http\Exception\UnexpectedValueException;
use Exception;

/**
 * Manage routing table and dispatch the http requests to application
 *
 * @package Src\Router
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class Router implements RouterInterface
{
    /** @var array */
    protected array $params;

    /** @var array  */
    protected array $routes;

    /** @var string  */
    protected string $defaultController = "HomeController";

    /** @var string  */
    protected string $defaultAction = "indexAction";

    /** @var string  */
    protected string $controllerSuffix = "Controller";

    /** @var string  */
    protected string $actionSuffix = "Action";

    /** @var string  */
    protected string $namespace = "App\Controllers\\";


    /**
     * @inheritDoc
     *
     * @param string $routes
     * @param string $params
     * @param string|null $namespace
     * @return array
     */
    public function map(string $routes, string $params, string $namespace = null): array
    {
        $routes = preg_replace('/\//', '\\/', $routes);
        $routes = preg_replace("/{([a-z]+)}/", "([a-z0-9]+)", $routes);
        $regexRoute = "/^" . $routes . "$/";
        $param = explode('@', $params);
        $this->routes[$regexRoute] = $param;
        if ($namespace !== null) {
            $this->routes[$regexRoute]['namespace'] = $namespace;
        }
        
        return $this->routes;
    }

    /**
     * Set namespace
     *
     * @return 
     */
    protected function getNamespace($controller)
    {
        foreach($this->routes as $route) {
            if (in_array($controller, $route)) {
                if (isset($route['namespace'])) {
                    return "App\Controllers\\" . ucfirst($route['namespace']) . "\\";
                }
                
            }
        }
       
        return $this->namespace;
        
    }

    /**
     * Match the route to the routes in the routing table, setting the $this->params property
     * if a route is found
     *
     * @param $url
     * @return bool
     */
    public function match($controller, $action, $param)
    {
        $class = $this->getNamespace($controller) . $controller;
        if (class_exists($class)) {
            $instanceOfClass = new $class();
            if (method_exists($instanceOfClass, $action)) {
                call_user_func_array([$instanceOfClass, $action], [$param]);
            }
        } else {
            echo "Class not found";
        }
       
    }


    /**
     * @param string $path
     * 
     * @return [type]
     */
    public function dispatch(string $path)
    {
        $url = explode('/', $path);
        
        foreach ($this->routes as $k => $route) {
            if (preg_match($k, $path)) {
                $controller = $route[0];
                $action = $route[1];
                if (isset($url[3])) {
                    $param = $url[3];
                } else {
                    $param = "";
                }
            } 
        }

        return $this->match($controller, $action, $param);       
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove query string variables
     *
     * @param string $url
     * @return mixed|string
     */
    protected function removeQueryStringVariables(string $url) : string
    {
        if ($url != 'index.php') {
            $partUrl = explode('&', $url, 3);
            if (strpos($partUrl[1], '=') === false) {
                $url = $partUrl[1];
            } else {
                $url = '';
            }
        }

        return $url;
    }

}