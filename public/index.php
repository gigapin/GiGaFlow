<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
ini_set('display_errors', 1);

$root = realpath(dirname(__FILE__));
require  $root . "/../vendor/autoload.php";

use Src\Application\Application;

$app = new Application();
$app->run();


