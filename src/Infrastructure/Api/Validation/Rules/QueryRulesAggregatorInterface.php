<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules;

interface QueryRulesAggregatorInterface extends RulesAggregatorInterface
{
    public function getAllowedFilters(): array;
}
