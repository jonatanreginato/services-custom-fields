<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Schema;

interface LinkInterface
{
    public function getStringRepresentation(string $prefix): string;
}
