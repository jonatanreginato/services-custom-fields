<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Parser;

interface IdentifierInterface
{
    public function getType(): string;

    public function getId(): mixed;
}
