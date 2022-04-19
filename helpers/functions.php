<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Src\View;
use Src\Http\Redirect;

/**
 * helper functions
 *
 * @package Helpers
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */

/**
 * Generate a list of var dump
 */
if (! function_exists('dd')):
    function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
endif;

/**
 * Helper to rendering the template engine layout of a page
 *
 * @throws RuntimeError
 * @throws SyntaxError
 * @throws LoaderError
 */
if ( ! function_exists('view')):
    function view(string $path, array $data = [])
    {
        View::renderTemplate($path, $data);
    }
endif;

/**
 * Redirect to another url
 */
if (! function_exists('to')):
    function to($url)
    {
        Redirect::to($url);
    }
endif;