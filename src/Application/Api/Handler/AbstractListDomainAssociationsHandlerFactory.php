<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler;

use Nuvemshop\ApiTemplate\Application\Api\Handler\Order\V1 as OrderHandler;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\ApiTemplate\Domain;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractListDomainAssociationsHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        /** @var QueryParserInterface $queryParser */
        $queryParser = $container->get(QueryParserInterface::class);

        return new BaseHandler(
            new $requestedName(
                $queryParser,
                $container->get($this->selectActionClass($requestedName))
            ),
            $container->get(ThrowableHandlerInterface::class)
        );
    }

    private function selectActionClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            // Order
            OrderHandler\ListOrderAssociationsHandler::class => Domain\Action\Order\SearcherAction::class,
        };
    }
}
