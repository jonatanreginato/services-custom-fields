<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Pdo;

use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\Repository;
use PDO;
use PDOStatement;

abstract class AbstractRepository implements Repository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    abstract public function replace(mixed $entity): mixed;

    abstract public function remove(mixed $entity): void;

    protected function fetchAll(PDOStatement $stmt): array
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function prepare(string $query): PDOStatement|false
    {
        return $this->conn->prepare($query);
    }

    public function beginTransaction(): void
    {
        $this->conn->beginTransaction();
    }

    public function rollback(): void
    {
        $this->conn->rollBack();
    }

    public function commit(): void
    {
        $this->conn->commit();
    }

    protected function bindParams(object $statement, array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            $statement->bindValue(":$key", $value, PDO::PARAM_STR);
        }
    }
}
