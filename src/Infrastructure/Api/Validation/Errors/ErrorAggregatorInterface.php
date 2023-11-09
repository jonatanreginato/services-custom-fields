<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors;

interface ErrorAggregatorInterface
{
    public function addQueryParameterApiError(SimpleErrorInterface $error, int $errorStatus): void;

    public function addBodyApiError(SimpleErrorInterface $error, int $errorStatus): void;

    public function addApiError(string $title, string $detail = null, string $status = null): self;

    public function addErrorStatus(int $status): void;

    public function getErrorStatus(): int;
}
