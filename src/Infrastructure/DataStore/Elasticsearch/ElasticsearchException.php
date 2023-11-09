<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Elasticsearch;

use DomainException;
use Throwable;

class ElasticsearchException extends DomainException
{
    public function __construct(string $message = '', int $code = 500, Throwable $previous = null)
    {
        parent::__construct(
            $message ?: 'Elasticsearch error.',
            $code,
            $previous
        );
    }
}
