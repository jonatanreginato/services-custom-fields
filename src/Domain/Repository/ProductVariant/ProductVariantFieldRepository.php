<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\ProductVariant;

use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class ProductVariantFieldRepository extends AbstractRepository implements ProductVariantFieldRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'catfld';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Custom product variant field $identifier not found");
    }
}
