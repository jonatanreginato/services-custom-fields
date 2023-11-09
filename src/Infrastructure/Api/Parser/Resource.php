<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Parser;

use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Schema\SchemaInterface;

// phpcs:ignoreFile -- this is a readonly class
readonly class Resource implements ResourceInterface
{
    public function __construct(
        private EntityInterface $entity,
        private SchemaInterface $schema
    ) {
    }

    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    public function getSchema(): SchemaInterface
    {
        return $this->schema;
    }

    public function getId(): mixed
    {
        return $this->entity->getUuid();
    }

    public function getType(): string
    {
        return $this->schema::getType();
    }

    public function getAttributes(): iterable
    {
        return $this->schema->getAttributes();
    }
}
