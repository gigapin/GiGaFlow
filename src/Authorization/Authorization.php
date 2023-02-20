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

use Src\Session\Session;
use Src\Exceptions\AuthException;
use Src\Authorization\AuthorizationInterface;
use Src\Http\Request;

/**
 * 
 * @package GiGaFlow\Authorization
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 * @see AuthorizationInterface
 */
class Authorization implements AuthorizationInterface
{
  /**
   * @inheritDoc
   */
  public function init()
  {
    try {
      if (is_null(Session::get('user'))) {
        if (Request::uri() !== '/login' && 
            Request::uri() !== '/register' && 
            Request::uri() !== '/signin' && 
            Request::uri() !== '/signup' &&
            Request::uri() !== '/'
          ) {
          throw new AuthException("You are not authorized to access! Please make log in if you are registered.", 403);
        }
      }

      if (Request::uri() !== '/login' && 
            Request::uri() !== '/register' && 
            Request::uri() !== '/signin' && 
            Request::uri() !== '/signup' &&
            Request::uri() !== '/'
        ) {
        // $role = new Role();
        
        // if (! $role->hasPermission(Session::get('user'), Request::uri())) {
        //   throw new AuthException('You cannot to access at this resource', 403);
        // }
        
        return Session::get('user');
      }
    } catch (AuthException $exc) {
      printf('%s %d', $exc->getMessage(), $exc->getCode());
      exit();
    } 
  }
}