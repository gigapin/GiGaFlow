<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Controllers\HomeController;

/** @var $route */

/** HOME */
$route->map('', [HomeController::class, 'index']);


