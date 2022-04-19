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

use Exception;
use PDO;
use Src\Database\DatabaseConnection;

/**
 * Model initializer
 *
 * @package Src
 * @author GiGa <gigaprog@protonmail.com>
 * @version 1.0.0
 */
abstract class Model
{

    /**
     * Return a connection to the database
     *
     * @return PDO|null
     * @throws Exception
     */
    public static function getDB(): ?PDO
    {
        $connection = new DatabaseConnection();
        return $connection->open();
    }

}