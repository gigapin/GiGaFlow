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

namespace Src\Authorization;

/**
 * @package GiGaFlow\Authorization
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class AuthorizationFactory
{
  /**
   * Instance and initialize Authorization class.
   *
   * @throws \UnexpectedValueException
   * @static
   * @return mixed
   */
  public static function build(): mixed
  {
    $auth = new Authorization();
    if (! $auth instanceof AuthorizationInterface) {
      throw new \UnexpectedValueException('Not valid Authorization object');
    }
    
    return $auth->init();
  } 
}