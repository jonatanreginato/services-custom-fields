<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Throwable;

// phpcs:ignoreFile -- this is a readonly class
readonly class ConnectionFacade
{
    public Connection $connection;

    public function __construct(array $params, Configuration $configuration = null, EventManager $eventManager = null)
    {
        try {
            $this->connection = DriverManager::getConnection($params, $configuration, $eventManager);
        } catch (Throwable $e) {
            throw new DoctrineException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
    }
}
