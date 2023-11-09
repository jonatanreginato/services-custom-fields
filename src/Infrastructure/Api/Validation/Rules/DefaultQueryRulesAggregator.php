<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules;

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
