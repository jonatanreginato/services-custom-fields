<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Schema;

interface SchemaInterface
{
    public static function getType(): string;

    public function getAttributes(): array;
}
