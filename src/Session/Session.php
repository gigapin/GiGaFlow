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

namespace Src\Session;

use Exception;
use Src\Application\Config;

/**
 * Manage sessions
 *
 * @package src\Session
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class Session implements SessionInterface
{
    /**
     * @inheritDoc
     *
     * @param $name
     * @param $value
     * @return false|mixed
     */
    public static function set($name, $value)
    {
        if ( ! Session::has($name)) {
            $_SESSION[$name] = $value;
            return $_SESSION[$name];
        }

        return false;
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public static function get($name)
    {
        if (Session::has($name)) {
            return $_SESSION[$name];
        } else {
            throw new Exception("Session not exist");
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public static function has($name): bool
    {
        if (isset($_SESSION[$name])) {
            return true;
        }

        return false;
    }

    /**
     * @param $name
     * @throws Exception
     */
    public static function remove($name)
    {
        if (Session::has($name)) {
            unset($_SESSION[$name]);
        } else {
            throw new Exception("Session not exist");
        }
    }

    /**
     * @param $name
     * @throws Exception
     */
    public static function destroy($name)
    {
        if (Session::has($name)) {
            session_destroy();
        } else {
            throw new Exception("Session not exist");
        }
    }

    /**
     * @return void
     */
    public static function init()
    {
        if (false == session_status()) {
            session_start([
                'cookie_lifetime' => Config::$cookie_lifetime,
            ]);
        }
    }
}