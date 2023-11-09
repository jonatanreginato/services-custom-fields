<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\CustomField;

use InvalidArgumentException;
use Nuvemshop\CustomFields\Domain\Enum\ValueTypeEnum;

final readonly class CustomFieldValueType
{
    public ValueTypeEnum $id;

    public function __construct(mixed $value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Format value invalid');
        }

        $this->id = ValueTypeEnum::fromName($value);
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
