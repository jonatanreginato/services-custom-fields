<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Parser;

use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\Schema\SchemaInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\SchemaContainerInterface;

use function assert;
use function is_array;
use function is_object;

class Parser implements ParserInterface
{
    public function __construct(
        private readonly SchemaContainerInterface $schemaContainer
    ) {
    }

    public function parse(mixed $data): iterable
    {
        assert(is_array($data) || is_object($data) || $data === null);

        is_iterable($data)
            ? yield from $this->parseAsResources($data)
            : yield from $this->parseAsResource($data);
    }

    private function parseAsResources(iterable $data): iterable
    {
        foreach ($data as $entity) {
            if ($this->schemaContainer->hasSchema($entity)) {
                yield from $this->parseAsResource($entity);
            }
        }
    }

    private function parseAsResource(EntityInterface $entity): iterable
    {
        assert($this->schemaContainer->hasSchema($entity));
        $schema = $this->schemaContainer->getSchema($entity);

        yield $this->createParsedResource($entity, $schema);
    }

    private function createParsedResource(EntityInterface $entity, SchemaInterface $schema): ResourceInterface
    {
        return new Resource($entity, $schema);
    }
}
