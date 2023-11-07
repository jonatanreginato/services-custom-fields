<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Validation\Parser;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Rules\BodyRulesAggregatorInterface;

interface BodyParserInterface extends ParserInterface
{
    public function setBodyRules(BodyRulesAggregatorInterface $bodyRules): void;

    public function parse(string $requestBody): void;

    public function getCaptures(): array;
}
