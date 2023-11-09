<?php

declare(strict_types=1);

if (!function_exists('populateOrmConfig')) {
    function populateOrmConfig(): array
    {
        return match (getenv("DATABASE_TYPE")) {
            'SQLITE' => [
                'driver'              => 'pdo_sqlite',
                'driverClass'         => Doctrine\DBAL\Driver\PDO\SQLite\Driver::class,
                'path'                => getenv("DATABASE_PATH"),
                'host'                => getenv("DATABASE_HOST_RW"),
                'port'                => getenv("DATABASE_PORT_RW"),
                'user'                => getenv("DATABASE_USER_RW"),
                'password'            => getenv("DATABASE_PASS_RW"),
                'charset'             => 'UTF8',
                'driverOptions'       => [],
                'defaultTableOptions' => [],
                'entitiesPath'        => [
                    'src/Domain/Entity',
                    'src/Domain/Entity/Category',
                    'src/Domain/Entity/Customer',
                    'src/Domain/Entity/Order',
                    'src/Domain/Entity/Product',
                    'src/Domain/Entity/ProductVariant',
                ],
                'cache'               => [
                    'enabled'  => (bool)getenv('DATABASE_CACHE'),
                    'strategy' => null,
                ],
            ],
            'MYSQL' => [
                'driver'        => 'pdo_mysql',
                'driverClass'   => Doctrine\DBAL\Driver\PDO\MySQL\Driver::class,
                'wrapperClass'  => Doctrine\DBAL\Connections\PrimaryReadReplicaConnection::class,
                'driverOptions' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND       => "SET NAMES 'UTF8' COLLATE 'utf8_unicode_ci'",
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                    PDO::ATTR_CASE                     => PDO::CASE_LOWER,
                    PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_STRINGIFY_FETCHES        => false,
                    PDO::ATTR_EMULATE_PREPARES         => false,
                ],
                'primary'       => [
                    'host'     => getenv("DATABASE_HOST_RW"),
                    'port'     => getenv("DATABASE_PORT_RW") ?: 3306,
                    'user'     => getenv("DATABASE_USER_RW"),
                    'password' => getenv("DATABASE_PASS_RW"),
                    'dbname'   => getenv("DATABASE_BASE_RW"),
                    'charset'  => 'UTF8',
                ],
                'replica'       => [
                    [
                        'host'     => getenv("DATABASE_HOST_RO"),
                        'port'     => getenv("DATABASE_PORT_RO") ?: 3306,
                        'user'     => getenv("DATABASE_USER_RO"),
                        'password' => getenv("DATABASE_PASS_RO"),
                        'dbname'   => getenv("DATABASE_BASE_RO"),
                        'charset'  => 'UTF8',
                    ],
                ],
                'entitiesPath'  => [
                    'src/Domain/Entity',
                ],
                'cache'         => [
                    'enabled'  => (bool)getenv('DATABASE_CACHE'),
                    'strategy' => null,
                ],
            ]
        };
    }
}

return [
    'data_store' => [
        'doctrine'      => populateOrmConfig(),
        'elasticsearch' => [
            'scheme' => strtolower((string)getenv('ELASTICSEARCH_SCHEME')),
            'host'   => getenv('ELASTICSEARCH_HOST'),
            'port'   => getenv('ELASTICSEARCH_PORT'),
        ],
    ],
];
