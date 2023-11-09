<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\CustomField;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CustomFieldRestriction
{
    public function __construct(public bool $readOnlyField)
    {
    }

    public function isReadOnly(): bool
    {
        return $this->readOnlyField;
    }
}
