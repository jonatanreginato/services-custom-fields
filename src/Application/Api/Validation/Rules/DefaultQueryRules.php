<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules;

class DefaultQueryRules implements QueryRulesInterface
{
    public function getAllowedFilters(): array
    {
        return [];
    }
}
