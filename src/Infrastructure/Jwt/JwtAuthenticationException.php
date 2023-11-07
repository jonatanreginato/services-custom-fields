<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Jwt;

use DomainException;
use Throwable;

class JwtAuthenticationException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'JWT authentication error.',
            $code,
            $previous
        );
    }
}
