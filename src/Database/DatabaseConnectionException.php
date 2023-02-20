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

namespace Src\Database;

/**
 * 
 * @package GiGaFlow\Database
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 * @see \PDOException
 */
class DatabaseConnectionException extends \PDOException
{
    /**
     * DatabaseConnectionException constructor.
     * 
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