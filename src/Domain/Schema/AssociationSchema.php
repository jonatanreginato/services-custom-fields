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
            'metafield_id'   => $this->entity->getCustomField()->uuid,
            'value'          => $this->entity->getValue(),
            'owner_id'       => $this->entity->getOwnerId(),
            'owner_resource' => $this->entity->getOwnerResource(),
        ];
    }
}
