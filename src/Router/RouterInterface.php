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

/**
 * 
 * @package GiGaFlow\Router
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
interface RouterInterface
{

  /**
   * Add a route to the routing table
   * @param string $route
   * @param array $params
   * @return mixed
   */
  public function map(string $route, array $params): mixed;

  /**
   * Dispatch route and create controller objects and execute the default method
   * on that controller object
   *
   * @param string $controller
   * @param string $action
   * @param array|null $params
   * @return void
   */
  public function dispatch(string $controller, string $action, string|null $params): void;

  /**
   * Match the route to the routes in the routing table, setting the $this->params property
   * if a route is found
   *
   * @param string $url
   * @return mixed
   * @throws Exception
   */
  public function match(string $url): mixed;
}
