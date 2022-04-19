<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
return [
    /**
     * Enter what database driver is needed for your application.
     */
    'connection' => 'MYSQL',
    /**
     * Set credentials for database selected.
     */
    'DB_DRIVERS' => [
        'MYSQL' => [
            'DB_HOST' => '',
            'DB_USER' => '',
            'DB_NAME' => '',
            'DB_PASS' => '',
        ],
        'SQLITE' => [
            'FILE' => 'storage/database/sqlite.db'
        ],
        'PGSQL' => [
            'DB_HOST' => '',
            'DB_USER' => '',
            'DB_NAME' => '',
            'DB_PASS' => '',
        ],
    ]
];
