<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

interface TextTypeAssociationEntityInterface extends AssociationEntityInterface
{
    public function getValue(): string;
}
