<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Query;

// phpcs:ignoreFile -- this is a readonly class
readonly class FilterParameter implements FilterParameterInterface
{
    public function __construct(
        public string $field,
        public iterable $operationsAndArgs
    ) {
    }
}
