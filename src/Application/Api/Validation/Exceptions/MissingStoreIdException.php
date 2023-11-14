<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Exceptions;

use DomainException;
use Throwable;

class MissingStoreIdException extends DomainException
{
    public function __construct(string $message = '', int $code = 400, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Invalid or missing store id',
            $code,
            $previous
        );
    }
}
