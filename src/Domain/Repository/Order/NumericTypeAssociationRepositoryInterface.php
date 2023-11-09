<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Repository\Order;

use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;

interface NumericTypeAssociationRepositoryInterface
{
    public function getByIdentifier(IdentifierType $identifier): mixed;
}
