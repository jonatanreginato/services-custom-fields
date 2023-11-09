<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields;

use DomainException;
use Throwable;

class UnitTestException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Test execution error.',
            $code,
            $previous
        );
    }
}
