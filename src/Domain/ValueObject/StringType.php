<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject;

readonly class StringType implements DescriptionInterface
{
    public function __construct(public string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
