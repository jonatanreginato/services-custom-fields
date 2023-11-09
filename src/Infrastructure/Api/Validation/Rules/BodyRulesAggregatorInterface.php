<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules;

interface BodyRulesAggregatorInterface extends RulesAggregatorInterface
{
    public function getAllowedAttributes(): array;

    public function getRequiredAttributes(): array;
}
