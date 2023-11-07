<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate;

use DomainException;
use Throwable;

class MockException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Mock error.',
            $code,
            $previous
        );
    }
}
