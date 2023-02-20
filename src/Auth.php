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
use Src\QueryBuilder;

/**
 * @package GiGaFlow\Auth
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class Auth 
{
	/**
	 * Initialize QueryBuilder class.
	 *
	 * @access protected
	 * @return QueryBuilder
	 */
	protected static function init(): QueryBuilder
	{
		return new QueryBuilder('users');
	}

	/**
	 * Get id from user authenticated.
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	public static function id(): mixed
	{
		return self::init()->findWhere('username', Session::get('user'))->id;
	}

}