<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules\QueryRulesAggregatorInterface;

final readonly class ReadRules implements QueryRulesAggregatorInterface
{
    public function getAllowedFilters(): array
    {
        return [
            'source',
        ];
    }
}
