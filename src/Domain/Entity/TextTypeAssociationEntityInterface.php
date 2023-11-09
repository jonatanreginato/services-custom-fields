<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

interface TextTypeAssociationEntityInterface extends AssociationEntityInterface
{
    public function getValue(): string;
}
