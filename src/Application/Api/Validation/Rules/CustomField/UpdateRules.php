<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class UpdateRules implements BodyRulesAggregatorInterface
{
    public function getAllowedAttributes(): array
    {
        return [
            'name',
            'description',
        ];
    }

    public function getRequiredAttributes(): array
    {
        return [];
    }
}
