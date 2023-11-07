<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\ValueObject\CustomField;

use Nuvemshop\ApiTemplate\Infrastructure\Exception\InvalidUuidStringException;
use Nuvemshop\ApiTemplate\Infrastructure\Types\Uuid;

final class CustomFieldUuid
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidUuidStringException('Invalid UUID string: ' . $uuid);
        }

        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
