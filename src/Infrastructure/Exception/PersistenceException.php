<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception;

use DomainException;
use Throwable;

class PersistenceException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Database persistence error.',
            $code,
            $previous
        );
    }
}
