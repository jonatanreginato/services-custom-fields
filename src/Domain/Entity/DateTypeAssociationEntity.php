<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;

abstract class DateTypeAssociationEntity extends AssociationEntity implements DateTypeAssociationEntityInterface
{
    #[Column(name: 'value', type: Types::DATETIME_MUTABLE)]
    public mixed $value;

    public function getValue(): string
    {
        return $this->value->format(DateTimeInterface::ATOM);
    }

    public function setValue(DateTime $value): DateTypeAssociationEntity
    {
        $this->value = $value;

        return $this;
    }
}
