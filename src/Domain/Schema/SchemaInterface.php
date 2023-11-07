<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Schema;

interface SchemaInterface
{
    public static function getType(): string;

    public function getAttributes(): array;
}
