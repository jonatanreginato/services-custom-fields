<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler;

use Nuvemshop\CustomFields\Application\Api\Response\ThrowableResponseInterface;
use Throwable;

interface ThrowableHandlerInterface
{
    public function createResponse(Throwable $throwable): ThrowableResponseInterface;
}
