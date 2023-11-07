<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Order;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class TextTypeAssociationRepository extends AbstractRepository implements TextTypeAssociationRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'tta';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Association $identifier not found");
    }
}
