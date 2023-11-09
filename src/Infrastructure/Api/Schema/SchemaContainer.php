<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Schema;

use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Schema\SchemaInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Traits\Reflection\ClassIsTrait;

use function array_key_exists;
use function assert;
use function get_class;

class SchemaContainer implements SchemaContainerInterface
{
    use ClassIsTrait;

    public function __construct(
        private readonly array $entityToSchemaMap
    ) {
    }

    public function getSchema(EntityInterface $entity): SchemaInterface
    {
        assert($this->hasSchema($entity));
        $schemaClass = $this->getSchemaClassByEntityClass($this->getEntityClass($entity));

        return $this->getSchemaByClass($schemaClass, $entity);
    }

    public function hasSchema(EntityInterface $entity): bool
    {
        return array_key_exists($this->getEntityClass($entity), $this->entityToSchemaMap);
    }

    private function getEntityClass(EntityInterface $entity): string
    {
        return get_class($entity);
    }

    private function getSchemaClassByEntityClass(string $entityClass): string
    {
        assert(array_key_exists($entityClass, $this->entityToSchemaMap));

        return $this->entityToSchemaMap[$entityClass];
    }

    private function getSchemaByClass(string $schemaClass, EntityInterface $entity): SchemaInterface
    {
        assert(static::classImplements($schemaClass, SchemaInterface::class));

        return new $schemaClass($entity);
    }
}
