<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Schema;

use function assert;

class Link implements LinkInterface
{
    private bool $isSubUrl;

    private string $value;

    public function __construct(bool $isSubUrl, string $value)
    {
        $this->isSubUrl = $isSubUrl;
        $this->value    = $value;
    }

    public function getStringRepresentation(string $prefix): string
    {
        return $this->buildUrl($prefix);
    }

    protected function buildUrl(string $prefix): string
    {
        return $this->isSubUrl ? $prefix . $this->value : $this->value;
    }
}
