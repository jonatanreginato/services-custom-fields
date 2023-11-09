<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Exception;

use DomainException;
use Throwable;

class LoggerException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Logger error.',
            $code,
            $previous
        );
    }
}
