<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\ValueObject;

use InvalidArgumentException;

readonly class IdentifierType implements IdentifierInterface
{
    public int $id;

    public function __construct(mixed $value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Value <{$value}> is not numeric");
        }

        if (is_string($value) && str_contains($value, '.')) {
            throw new InvalidArgumentException("Value <{$value}> is not a valid integer number");
        }

        if ((int)$value < 0) {
            throw new InvalidArgumentException("Value <{$value}> should not be negative");
        }

        $this->id = (int)$value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }
}
