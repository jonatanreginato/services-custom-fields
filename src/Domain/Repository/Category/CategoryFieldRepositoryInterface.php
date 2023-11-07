<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Category;

use Doctrine\Persistence\ObjectRepository;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\QueryParams\Filter;

/**
 * @template T of object
 */
interface CategoryFieldRepositoryInterface extends ObjectRepository
{
    public function getCount(Filter $criteria): int;

    public function getByIdentifier(IdentifierType $identifier): mixed;

    public function insert(mixed $entity): mixed;

    public function update(): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
