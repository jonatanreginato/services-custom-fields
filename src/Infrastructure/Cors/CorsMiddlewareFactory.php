<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Cors;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Throwable;
use Tuupola\Middleware\CorsMiddleware;

class CorsMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareInterface
    {
        try {
            $options = $container->get('config')['cors'] ?? [];
        } catch (Throwable $e) {
            throw new CorsMiddlewareException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return new CorsMiddleware($options);
    }
}
