<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception;

use DomainException;
use Throwable;

class JsonProcessException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'ApiError to processing Json encode/decode operation.',
            $code,
            $previous
        );
    }
}
