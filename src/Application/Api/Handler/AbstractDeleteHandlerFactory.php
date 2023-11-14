<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Domain\Action;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractDeleteHandlerFactory
{
    use ClassIsTrait;

    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        assert(static::classImplements($requestedName, HandlerInterface::class));

        /** @var HandlerInterface $handler */
        $handler = new $requestedName($container->get($this->selectActionClass($requestedName)));

        return new BaseHandler(
            $handler,
            $container->get(ThrowableHandlerInterface::class)
        );
    }

    private function selectActionClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            OrderHandler\DeleteFieldHandler::class => Action\OrderField\FieldDeleterAction::class,
            OrderHandler\DeleteOptionHandler::class => Action\OrderField\OptionDeleterAction::class,
            OrderHandler\DeleteAssociationHandler::class => Action\OrderField\AssociationDeleterAction::class,
        };
    }
}
