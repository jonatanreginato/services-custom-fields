<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Captures;

use Countable;

interface CaptureAggregatorInterface extends Countable
{
    public function remember(string $key, mixed $value): self;

    public function get(): array;

    public function clear(): self;
}
