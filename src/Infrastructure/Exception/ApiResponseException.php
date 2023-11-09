<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception;

use DomainException;
use Throwable;

class ApiResponseException extends DomainException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Client error',
            $code,
            $previous
        );
    }
}
