<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\ApiRequest;

class HttpClientResponse
{
    public function __construct(private readonly string $body, private readonly int $code = 200)
    {
    }

    public function code(): int
    {
        return $this->code;
    }

    public function body(): string
    {
        return $this->body;
    }
}
