<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;

abstract class DateTypeAssociationEntity extends AssociationEntity implements DateTypeAssociationEntityInterface
{
    #[Column(name: 'value', type: Types::DATE_IMMUTABLE)]
    public mixed $value;

    public function getValue(): DateTime
    {
        return $this->value;
    }

    public function setValue(DateTime $value): DateTypeAssociationEntity
    {
        $this->value = $value;

        return $this;
    }
}
