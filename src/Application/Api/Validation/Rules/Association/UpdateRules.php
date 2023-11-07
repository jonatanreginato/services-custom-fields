<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Validation\Rules\Association;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

final readonly class UpdateRules implements BodyRulesAggregatorInterface
{
    public function getAllowedAttributes(): array
    {
        return [
            'value',
        ];
    }

    public function getRequiredAttributes(): array
    {
        return $this->getAllowedAttributes();
    }
}
