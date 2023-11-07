<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Parser;

interface ParserInterface
{
    public function parse(mixed $data): iterable;
}
