<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId\Generator;

interface GeneratorInterface
{
    public function generateRequestId(): string;
}
