<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

abstract class OptionTypeAssociationEntity extends AssociationEntity implements OptionTypeAssociationEntityInterface
{
    public mixed $value;

    public function getValue(): string
    {
        return $this->value->getValue();
    }

    public function setValue(OptionEntityInterface $value): AssociationEntityInterface
    {
        $this->value = $value;

        return $this;
    }
}
