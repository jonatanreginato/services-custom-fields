<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Representation;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Parser\ResourceInterface;

use function assert;
use function json_encode;

class DocumentWriter extends BaseWriter implements DocumentWriterInterface
{
    public function addResourceToData(ResourceInterface $resource): DocumentWriterInterface
    {
        $this->addToData($this->getResourceRepresentation($resource));

        return $this;
    }

    private function addToData(array $representation): void
    {
        if ($this->isDataAnArray) {
            $this->data[] = $representation;

            return;
        }

        $this->data = $representation;
    }

    private function getResourceRepresentation(ResourceInterface $resource): array
    {
        $representation = [];

        $attributes = $this->getAttributesRepresentation($resource->getAttributes());
        if (!empty($attributes)) {
            assert(
                json_encode($attributes) !== false,
                'Attributes for resource type `' . $resource->getType() .
                '` cannot be converted into JSON. Please check its Schema returns valid data.'
            );
            $representation = $attributes;
        }

        return $representation;
    }

    private function getAttributesRepresentation(iterable $attributes): array
    {
        $representation = [];
        foreach ($attributes as $name => $value) {
            $representation[$name] = $value;
        }

        return $representation;
    }
}
