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

use Exception;
use Src\Http\Request;

/**
 * 
 * @package GiGaFlow\Router
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class RouterFactory
{
  /**
   * Instance Router class and verify if is an instance of RouterInterface.
   *
   * @throws \Exception
   * @throws \UnexpectedValueException
   * @static
   * @return Router
   */
  public static function build(): Router
  {
    $file = dirname(__DIR__) . '/../config/routes.php';
    if (! file_exists($file)) {
      throw new \Exception("File about routing table not found");
    }

    $request = new Request();
    $route = new Router($request);
    if (! $route instanceof RouterInterface) {
      throw new \UnexpectedValueException("Not valid Router object");
    }
    
    include dirname(__DIR__) . '/../config/routes.php';
    $route->match($request->uri());
    
    return $route;
  }
}
