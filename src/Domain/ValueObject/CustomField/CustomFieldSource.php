<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\CustomField;

use InvalidArgumentException;
use Nuvemshop\CustomFields\Domain\Enum\SourceEnum;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CustomFieldSource
{
    public SourceEnum $id;

    public function __construct(mixed $value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Format value invalid');
        }

        $this->id = SourceEnum::fromName($value);
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
