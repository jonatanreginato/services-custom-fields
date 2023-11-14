<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Exception;

use DomainException;
use Throwable;

class JsonProcessException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Error to processing Json encode/decode operation.',
            $code,
            $previous
        );
    }
}
