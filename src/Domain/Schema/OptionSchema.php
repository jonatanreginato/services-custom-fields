<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Schema;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\CustomFields\Domain\Entity\OptionEntityInterface;

class OptionSchema extends AbstractSchema
{
    public function __construct(protected readonly OptionEntityInterface $entity)
    {
    }

    public static function getType(): string
    {
        return 'options';
    }

    public function getAttributes(): array
    {
        return [
            'id'    => $this->entity->getId(),
            'value' => $this->entity->getValue(),
        ];
    }

    public static function getIdentifiersFromArray(ArrayCollection|PersistentCollection|array $entities): array
    {
        if (!is_array($entities)) {
            $entities = $entities->toArray();
        }

        /** @var OptionEntityInterface $entity */
        return array_map(static fn($entity): string => $entity->getValue(), $entities);
    }
}
