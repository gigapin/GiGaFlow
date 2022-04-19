<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src\Database;

use PDO;

/**
 * Database connection
 *
 * @package Src\Database
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
interface DatabaseConnectionInterface
{
    /**
     * Start database connection
     *
     * @return PDO
     */
    public function open(): PDO;

    /**
     * Close database connection
     *
     * @return mixed
     */
    public function close(): ?PDO;

}