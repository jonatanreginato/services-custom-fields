<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Exception;

use Throwable;

class DomainException extends \DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
