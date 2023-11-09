<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception;

use DomainException;
use Throwable;

class InvalidParameterException extends DomainException
{
    public function __construct(string $message = '', int $code = 422, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Invalid parameter.',
            $code,
            $previous
        );
    }
}
