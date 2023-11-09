<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Customer;

use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

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
