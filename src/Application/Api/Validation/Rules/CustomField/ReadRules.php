<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Application\Api\Validation\Rules\QueryRulesInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class ReadRules implements QueryRulesInterface
{
    public function getAllowedFilters(): array
    {
        return [
            'source',
        ];
    }
}
