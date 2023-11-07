<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField;

use InvalidArgumentException;
use Nuvemshop\ApiTemplate\Domain\ValueObject\StringType;

final readonly class CustomFieldName extends StringType
{
    private const MAX_LENGTH = 60;

    public function __construct(mixed $value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Format value invalid');
        }

        if (strlen($value) > $this->maxLength()) {
            throw new InvalidArgumentException(sprintf('Name length value not valid, expected max %s', $value));
        }

        parent::__construct($value);
    }

    private function maxLength(): int
    {
        return self::MAX_LENGTH;
    }
}
