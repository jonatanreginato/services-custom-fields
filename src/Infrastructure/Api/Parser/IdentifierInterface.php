<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Parser;

interface IdentifierInterface
{
    public function getType(): string;

    public function getId(): mixed;
}
