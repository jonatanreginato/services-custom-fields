<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Order;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class NumericTypeAssociationRepository extends AbstractRepository implements NumericTypeAssociationRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'nta';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Association $identifier not found");
    }
}
