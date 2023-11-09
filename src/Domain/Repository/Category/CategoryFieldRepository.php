<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Category;

use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

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
