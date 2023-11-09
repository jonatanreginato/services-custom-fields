<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers;

use Nuvemshop\CustomFields\Infrastructure\Api\Http\Response\ThrowableResponseInterface;
use Throwable;

interface ThrowableHandlerInterface
{
    public function createResponse(Throwable $throwable): ThrowableResponseInterface;
}
