<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractCreateHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        /** @var BodyParserInterface $bodyParser */
        $bodyParser = $container->get(BodyParserInterface::class);
        $bodyParser->setBodyRules($container->get($this->selectRulesClass($requestedName)));

        return new BaseHandler(
            new $requestedName(
                $bodyParser,
                $container->get($this->selectActionClass($requestedName))
            ),
            $container->get(ThrowableHandlerInterface::class)
        );
    }

    private function selectRulesClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            OrderHandler\CreateFieldHandler::class => Validation\Rules\CustomField\CreateRules::class,
            OrderHandler\CreateOptionHandler::class => Validation\Rules\Option\CreateRules::class,
            OrderHandler\CreateAssociationHandler::class => Validation\Rules\Association\CreateRules::class,
        };
    }

    private function selectActionClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            OrderHandler\CreateFieldHandler::class => Domain\Action\Order\FieldCreatorAction::class,
            OrderHandler\CreateOptionHandler::class => Domain\Action\Order\OptionCreatorAction::class,
            OrderHandler\CreateAssociationHandler::class => Domain\Action\Order\AssociationCreatorAction::class,
        };
    }
}
