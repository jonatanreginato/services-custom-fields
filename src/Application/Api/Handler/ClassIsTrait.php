<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use function array_key_exists;
use function assert;
use function class_exists;
use function interface_exists;

trait ClassIsTrait
{
    protected static function classImplements(string $class, string $interface): bool
    {
        assert(class_exists($class));
        assert(interface_exists($interface));

        return array_key_exists($interface, class_implements($class));
    }
}
