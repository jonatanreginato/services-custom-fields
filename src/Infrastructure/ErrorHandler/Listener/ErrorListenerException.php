<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Listener;

use DomainException;
use Throwable;

class ErrorListenerException extends DomainException
{
    public function __construct($message = '', $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'ApiError listener error',
            $code,
            $previous
        );
    }
}
