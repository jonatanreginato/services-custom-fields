<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Order;

use Nuvemshop\CustomFields\Domain\Schema\AssociationSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class DateTypeAssociationRepository extends AbstractRepository implements DateTypeAssociationRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'dta';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Association $identifier not found");
    }

    public function fetchAssociationsByOwner(int $ownerId): array
    {
        $this->createBuilder($this->_entityName, 'a');
        $this->queryBuilder
            ->select('a')
            ->from($this->_entityName, 'a')
            ->andWhere('a.ownerId = :id')
            ->setParameter('id', $ownerId);

        return AssociationSchema::getAttributesFromArray($this->queryBuilder->getQuery()->getResult());
    }
}
