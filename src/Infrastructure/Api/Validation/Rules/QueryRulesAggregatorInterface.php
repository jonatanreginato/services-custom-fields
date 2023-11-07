<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules;

interface QueryRulesAggregatorInterface extends RulesAggregatorInterface
{
    public function getAllowedFilters(): array;
}
