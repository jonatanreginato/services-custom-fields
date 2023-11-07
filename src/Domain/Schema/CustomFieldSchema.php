<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Schema;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Enum\OwnerResourceEnum;
use Nuvemshop\ApiTemplate\Domain\Enum\SourceEnum;
use Nuvemshop\ApiTemplate\Domain\Enum\ValueTypeEnum;

class CustomFieldSchema extends AbstractSchema
{
    public function __construct(protected readonly CustomFieldEntityInterface $entity)
    {
    }

    public static function getType(): string
    {
        return 'customFields';
    }

    public function getAttributes(): array
    {
        return [
            'id'             => $this->entity->getUuid(),
            'namespace'      => $this->entity->getNamespace(),
            'key'            => $this->entity->getKey(),
            'name'           => $this->entity->getName(),
            'owner_resource' => OwnerResourceEnum::from($this->entity->getOwnerResource())->name,
            'value_type'     => ValueTypeEnum::from($this->entity->getValueType())->name,
            'source'         => SourceEnum::from($this->entity->getSource())->name,
            'description'    => $this->entity->getDescription(),
            'read_only'      => $this->entity->getReadOnly(),
            'created_at'     => ($this->entity->getCreatedAt())?->format(self::DATETIME_FORMAT),
            'updated_at'     => ($this->entity->getUpdatedAt())?->format(self::DATETIME_FORMAT),
            'options'        => $this->entity->getOptions()
                ? OptionSchema::getIdentifiersFromArray($this->entity->getOptions()->toArray())
                : [],
        ];
    }

}
