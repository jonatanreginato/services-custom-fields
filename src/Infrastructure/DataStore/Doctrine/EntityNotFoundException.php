<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine;

use DomainException;
use Throwable;

class EntityNotFoundException extends DomainException
{
    public function __construct(?string $message, ?int $code = 404, Throwable $previous = null)
    {
        parent::__construct(
            $message ?? 'Entity not found',
            $code ?? 404,
            $previous
        );
    }
}
