<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Rules;

interface BodyRulesInterface extends RulesInterface
{
    public function getAllowedAttributes(): array;

    public function getRequiredAttributes(): array;
}
