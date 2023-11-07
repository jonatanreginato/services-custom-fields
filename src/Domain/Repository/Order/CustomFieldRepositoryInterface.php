<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Order;

use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;

interface CustomFieldRepositoryInterface
{
    public function getByIdentifier(CustomFieldUuid $identifier): mixed;

    public function fetchOptions(CustomFieldUuid $identifier): mixed;

    public function fetchOption(CustomFieldUuid $identifier, IdentifierType $optionIdentifier): mixed;

    public function fetchAssociations(CustomFieldUuid $identifier): mixed;

    public function fetchAssociation(CustomFieldUuid $identifier, IdentifierType $ownerIdentifier): mixed;
}
