<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\QueryRulesAggregatorInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class ReadRules implements QueryRulesAggregatorInterface
{
    public function getAllowedFilters(): array
    {
        return [
            'source',
        ];
    }
}
