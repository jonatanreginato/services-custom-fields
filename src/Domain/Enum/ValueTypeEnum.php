<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Enum;

use DomainException;
use InvalidArgumentException;
use Throwable;

enum ValueTypeEnum: int
{
    case text_list = 1;
    case text = 2;
    case numeric = 3;
    case date = 4;

    public static function getFrom(int $data): ValueTypeEnum
    {
        try {
            return self::from($data);
        } catch (Throwable) {
            throw new InvalidArgumentException(
                sprintf('The <%s> value is not a valid owner resource name', $data)
            );
        }
    }

    public static function fromName(string $name): ValueTypeEnum
    {
        foreach (self::cases() as $valueTypeEnum) {
            if ($name === $valueTypeEnum->name) {
                return $valueTypeEnum;
            }
        }

        throw new DomainException("$name is not a valid backing value for enum " . self::class);
    }
}
