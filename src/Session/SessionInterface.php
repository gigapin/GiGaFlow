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

namespace Src\Session;

/**
 * Session Interface
 *
 * @package Src\Seeeion
 * @author GiGa <gigaprog@protonmail.com>
 * @version 1.0.0
 */
interface SessionInterface
{
    /**
     * Set a session
     *
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public static function set(string $name, string $value);

    /**
     * Get value about a session
     *
     * @param string $name
     * @return mixed
     */
    public static function get(string $name);

    /**
     * Check if a session is active
     *
     * @param string $name
     * @return bool
     */
    public static function has(string $name): bool;

    /**
     * Remove a session
     *
     * @param string $name
     * @return mixed
     */
    public static function remove(string $name);

    /**
     * Destroy all sessions active
     *
     * @param string $name
     * @return mixed
     */
    public static function destroy(string $name);

    /**
     * Start a session
     *
     * @return mixed
     */
    public static function init();
}
