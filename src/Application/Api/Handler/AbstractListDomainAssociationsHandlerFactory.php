<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\Order\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Domain;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
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
