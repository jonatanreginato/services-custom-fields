<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDO\SQLite\Driver;
use Nuvemshop\ApiTemplate\AbstractUnitTestCase;

class ConnectionFacadeTest extends AbstractUnitTestCase
{
    /**
     * @dataProvider getData
     */
    public function testCanReturnTheConnection(array $dbConfig): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, $dbConfig));

        $connection = (new ConnectionFacade($dbConfig))->connection;

        static::assertInstanceOf(Connection::class, $connection);
    }

    /**
     * @dataProvider getData
     */
    public function testCanThrownDoctrineException(array $dbConfig): void
    {
        $this->logger->info(sprintf(self::DEFAULT_LOG_MESSAGE, __METHOD__, $dbConfig));

        $this->expectException(DoctrineException::class);
        (new ConnectionFacade([]))->connection;
    }

    public static function getData(): array
    {
        return [
            [
                [
                    'driver'              => 'pdo_sqlite',
                    'driverClass'         => Driver::class,
                    'path'                => getenv("DATABASE_PATH"),
                    'host'                => getenv("DATABASE_HOST_RW"),
                    'port'                => getenv("DATABASE_PORT_RW"),
                    'user'                => getenv("DATABASE_USER_RW"),
                    'password'            => getenv("DATABASE_PASS_RW"),
                    'charset'             => 'UTF8',
                    'driverOptions'       => [],
                    'defaultTableOptions' => [],
                    'entitiesPath'        => [
                        'src/Domain/Entity'
                    ],
                    'cache'               => [
                        'enabled'  => (bool)getenv('DATABASE_CACHE'),
                        'strategy' => null,
                    ]
                ],
            ],
        ];
    }
}
