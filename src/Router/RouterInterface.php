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

/**
 * Declaration about two methods to implements in Router class
 *
 * @package Src\Router
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
interface RouterInterface
{

    /**
     * Add a route to the routing table
     * @param string $routes
     * @param string $params
     * @return mixed
     */
    public function map(string $routes, string $params);

    /**
     * Dispatch route and create controller objects and execute the default method
     * on that controller object
     *
     * @param string $url
     * @return mixed
     */
    public function dispatch(string $url);

}