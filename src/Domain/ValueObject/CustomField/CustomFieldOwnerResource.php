<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField;

use InvalidArgumentException;
use Nuvemshop\ApiTemplate\Domain\Enum\OwnerResourceEnum;

final class CustomFieldOwnerResource
{
    public OwnerResourceEnum $id;

    public function __construct(mixed $value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Format value invalid');
        }

        $this->id = OwnerResourceEnum::fromName($value);
    }

    public function getId(): int
    {
        return $this->id->value;
    }

    public function __toString(): string
    {
        return $this->id->name;
    }
}
