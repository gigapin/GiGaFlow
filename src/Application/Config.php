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

namespace Src\Application;

/**
 * Variables of configuration of the application
 *
 * @package Src\Application
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class Config
{
    /** @var string PHP Version required */
    public static string $phpVersion = "7.4";

    /** @var string Version about application */
    public static string $appVersion = "1.0";

    /** @var int Setting time life of the cookies */
    public static int $cookie_lifetime = 86400;

}