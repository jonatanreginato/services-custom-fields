<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors;

use ArrayIterator;
use Traversable;

use function count;

class ErrorCollection implements ErrorCollectionInterface
{
    private array $errors = [];

    public function add(ApiErrorInterface $error): ErrorCollection
    {
        $this->errors[] = $error;

        return $this;
    }

    public function get(): array
    {
        return $this->errors;
    }

    public function clear(): ErrorCollection
    {
        $this->errors = [];

        return $this;
    }

    public function count(): int
    {
        return count($this->errors);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->errors);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->errors[$offset]);
    }

    public function offsetGet($offset): bool
    {
        return $this->errors[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $offset === null
            ? $this->add($value)
            : $this->errors[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->errors[$offset]);
    }
}
