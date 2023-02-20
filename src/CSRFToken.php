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

namespace Src;

use Src\Session\Session;

/**
 * @package GiGaFlow\CSRF
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class CSRFToken
{
  /**
   * Generate a CSRF Token.
   *
   * @return mixed
   * @static
   */
  public static function token(): mixed
  {
    if (!Session::has('_token')) {
      $token = base64_encode(openssl_random_pseudo_bytes(32));
      Session::set('_token', $token);
    }

    return Session::get('_token');
  }

  /**
   * Verify if CSRF Token match token session value.
   *
   * @return void
   */
  public static function verifyToken(): void
  {
    if (! isset($_SESSION['_token']) || $_SESSION['_token'] !== self::token() || is_null($_SESSION['_token'])) {
      header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
      printf('%s', '<h1>403 Forbidden</h1>');
      exit();
    }
  }
}
