<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Response;

use Psr\Http\Message\ResponseInterface;
use Throwable;

interface ThrowableResponseInterface extends ResponseInterface
{
    public function getThrowable(): Throwable;
}
