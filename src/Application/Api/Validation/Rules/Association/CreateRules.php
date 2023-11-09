<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\Association;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CreateRules implements BodyRulesAggregatorInterface
{
    public function getAllowedAttributes(): array
    {
        return [
            'value',
            'owner_id',
        ];
    }

    public function getRequiredAttributes(): array
    {
        return $this->getAllowedAttributes();
    }
}
