<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Enum;

use DomainException;
use InvalidArgumentException;
use Throwable;

enum SourceEnum: int
{
    case admin = 1;
    case app = 2;

    public static function getFrom(int $data): SourceEnum
    {
        try {
            return self::from($data);
        } catch (Throwable) {
            throw new InvalidArgumentException(
                sprintf('The <%s> value is not a valid owner resource name', $data)
            );
        }
    }

    public static function fromName(string $name): SourceEnum
    {
        foreach (self::cases() as $sourceEnum) {
            if ($name === $sourceEnum->name) {
                return $sourceEnum;
            }
        }

        throw new DomainException("$name is not a valid backing value for enum " . self::class);
    }
}
