<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Category;

use Nuvemshop\ApiTemplate\Domain\Repository\OptionRepositoryInterface;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class TextTypeCategoryAssociationRepository extends AbstractRepository implements OptionRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'opt';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Option $identifier not found");
    }
}
