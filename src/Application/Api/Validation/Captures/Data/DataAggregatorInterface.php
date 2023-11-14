<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data;

use Countable;

interface DataAggregatorInterface extends Countable
{
    public function remember(string $key, mixed $value): self;

    public function get(): array;

    public function clear(): self;
}
