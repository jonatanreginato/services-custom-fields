<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Pdo;

use DomainException;
use Throwable;

class PdoConnectionException extends DomainException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'ApiError on PDO database connection.',
            $code,
            $previous
        );
    }
}
