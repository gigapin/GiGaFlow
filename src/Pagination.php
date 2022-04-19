<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src;

/**
 * @package Src
 * @author GiGa <gigaprog@protonmail.com>
 * @version 1.0.0
 */
class Pagination
{
    /**
     * @param array $array
     * @param int $length
     * 
     * @return array
     */
    public function paginate(array $array, int $length)
    {
        if (isset($_GET['page'])) {
            $offset = $length * $_GET['page'];

            return array_slice($array, $offset, $length);
        }
    }


}