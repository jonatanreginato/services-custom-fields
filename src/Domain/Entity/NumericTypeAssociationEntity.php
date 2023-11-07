<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;

abstract class NumericTypeAssociationEntity extends AssociationEntity implements NumericTypeAssociationEntityInterface
{
    #[Column(name: 'value', type: Types::FLOAT)]
    public mixed $value;

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): NumericTypeAssociationEntity
    {
        $this->value = $value;

        return $this;
    }
}
