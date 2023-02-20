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

use Src\Http\Request;

/**
 * @package GiGaFlow\Pagination
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class Pagination
{
  /**
   * Display a list of items in many pages. 
   *
   * @param array $array
   * @param integer $length
   * @return mixed
   */
  public function paginate(array $array, int $length): mixed
  {
    if (Request::get('page') !== null) {
      $offset = $length * Request::get('page');

      return array_slice($array, $offset, $length);
    }
  }
}
