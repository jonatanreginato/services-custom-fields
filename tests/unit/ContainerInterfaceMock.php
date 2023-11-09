<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields;

use Doctrine\DBAL\Driver\PDO\SQLite\Driver;
use Laminas\ServiceManager\ServiceManager;
use Prophecy\Prophecy\ProphecyInterface;
use Psr\Container\ContainerInterface;
use Throwable;

class ContainerInterfaceMock extends AbstractMock
{
    public function getMock(): ProphecyInterface
    {
        /** @var ProphecyInterface|ContainerInterface $container */
        $container = $this->prophesize(ContainerInterface::class);

        try {
            $container->get('config')->willReturn($this->getTestContainerConfig()['services']['config']);
        } catch (Throwable $e) {
            throw new MockException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $container;
    }

    public function getObjectWithMockDependencies(): ContainerInterface
    {
        return new ServiceManager($this->getTestContainerConfig());
    }

    private function getTestContainerConfig(): array
    {
        return [
            'services'   => [
                'config' => [
                    'is_development' => false,
                    'cors'           => [],
                    'data_store'     => [
                        'doctrine'      => [
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
                        'elasticsearch' => [],
                        'open_search'   => [],
                    ],
                    'templates'      => [],
                    'jwt'            => [],
                    'log'            => [],
                    'notification'   => [],
                    'swagger'        => [],
                ],
            ],
            'invokables' => [],
            'factories'  => [],
            'delegators' => [],
        ];
    }
}
