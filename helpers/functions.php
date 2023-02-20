<?php
/*
 * This file is part of the GiGaCMS package.
 *
 * (c) Giuseppe Galari <gigaprog@proton.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Src\View;
use Src\Http\Redirect;

/**
 * helper functions
 *
 * @package Helpers
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */

/**
 * Generate a list of var dump
 * @param mixed $data
 */
if (! function_exists('dd')) :
  function dd(mixed $data)
  {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
  }
endif;

/**
 * Helper to rendering the layout of a page.
 * 
 * @param string $path
 * @param array $data
 * @throws \Exception
 */
if (! function_exists('view')) :
  function view(string $path, array $data = [])
  {
    View::render($path, $data);
  }
endif;

/**
 * Redirect to another url.
 * 
 * @param string $url
 */
if (! function_exists('redirect')) :
  function redirect(string $url)
  {
    Redirect::to($url);
  }
endif;

/**
 * Get back.
 *
 * @return void
 */
if (! function_exists('back')) :
  function back()
  {
    Redirect::back();
  }
endif;

/**
 * generate a slug.
 *
 * @param string $value
 * @return string
 */
if (!function_exists('slug')) :
  function slug(string $value)
  {
    return strtolower(str_replace(' ', '-', $value));
  }
endif;

/** 
 * Set date.
 * 
 * @return mixed
*/
if (!function_exists('setDate')) :
  function setDate()
  {
    return date('Y-m-d H:i:s', time());
  }
endif;
