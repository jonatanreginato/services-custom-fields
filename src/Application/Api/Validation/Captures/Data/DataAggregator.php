<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data;

use function count;

class DataAggregator implements DataAggregatorInterface
{
    private array $remembered = [];

    public function remember(string $key, mixed $value): DataAggregatorInterface
    {
        $this->remembered[$key] = $value;

        return $this;
    }

    public function get(): array
    {
        return $this->remembered;
    }

    public function count(): int
    {
        return count($this->get());
    }

    public function clear(): DataAggregatorInterface
    {
        $this->remembered = [];

        return $this;
    }
}
