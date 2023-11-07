<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors;

interface SimpleErrorInterface
{
    public function getParameterName(): ?string;

    public function getParameterValue(): mixed;

    public function getMessageCode(): int;

    public function getMessageTemplate(): string;

    public function getMessageParameters(): array;
}
