<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\OpenSearch;

use DomainException;
use Throwable;

class OpenSearchException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'OpenSearch error.',
            $code,
            $previous
        );
    }
}
