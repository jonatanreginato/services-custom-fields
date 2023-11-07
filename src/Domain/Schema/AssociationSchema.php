<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Schema;

use Nuvemshop\ApiTemplate\Domain\Entity\AssociationEntityInterface;

class AssociationSchema extends AbstractSchema
{
    public function __construct(protected readonly AssociationEntityInterface $entity)
    {
    }

    public static function getType(): string
    {
        return 'associations';
    }

    public function getAttributes(): array
    {
        return [
            'id'         => $this->entity->getId(),
            'value'      => $this->entity->getValue(),
            'owner_id'   => $this->entity->getOwnerId(),
            'created_at' => ($this->entity->getCreatedAt())?->format(self::DATETIME_FORMAT),
            'updated_at' => ($this->entity->getUpdatedAt())?->format(self::DATETIME_FORMAT),
        ];
    }
}
