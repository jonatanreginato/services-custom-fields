<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Order;

use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;

interface OptionTypeAssociationRepositoryInterface
{
    public function getByIdentifier(IdentifierType $identifier): mixed;
}
