<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Captures;

use function count;

class CaptureAggregator implements CaptureAggregatorInterface
{
    private array $remembered = [];

    public function remember(string $key, mixed $value): CaptureAggregatorInterface
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

    public function clear(): CaptureAggregatorInterface
    {
        $this->remembered = [];

        return $this;
    }
}
