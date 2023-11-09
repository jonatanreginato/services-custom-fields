<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId\Generator;

use Ramsey\Uuid\Uuid;

final class Uuid4StaticGenerator implements GeneratorInterface
{
    public function generateRequestId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
