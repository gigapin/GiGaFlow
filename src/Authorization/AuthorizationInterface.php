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
interface AuthorizationInterface
{
  /**
   * Verify if is active a user session and 
   * if URL is different from login or register 
   * raise an exception.
   *
   * @throws \Exception
   * @throws AuthException
   * @return mixed
   */
  public function init();
}