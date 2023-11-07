<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Order;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class OptionRepository extends AbstractRepository implements OptionRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'opt';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find($identifier->getId())
            ?: throw new EntityNotFoundException("Option $identifier not found");
    }

    public function find($id, $lockMode = null, $lockVersion = null): mixed
    {
        if (!isset($this->queryBuilder)) {
            $this->makeQueryBuilder();
        }
        $this->queryBuilder->andWhere($this->getAlias() . '.id = :id');
        $this->queryBuilder->setParameter('id', $id);

        return $this->queryBuilder->getQuery()->getOneOrNullResult();
    }
}
