<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Handler;

use DomainException;
use Throwable;

class ErrorHandlerException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Error handler error.',
            $code,
            $previous
        );
    }
}
