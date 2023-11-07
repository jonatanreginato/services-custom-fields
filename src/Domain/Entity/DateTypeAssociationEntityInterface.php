<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

use DateTime;

interface DateTypeAssociationEntityInterface extends AssociationEntityInterface
{
    public function getValue(): string;
}
