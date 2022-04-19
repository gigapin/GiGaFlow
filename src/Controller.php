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

namespace Src;

use Exception;
use Src\Http\Request;

/**
 * Controller class to extends at all controllers classes.
 *
 * @package Src
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
abstract class Controller
{
    /**
     * Display rendering about page called in controller.
     *
     * @param string $path
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function view(string $path, array $data = [])
    {
        return View::render($path, $data);
    }

    /**
     * Instance Request class.
     *
     * @return Request
     */
    public function request(): Request
    {
        if (class_exists('Src\Http\Request')) {
            return new Request;
        }
    }

    /**
     * Get data from a POST request.
     *
     * @param string $value
     * @return string
     */
    public function post(string $value): string
    {
        return Request::post($value);
    }

    /**
     * Get data from a GET request.
     *
     * @param string $value
     * @return string
     */
    public function get(string $value): string
    {
        return Request::get($value);
    }

}
