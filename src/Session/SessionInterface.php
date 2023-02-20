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

namespace Src\Session;

/**
 * 
 * @package GiGaFlow\Session
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
interface SessionInterface
{
  /**
   * Set a session/
   *
   * @param string $name
   * @param mixed $value
   * @static
   * @return mixed
   */
  public static function set(string $name, mixed $value): mixed;

  /**
   * Get value about a session
   *
   * @param string $name
   * @static
   * @return mixed
   */
  public static function get(string $name): mixed;

  /**
   * Check if a session is active
   *
   * @param string $name
   * @static
   * @return bool
   */
  public static function has(string $name): bool;

  /**
   * Remove a session
   *
   * @param string $name
   * @static
   * @return void
   */
  public static function remove(string $name): void;

  /**
   * Destroy all sessions active
   *
   * @param string $name
   * @static
   * @return mixed
   */
  public static function destroy(string $name): mixed;

  /**
   * Start a session
   *
   * @return void
   */
  public function init(): void;
}
