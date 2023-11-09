<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CreateRules implements BodyRulesAggregatorInterface
{
    public function getAllowedAttributes(): array
    {
        return [
            'uuid',
            'namespace',
            'key',
            'owner_resource',
            'value_type',
            'source',
            'name',
            'description',
            'read_only',
            'app_id',
        ];
    }

    public function getRequiredAttributes(): array
    {
        return [
            'namespace',
            'owner_resource',
            'value_type',
            'source',
            'name',
            'read_only',
        ];
    }
}
