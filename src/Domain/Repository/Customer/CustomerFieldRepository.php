<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Customer;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class CustomerFieldRepository extends AbstractRepository implements CustomerFieldRepositoryInterface
{
    protected function getAlias(): string
    {
        return 'cusfld';
    }

    public function getByIdentifier(IdentifierType $identifier): mixed
    {
        return $this->find((string)$identifier)
            ?: throw new EntityNotFoundException("Custom customer field $identifier not found");
    }
}
