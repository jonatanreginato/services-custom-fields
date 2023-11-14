<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules;

class DefaultBodyRules implements BodyRulesInterface
{
    public function getAllowedAttributes(): array
    {
        return [];
    }

    public function getRequiredAttributes(): array
    {
        return [];
    }
}
