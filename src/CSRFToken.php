<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src;

use Exception;
use Src\Session\Session;

/**
 * Generate a CSRF Token to avoid cross-site request forgery
 *
 * @package Src
 * @author GiGa <gigaprog@protonmail.com>
 * @version 1.0.0
 */
class CSRFToken
{
    /**
     * Generate a CSRF Token.
     *
     * @return mixed
     * @throws Exception
     */
    public static function token()
    {
        if ( ! Session::has('token')) {
            $token = base64_encode(openssl_random_pseudo_bytes(32));
            Session::set('token', $token);
        }

        return Session::get('token');
    }

    /**
     * Verify if CSRF Token match token session value.
     *
     * @throws Exception
     */
    public static function verifyToken()
    {
        if ( ! isset($_SESSION['token']) || $_SESSION['token'] !== self::token()) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
            printf('%s', '<h1>403 Forbidden</h1>');
            exit();
        }
    }
}