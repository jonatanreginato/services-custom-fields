<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\RequestId;

use PhpMiddleware\RequestId\Generator\RamseyUuid4StaticGenerator;
use PhpMiddleware\RequestId\RequestIdMiddleware;
use PhpMiddleware\RequestId\RequestIdProviderFactory;
use Psr\Http\Server\MiddlewareInterface;

class RequestIdMiddlewareFactory
{
    public function __invoke(): MiddlewareInterface
    {
        $generator       = new RamseyUuid4StaticGenerator();
        $providerFactory = new RequestIdProviderFactory($generator);

        return new RequestIdMiddleware($providerFactory);
    }
}
