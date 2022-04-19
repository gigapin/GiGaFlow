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

use Src\Application\Config;
use Src\Session\Session;

/**
 * Initialize session class
 *
 * @package Src\Session
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class SessionFactory
{
    /**
     * @return Session|SessionInterface
     */
    public static function build()
    {
        $session = new Session();
        if (! $session instanceof SessionInterface) {
            throw new \UnexpectedValueException('Session class must implements session interface');
        }

        return $session->init();
    }
}