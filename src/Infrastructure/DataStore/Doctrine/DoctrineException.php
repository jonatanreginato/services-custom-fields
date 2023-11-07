<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine;

use DomainException;
use Throwable;

class DoctrineException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Doctrine error.',
            $code,
            $previous
        );
    }
}
