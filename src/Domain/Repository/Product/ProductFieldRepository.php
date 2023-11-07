<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Product;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class ProductFieldRepository extends AbstractRepository implements ProductFieldRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'catfld';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Custom product field $identifier not found");
    }
}
