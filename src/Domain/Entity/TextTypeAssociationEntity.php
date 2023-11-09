<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;

abstract class TextTypeAssociationEntity extends AssociationEntity implements TextTypeAssociationEntityInterface
{
    #[Column(name: 'value', type: Types::STRING)]
    public mixed $value;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): TextTypeAssociationEntity
    {
        $this->value = $value;

        return $this;
    }
}
