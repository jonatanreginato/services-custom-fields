<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

interface BodyParserInterface extends ParserInterface
{
    public function setBodyRules(BodyRulesAggregatorInterface $bodyRules): void;

    public function parse(string $requestBody): void;

    public function getCaptures(): array;
}
