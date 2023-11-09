<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Http\Response;

use Psr\Http\Message\ResponseInterface;
use Throwable;

interface ThrowableResponseInterface extends ResponseInterface
{
    public function getThrowable(): Throwable;
}
