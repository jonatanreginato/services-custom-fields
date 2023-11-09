<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Customer;

use Doctrine\Persistence\ObjectRepository;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\QueryParams\Filter;

interface CustomerFieldRepositoryInterface extends ObjectRepository
{
    public function getCount(Filter $criteria): int;

    public function getByIdentifier(IdentifierType $identifier): mixed;

    public function insert(mixed $entity): mixed;

    public function update(): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
