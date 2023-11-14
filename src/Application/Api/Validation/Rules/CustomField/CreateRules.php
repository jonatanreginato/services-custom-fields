<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Application\Api\Validation\Rules\BodyRulesInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CreateRules implements BodyRulesInterface
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
