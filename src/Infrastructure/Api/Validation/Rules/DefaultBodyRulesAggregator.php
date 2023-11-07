<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules;

class DefaultBodyRulesAggregator implements BodyRulesAggregatorInterface
{
    public function getAllowedAttributes(): array
    {
        return [];
    }

    public function getRequiredAttributes(): array
    {
        return [];
    }
}
