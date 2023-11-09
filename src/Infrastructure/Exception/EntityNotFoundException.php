<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Exception;

use DomainException;
use Throwable;

class EntityNotFoundException extends DomainException
{
    public function __construct(string $message = '', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Entity not found.',
            $code,
            $previous
        );
    }
}
