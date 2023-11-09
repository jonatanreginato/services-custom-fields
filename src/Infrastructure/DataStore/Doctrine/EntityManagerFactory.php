<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Throwable;

class EntityManagerFactory
{
    public function __invoke(ContainerInterface $container): EntityManager
    {
        $doctrineConnection = $this->getConnection($container);

        try {
            $doctrineData   = $container->get('config')['data_store']['doctrine'] ?? [];
            $doctrineConfig = (new DoctrineConfiguration($doctrineData))->config;
            $entityManager = EntityManager::create($doctrineConnection, $doctrineConfig);
        } catch (Throwable $e) {
            throw new DoctrineException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $entityManager;
    }

    private function getConnection(ContainerInterface $container): Connection
    {
        try {
            /** @var Connection $doctrineConnection */
            $doctrineConnection = ($container->get(ConnectionFacade::class))->connection;
            $doctrineConnection->getDatabasePlatform()?->registerDoctrineTypeMapping('bit', 'boolean');
            $doctrineConnection->getDatabasePlatform()?->registerDoctrineTypeMapping('enum', 'string');
        } catch (Throwable $e) {
            throw new DoctrineException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $doctrineConnection;
    }
}
