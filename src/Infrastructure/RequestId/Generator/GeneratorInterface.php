<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId\Generator;

interface GeneratorInterface
{
    public function generateRequestId(): string;
}
