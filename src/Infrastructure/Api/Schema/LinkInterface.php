<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Schema;

interface LinkInterface
{
    public function getStringRepresentation(string $prefix): string;
}
