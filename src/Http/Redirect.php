<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Src\Http;

/**
 * manage redirect to another url
 *
 * @package Src
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class Redirect
{
    /**
     * @param $path
     */
    public static function to($path)
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$path");

    }

    /**
     * Redirect to back page
     */
    public static function back()
    {
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}