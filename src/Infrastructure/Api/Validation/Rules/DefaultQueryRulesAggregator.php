<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules;

class DefaultQueryRulesAggregator implements QueryRulesAggregatorInterface
{
    public function getAllowedFilters(): array
    {
        return [];
    }

    public function getRequiredFilters(): array
    {
        return [];
    }
}
