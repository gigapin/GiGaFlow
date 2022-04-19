<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Src;

use Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Rendering pages of the application
 *
 * @package Src
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class View
{
    /**
     * Rendering page ao the application
     *
     * @param string $path
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public static function render(string $path, array $data = [])
    {
        extract($data, EXTR_SKIP);
        $realPath = realpath(__DIR__ . "/../app/Views/" . $path . ".php");
        if (file_exists($realPath) && is_readable($realPath)) {
            return require __DIR__ . "/../app/Views/$path.php";
        } else {
            throw new Exception("$realPath not found");
        }
    }

    /**
     * Rendering with Twig Template
     *
     * @param $template
     * @param array $args
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function renderTemplate($template, array $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new FilesystemLoader(__DIR__ . '/../app/Views');
            $twig = new Environment($loader);
        }

        echo $twig->render($template, $args);
    }


    /**
     * @param $exception
     * @throws Exception
     */
    public static function show404($exception)
    {
        self::render('errors/show404', compact('exception'));
    }

    /**
     * @param array $exception
     * @throws Exception
     */
    public static function show500(array $exception = [])
    {
        self::render('errors/show500', ['exception' => $exception]);
    }

    /**
     * @throws Exception
     */
    public static function showError(array $errors = [])
    {
        self::render('errors/error', ['errors' => $errors]);
    }

    /**
     * @throws Exception
     */
    public static function showErrorException($exception)
    {
        self::render('errors/errorException', compact('exception'));
    }

    /**
     * @throws Exception
     */
    public static function showException($exception)
    {
        self::render('errors/showException', compact('exception'));
    }
}
