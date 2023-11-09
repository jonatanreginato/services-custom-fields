<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

interface NumericTypeAssociationEntityInterface extends AssociationEntityInterface
{
    public function getValue(): float;
}
