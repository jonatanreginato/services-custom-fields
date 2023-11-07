<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Representation;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ApiErrorInterface;

interface ErrorWriterInterface extends BaseWriterInterface
{
    public function addError(ApiErrorInterface $error): self;
}
