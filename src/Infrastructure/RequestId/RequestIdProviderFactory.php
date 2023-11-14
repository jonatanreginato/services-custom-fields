<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Nuvemshop\CustomFields\Infrastructure\RequestId\Generator\Uuid4StaticGenerator;

final class RequestIdProviderFactory
{
    public function __invoke(): RequestIdProviderInterface
    {
        return new RequestIdProvider(new Uuid4StaticGenerator());
    }
}
