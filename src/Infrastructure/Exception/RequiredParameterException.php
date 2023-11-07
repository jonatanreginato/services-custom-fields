<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Exception;

use DomainException;
use Throwable;

class RequiredParameterException extends DomainException
{
    public function __construct(string $message = '', int $code = 422, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Required parameter not found.',
            $code,
            $previous
        );
    }
}
