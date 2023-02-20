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

namespace Src\Application;

/**
 * 
 * @package GiGaFlow\Config
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class Config
{
    /** 
     * PHP Version required.
     * 
     * @static
     * @var string  $phpVersion
     */
    public static string $phpVersion = "7.4";

    /** 
     * Version of the application.
     * 
     * @var string $appVersion
     * @static
     */
    public static string $appVersion = "1.0";

    /** 
     * Setting time life of the cookies.
     * 
     * @static
     * @var int $cookie_lifetime
     */
    public static int $cookie_lifetime = 86400;

}