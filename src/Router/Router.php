<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@protonmail.com>
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
 * @author GiGa <gigaprog@protonmail.com>
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
     * Match the route to the routes in the routing table, setting the $this->params property
     * if a route is found
     *
     * @param $url
     * @return bool
     */
    public function match($url): bool
    {
        foreach ($this->routes as $route => $param) {
            // $param get route table 1. controller 2. action
            if (preg_match($route, $url, $matches)) {
                // Explode the url matched
                $routeParams = explode("/", $matches[0]);
                // First value is always the controller
                $this->params['controller'] = $routeParams[0];

                if ($routeParams[1] === null && $param[1] === 'index') {
                    // If the url haven't second parameter and into route table the action is index
                    // it going to call index method
                    $this->params['action'] = 'index';
                } elseif ($routeParams[1] !== null && $param[1] === $routeParams[1]) {
                    $this->params['action'] = $routeParams[1];
                    // Check if exists a third param and set it within wildcard key
                    if (isset($routeParams[2])) {
                        $this->params['wildcard'] = $matches[1];
                    }
                } elseif ($routeParams[1] !== null && $param[1] !== $routeParams[1]) {
                    $this->params['action'] = $routeParams[2];
                    $this->params['wildcard'] = $matches[1];
                } else {
                    throw new \UnexpectedValueException('Invalid value inserted into routing table');
                }

                if (isset($param['namespace'])) {
                    $this->params['namespace'] = $param['namespace'];
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Set namespace
     *
     * @return false|mixed
     */
    protected function getNameSpace()
    {
        if (isset($this->params['namespace'])) {
            $class = ucfirst($this->params['namespace']);
            if (is_dir("../app/Controllers/$class")) {
                return $this->params['namespace'];
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     *
     * @param $url
     * @throws Exception
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);
        
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            
            if (false !== $this->getNameSpace()) {
                $classController = $this->namespace . ucfirst($this->getNameSpace()) . '\\' . ucfirst($controller) . $this->controllerSuffix;
            } else {
                $classController = $this->namespace . ucfirst($controller) . $this->controllerSuffix;
            }

            if (class_exists($classController)) {
                $obj = new $classController;
                $action = $action . $this->actionSuffix;
                if (method_exists($obj, $action)) {
                    call_user_func_array([$obj, $action], $this->params);
                } else {
                    throw new Exception("Method not found");
                }
            } else {
                throw new Exception("Class not found");
            }
        } else if($url === 'index.php') {
            if ($this->match(''))  {
                $classController = $this->namespace . ucfirst($this->defaultController);
                if (class_exists($classController)) {
                    $obj = new $classController;
                    if (method_exists($obj, $this->defaultAction)) {
                        call_user_func_array([$obj, $this->defaultAction], $this->params);
                    } else {
                        throw new Exception("Method not found");
                    }
                } else {
                    throw new Exception("Class not found");
                }
            }
        } else {
            throw new Exception('No route matched', 404);
        }

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