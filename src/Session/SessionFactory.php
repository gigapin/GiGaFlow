<?php
/*
 * This file is part of the GigaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@proton.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Src\Session;

use Src\Session\Session;

/**
 * 
 * @package GiGaFlow\Session
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class SessionFactory
{
  /**
   * @return mixed
   * @static
   * @throws \UnexpectedValueException
   */
  public static function build(): mixed
  {
    $session = new Session();
    if (! $session instanceof SessionInterface) {
      throw new \UnexpectedValueException('Session class must implements session interface');
    }

    return $session->init();
  }
}
