<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Repository\Order;

use Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\ApiTemplate\Domain\ValueObject\IdentifierType;

interface CustomFieldRepositoryInterface
{
    public function getByIdentifier(CustomFieldUuid $identifier): mixed;

    public function listOptions(CustomFieldUuid $identifier): mixed;

    public function getOption(CustomFieldUuid $identifier, IdentifierType $optionIdentifier): mixed;

    public function listAssociations(CustomFieldUuid $identifier): mixed;

    public function getAssociation(CustomFieldUuid $identifier, IdentifierType $ownerIdentifier): mixed;
}
