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

use Exception;

/**
 * Instance Router class.
 *
 * @package Src\Router
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class RouterFactory
{
    /**
     * Instance Router class and verify if is an instance of RouterInterface.
     *
     * @throws Exception
     *
     *  @return Router
     */
    public static function build(): Router
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/../config/routes.php';

        if (! file_exists($file)) {
            throw new Exception("File about routing table not found");
        }

        $route = new Router();
        if ( ! $route instanceof RouterInterface) {
            throw new \UnexpectedValueException("Not valid Router object");
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/../config/routes.php';
        $route->dispatch($_SERVER['QUERY_STRING']);

        return $route;
    }

}