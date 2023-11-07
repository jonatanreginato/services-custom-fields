<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Enum;

use DomainException;
use InvalidArgumentException;
use Throwable;

enum OwnerResourceEnum: int
{
    case order = 1;
    case product_variant = 2;
    case customer = 3;
    case category = 4;
    case product = 5;

    public static function getFrom(int $data): OwnerResourceEnum
    {
        try {
            return self::from($data);
        } catch (Throwable) {
            throw new InvalidArgumentException(
                sprintf('The <%s> value is not a valid owner resource name', $data)
            );
        }
    }

    public static function fromName(string $name): OwnerResourceEnum
    {
        foreach (self::cases() as $ownerResourceEnum) {
            if ($name === $ownerResourceEnum->name) {
                return $ownerResourceEnum;
            }
        }

        throw new DomainException("$name is not a valid backing value for enum " . self::class);
    }
}
