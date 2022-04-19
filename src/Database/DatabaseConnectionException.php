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

/**
 * Manage Exceptions about DatabaseConnection class
 *
 * @package Src\Database
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class DatabaseConnectionException extends \PDOException
{
    /**
     * DatabaseConnectionException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message = '', $code = 0);
        $this->message = $message;
        $this->code = $code;
    }
}