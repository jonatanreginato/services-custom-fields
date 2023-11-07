<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler;

use Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\ApiTemplate\Domain;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractDeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        return new BaseHandler(
            new $requestedName(
                $container->get($this->selectActionClass($requestedName)),
                $container->get(EncoderInterface::class)
            ),
            $container->get(ThrowableHandlerInterface::class)
        );
    }

    private function selectActionClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            OrderHandler\DeleteFieldHandler::class => Domain\Action\Order\FieldDeleterAction::class,
            OrderHandler\DeleteOptionHandler::class => Domain\Action\Order\OptionDeleterAction::class,
            OrderHandler\DeleteAssociationHandler::class => Domain\Action\Order\AssociationDeleterAction::class,
        };
    }
}
