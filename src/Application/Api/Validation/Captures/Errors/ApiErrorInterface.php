<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors;

interface ApiErrorInterface
{
    public const SOURCE_POINTER = 'pointer';
    public const SOURCE_PARAMETER = 'parameter';

    public function getStatus(): ?string;

    public function getCode(): ?string;

    public function getTitle(): ?string;

    public function getDetail(): ?string;

    public function getSource(): ?array;
}
