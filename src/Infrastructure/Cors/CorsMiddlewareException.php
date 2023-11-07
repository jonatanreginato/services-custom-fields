<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Cors;

use DomainException;
use Throwable;

class CorsMiddlewareException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'CORS Middleware error.',
            $code,
            $previous
        );
    }
}
