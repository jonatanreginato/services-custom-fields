<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Customer;

use Nuvemshop\CustomFields\Domain\Repository\OptionRepositoryInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\AbstractRepository;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine\EntityNotFoundException;

class CustomerFieldOptionRepository extends AbstractRepository implements OptionRepositoryInterface
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
