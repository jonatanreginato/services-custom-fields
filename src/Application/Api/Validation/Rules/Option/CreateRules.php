<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules\Option;

use Nuvemshop\CustomFields\Application\Api\Validation\Rules\BodyRulesInterface;

// phpcs:ignoreFile -- this is a readonly class
final readonly class CreateRules implements BodyRulesInterface
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
