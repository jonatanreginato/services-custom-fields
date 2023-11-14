<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\CustomField;

use Nuvemshop\CustomFields\Application\Api\Validation\Rules\BodyRulesInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class UpdateRules implements BodyRulesInterface
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
