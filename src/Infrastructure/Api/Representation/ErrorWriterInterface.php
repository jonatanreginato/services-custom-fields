<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Representation;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ApiErrorInterface;

interface ErrorWriterInterface extends BaseWriterInterface
{
    public function addError(ApiErrorInterface $error): self;
}
