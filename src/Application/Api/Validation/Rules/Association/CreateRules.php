<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Validation\Rules\Association;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

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
