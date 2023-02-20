<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@proton.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Src\Router;

use \Exception;
use Src\Http\Request;

/**
 * 
 * @package GiGaFlow\Router
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 * @see RouterInterface
 */
class Router implements RouterInterface
{
  /** 
   * Classes and methods to process in order to url matched by route.
   * 
   * @access protected
   * @var array 
   */
  protected array $params = [];

  /** 
   * Routes to process.
   * 
   * @access protected 
   * @var array  
   */
  protected array $routes = [];

  /**
   * Create a new instance of Request class.
   *
   * @access protected
   * @var object
   */
  protected object $request;

  /**
   * Constructor.
   *
   * @param Request $request
   */
  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  /**
   * @inheritDoc
   *
   * @param string $route
   * @param string $params
   * @return array
   */
  public function map(string $route, array $params): array
  {
    $route = preg_replace('/\//', '\\/', $route);
    $route = preg_replace("/{([a-z]+)}/", "([a-z0-9\-]+)", $route);
    $regexRoute = "/^" . $route . "$/";
    $this->routes[$regexRoute][] = $params;

    return $this->routes;
  }

  /**
   * Mapping GET method request.
   *
   * @param string $path
   * @param array $params
   * @return mixed
   */
  public function get(string $path, array $params): mixed
  {
    if ($this->request->method() === 'get') {
      return $this->map($path, $params);
    }

    return null;
  }

  /**
   * Mapping POST method request.
   *
   * @param string $path
   * @param array $params
   * @return mixed
   */
  public function post(string $path, array $params): mixed
  {
    if ($this->request->method() === 'post') {
      return $this->map($path, $params);
    }

    return null;
  }

  /**
   * Mapping PUT method request.
   *
   * @param string $path
   * @param array $params
   * @return mixed
   */
  public function put(string $path, array $params): mixed
  {
    if ($this->request->method() === 'put') {
      $this->map($path, $params);
    }

    return null;
  }

  /**
   * Mapping PATCH method request.
   *
   * @param string $path
   * @param array $params
   * @return mixed
   */
  public function patch(string $path, array $params): mixed
  {
    if ($this->request->method() === 'patch') {
      $this->map($path, $params);
    }

    return null;
  }

  /**
   * Mapping DELETE method request.
   *
   * @param string $path
   * @param array $params
   * @return mixed
   */
  public function delete(string $path, array $params): mixed
  {
    if ($this->request->method() === 'delete') {
      $this->map($path, $params);
    }
    
    return null;
  }

  public function option(string $path, array $params)
  {
    if ($this->request->method() === 'options') {
      header('Access-Control-Allow-Methods: POST, OPTIONS');
      header('Access-Control-Allow-Headers: Content-Type');
      header('Access-Control-max-Age: 86400');
      $this->map($path, $params);
    }
  }

  /**
   * @inheritDoc
   *
   * @param string $url
   * @return mixed
   * @throws Exception
   */
  public function match(string $url): mixed
  {
    $paramValue = null;
    
    foreach ($this->routes as $route => $param) {
      // $param get route table 1. controller 2. action
      if (preg_match($route, $url, $matches)) {
        if (in_array($this->request->uri(), $matches)) {
          $controller = $this->routes[$route][0][0];
          
          if (isset($matches[0])) {
            $action = $param[0][1];
          } else {
            $action = $this->routes[$route][0][1];
          }
          if (isset($matches[1])) {
            $paramValue = $matches[1];
          }
          
          return $this->dispatch($controller, $action, $paramValue);
        }
      }
    }
  }

  /**
   * @inheritDoc
   *
   * @param string $controller
   * @param string $action
   * @param string|null $params
   * @throws Exception
   */
  public function dispatch(string $controller, string $action, string|null $params): void
  {
    if (class_exists($controller)) {
      $obj = new $controller();
      if (method_exists($obj, $action)) {
        call_user_func_array([$obj, $action], [$params]);
      } else {
        throw new \Exception("Method not found");
      }
    } else {
      dd($controller);
      throw new \Exception("Class not found");
    }
  }
}
