<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Schema;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

use function is_array;

abstract class AbstractSchema implements SchemaInterface
{
    protected const DATETIME_FORMAT = DateTimeInterface::ATOM;

    public static function getAttributesFromArray(ArrayCollection|PersistentCollection|array $entities): array
    {
        if (!is_array($entities)) {
            $entities = $entities->toArray();
        }

        return array_map(static fn($entity): array => (new static($entity))->getAttributes(), $entities);
    }

    public static function getIdentifiersFromArray(ArrayCollection|PersistentCollection|array $entities): array
    {
        if (!is_array($entities)) {
            $entities = $entities->toArray();
        }

        return array_map(static fn($entity): mixed => $entity->id, $entities);
    }

    abstract public function getAttributes(): array;
}
