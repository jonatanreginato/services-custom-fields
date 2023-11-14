<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Parser;

use Nuvemshop\CustomFields\Application\Api\Validation\Rules\BodyRulesInterface;

interface BodyParserInterface extends ParserInterface
{
    public function setBodyRules(BodyRulesInterface $bodyRules): void;

    public function parse(string $requestBody): void;

    public function getCaptures(): array;
}
