<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapper;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapperInterface;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Domain\Action;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractReadHandlerFactory
{
    use ClassIsTrait;

    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        assert(static::classImplements($requestedName, HandlerInterface::class));

        /** @var Validation\Parser\QueryParserInterface $queryParser */
        $queryParser = $container->get(Validation\Parser\QueryParserInterface::class);
        $queryParser->setQueryRules($container->get($this->selectRulesClass($requestedName)));

        /** @var ParametersMapperInterface $parametersMapper */
        $parametersMapper = $container->get(ParametersMapper::class);

        /** @var Action\SearcherActionInterface $action */
        $action = $container->get($this->selectActionClass($requestedName));

        /** @var HandlerInterface $handler */
        $handler = new $requestedName($queryParser, $parametersMapper, $action);

        return new BaseHandler(
            $handler,
            $container->get(ThrowableHandlerInterface::class)
        );
    }

    private function selectRulesClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            // Custom field
            OrderHandler\ListFieldsHandler::class,
            OrderHandler\ReadFieldHandler::class => Validation\Rules\CustomField\ReadRules::class,
            // Option
            OrderHandler\ListOptionsHandler::class,
            OrderHandler\ReadOptionHandler::class => Validation\Rules\Option\ReadRules::class,
            // Association
            OrderHandler\ListAssociationsHandler::class,
            OrderHandler\ReadAssociationHandler::class => Validation\Rules\Association\ReadRules::class,
        };
    }

    private function selectActionClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            // Custom field
            OrderHandler\ListFieldsHandler::class,
            OrderHandler\ReadFieldHandler::class => Action\OrderField\FieldSearcherAction::class,
            // Option
            OrderHandler\ListOptionsHandler::class,
            OrderHandler\ReadOptionHandler::class => Action\OrderField\OptionSearcherAction::class,
            // Association
            OrderHandler\ListAssociationsHandler::class,
            OrderHandler\ReadAssociationHandler::class => Action\OrderField\AssociationSearcherAction::class,
        };
    }
}
