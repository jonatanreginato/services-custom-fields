<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response\ThrowableResponseInterface;
use Throwable;

interface ThrowableHandlerInterface
{
    public function createResponse(Throwable $throwable): ThrowableResponseInterface;
}
