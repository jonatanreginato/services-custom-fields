<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors;

readonly class ApiError implements ApiErrorInterface
{
    public function __construct(
        private ?string $status = null,
        private ?string $code = null,
        private ?string $title = null,
        private ?string $detail = null,
        private ?array $source = null
    ) {
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function getSource(): ?array
    {
        return $this->source;
    }
}
