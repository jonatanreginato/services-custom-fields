<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Types;

use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\UuidInterface;

final class Uuid
{
    private UuidInterface|string $uuid;

    public static function new(): Uuid
    {
        $instance       = new self();
        $instance->uuid = BaseUuid::uuid4();

        return $instance;
    }

    public static function isValid(string $uuid): bool
    {
        return BaseUuid::isValid($uuid);
    }

    public static function fromString(string $stringId): Uuid
    {
        $instance       = new self();
        $instance->uuid = BaseUuid::fromString($stringId);

        return $instance;
    }

    public function __toString(): string
    {
        assert($this->uuid instanceof UuidInterface);

        return $this->uuid->toString();
    }
}
