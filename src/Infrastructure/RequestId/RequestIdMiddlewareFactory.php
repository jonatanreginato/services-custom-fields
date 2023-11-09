<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

use Nuvemshop\ApiTemplate\Infrastructure\RequestId\Generator\Uuid4StaticGenerator;
use Psr\Http\Server\MiddlewareInterface;

class RequestIdMiddlewareFactory
{
    public function __invoke(): MiddlewareInterface
    {
        $generator       = new Uuid4StaticGenerator();
        $providerFactory = new RequestIdProviderFactory($generator);

        return new RequestIdMiddleware($providerFactory);
    }
}
