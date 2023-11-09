<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\QueryRulesAggregatorInterface;

final readonly class ReadRules implements QueryRulesAggregatorInterface
{
    public function getAllowedFilters(): array
    {
        return [
            'source',
        ];
    }
}
