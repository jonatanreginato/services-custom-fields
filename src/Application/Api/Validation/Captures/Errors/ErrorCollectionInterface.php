<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors;

use ArrayAccess;
use Countable;
use IteratorAggregate;

interface ErrorCollectionInterface extends IteratorAggregate, Countable, ArrayAccess
{
    public function add(ApiErrorInterface $error): ErrorCollectionInterface;

    public function get(): array;

    public function clear(): ErrorCollectionInterface;
}
