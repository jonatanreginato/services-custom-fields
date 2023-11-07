<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Pdo;

use PDO;
use PDOException;

class ConnectionFactory
{
    public function __invoke(string $host, string $database, string $user, string $password): PDO
    {
        try {
            return new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $database), $user, $password);
        } catch (PDOException $e) {
            throw new PdoConnectionException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
    }
}
