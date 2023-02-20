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

use \Exception;
use Src\Application\Config;

/**
 * 
 * @package GiGaFlow\Session
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 * @see SessionInterface
 */
class Session implements SessionInterface
{
  /**
   * @inheritDoc
   *
   * @param string $name
   * @param mixed $value
   * @static
   * @return mixed
   */
  public static function set(string $name, mixed $value): mixed
  {
    if (! Session::has($name)) {
      $_SESSION[$name] = $value;
      return $_SESSION[$name];
    }
    
    return null;
  }

  /**
   * @inheritDoc
   * 
   * @param string $name
   * @static
   * @return mixed
   * @throws Exception
   */
  public static function get(string $name): mixed
  {
    if (Session::has($name)) {
      return $_SESSION[$name];
    }

    return null;
  }

  /**
   * @inheritDoc
   * 
   * @param string $name
   * @static
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
   * @inheritDoc 
   * 
   * @param string $name
   * @throws Exception
   * @return void
   */
  public static function remove(string $name): void
  {
    if (Session::has($name)) {
      unset($_SESSION[$name]);
    }
  }

  /**
   * @inheritDoc
   * 
   * @param string $name
   * @throws \Exception
   * @static
   * @return mixed
   */
  public static function destroy(string $name): mixed
  {
    if (Session::has($name)) {
      session_destroy();
    } else {
      throw new \Exception("Session not exist");
    }
  }

  /**
   * @inheritDoc
   * 
   * @return void
   */
  public function init(): void
  {
    if (1 === session_status()) {
      session_start([
        'cookie_lifetime' => Config::$cookie_lifetime,
      ]);
    }
  }

  /**
   * Set cookie for display a flash message.
   * 
   * @param string $type
   * @param string $message
   * @return mixed
   */
  public static function setFlashMessage(string $type, string $message): mixed
  {
    $consts = [
      'FLASH_SUCCESS',
      'FLASH_ERROR'
    ];

    try {
      if (!in_array($type, $consts)) {
        throw new Exception('Flash message type not supported');
      }
      if (in_array($type, $consts)) {
        return setcookie('FLASH_MESSAGE', $message, time() + 5, "/");
      }
    } catch (Exception $exc) {
      printf("%s", $exc->getMessage());
    }
  }
}
