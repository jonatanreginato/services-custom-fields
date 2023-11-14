<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\RequestId;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class RequestIdMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareInterface
    {
        return new RequestIdMiddleware(
            $container->get(RequestIdProviderInterface::class)
        );
    }
}
