<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler;

use Nuvemshop\ApiTemplate\Domain;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractCountHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        return new BaseHandler(
            new $requestedName(
                $container->get(Domain\Action\CounterAction::class)
            ),
            $container->get(ThrowableHandlerInterface::class)
        );
    }
}
