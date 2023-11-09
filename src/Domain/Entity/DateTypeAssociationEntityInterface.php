<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

use DateTime;

interface DateTypeAssociationEntityInterface extends AssociationEntityInterface
{
    public function getValue(): string;
}
