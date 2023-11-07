<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Category;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class CategoryFieldRepository extends AbstractRepository implements CategoryFieldRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'catfld';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Custom category field $identifier not found");
    }
}
