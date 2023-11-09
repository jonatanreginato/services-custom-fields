<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapper;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapperInterface;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Domain;
use Nuvemshop\CustomFields\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractReadHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        /** @var QueryParserInterface $queryParser */
        $queryParser = $container->get(QueryParserInterface::class);
        $queryParser->setQueryRules($container->get($this->selectRulesAggregatorClass($requestedName)));

        /** @var ParametersMapperInterface $parametersMapper */
        $parametersMapper = $container->get(ParametersMapper::class);

        return new BaseHandler(
            new $requestedName(
                $queryParser,
                $parametersMapper,
                $container->get($this->selectActionClass($requestedName)),
                $container->get(EncoderInterface::class)
            ),
            $container->get(ThrowableHandlerInterface::class)
        );
    }

    private function selectRulesAggregatorClass(string $requestedHandlerClass): string
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
            OrderHandler\ReadFieldHandler::class => Domain\Action\Order\FieldSearcherAction::class,
            // Option
            OrderHandler\ListOptionsHandler::class,
            OrderHandler\ReadOptionHandler::class => Domain\Action\Order\OptionSearcherAction::class,
            // Association
            OrderHandler\ListAssociationsHandler::class,
            OrderHandler\ReadAssociationHandler::class => Domain\Action\Order\AssociationSearcherAction::class,
        };
    }
}
