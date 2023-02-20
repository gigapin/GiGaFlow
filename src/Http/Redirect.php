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

namespace Src\Http;

/**
 * @package GiGaFlow\Http
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class Redirect
{
    /**
     * Redirect to a new path.
     * 
     * @param string $path
     * @return void
     */
    public static function to(string $path): void
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$path");
    }

    /**
     * Go back page.
     * 
     * @return void
     */
    public static function back(): void
    {
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}