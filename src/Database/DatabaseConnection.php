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

namespace Src\Database;

use Src\View;
use Exception;
use PDO;

/**
 * Manage database connection
 *
 * @package Src\Database
 * @author GiGa <gigaprog@protonmail.com>
 * @version 1.0.0
 */
class DatabaseConnection implements DatabaseConnectionInterface
{
    /** @var PDO|null */
    protected static ?\PDO $db = null;

    /** @var array */
    protected array $attributes = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    /**
     * @inheritDoc
     *
     * @return PDO
     * @throws Exception
     */
    public function open(): PDO
    {
        if (! file_exists(__DIR__ . "/../../config/database.php")) {
            throw new Exception('File not found');
        }

        $config = include __DIR__ . "/../../config/database.php";

        try {
            switch (self::$db === null ) {
                case $config['connection'] === 'PGSQL':
                    self::$db = new \PDO(
                        $this->postgreSQLConnection($config),
                        $config['DB_DRIVERS']['PGSQL']['DB_USER'],
                        $config['DB_DRIVERS']['PGSQL']['DB_PASS'],
                        $this->attributes
                    );
                break;
                case $config['connection'] === 'MYSQL':
                    self::$db = new PDO(
                        $this->mysqlConnection($config),
                        $config['DB_DRIVERS']['MYSQL']['DB_USER'],
                        $config['DB_DRIVERS']['MYSQL']['DB_PASS'],
                        $this->attributes
                    );
                    break;
                case $config['connection'] === 'SQLITE':
                    self::$db = new PDO(
                        $this->sqliteConnection($config)
                    );
                    break;
                default:
                    throw new DatabaseConnectionException("Database driver not supported");
            }

            return self::$db;

        } catch (DatabaseConnectionException $exception) {
            View::showErrorException($exception);
        }
    }

    /**
     * @param array $config
     * @return string
     */
    protected function mysqlConnection(array $config): string
    {
        $dsn = "mysql:host=" . $config['DB_DRIVERS']['MYSQL']['DB_HOST'];
        $dsn .= ";dbname=" . $config['DB_DRIVERS']['MYSQL']['DB_NAME'];
        return $dsn;
    }

    /**
     * @param array $config
     * @return string
     */
    protected function sqliteConnection(array $config): string
    {
        return "sqlite: " . $config['DB_DRIVERS']['SQLITE']['FILE'];
    }

    /**
     * @param array $config
     * @return string
     */
    protected function postgreSQLConnection(array $config): string
    {
        $dsn = "pgsql:host=" . $config['DB_DRIVERS']['PGSQL']['DB_HOST'];
        $dsn .= ";port=5432;dbname=" . $config['DB_DRIVERS']['PGSQL']['DB_NAME'] . ";";
        return $dsn;
    }

    /**
     * @inheritDoc
     *
     * @return PDO|null
     */
    public function close(): ?PDO
    {
        return self::$db;
    }
}