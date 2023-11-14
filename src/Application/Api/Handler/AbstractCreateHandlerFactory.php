<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Domain\Action;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractCreateHandlerFactory
{
    use ClassIsTrait;

    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        assert(static::classImplements($requestedName, HandlerInterface::class));

        /** @var Validation\Parser\BodyParserInterface $bodyParser */
        $bodyParser = $container->get(Validation\Parser\BodyParserInterface::class);
        $bodyParser->setBodyRules($container->get($this->selectRulesClass($requestedName)));

        /** @var Action\CreatorActionInterface $action */
        $action = $container->get($this->selectActionClass($requestedName));

        /** @var HandlerInterface $handler */
        $handler = new $requestedName($bodyParser, $action);

        return new BaseHandler(
            $handler,
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
            OrderHandler\CreateFieldHandler::class => Action\OrderField\FieldCreatorAction::class,
            OrderHandler\CreateOptionHandler::class => Action\OrderField\OptionCreatorAction::class,
            OrderHandler\CreateAssociationHandler::class => Action\OrderField\AssociationCreatorAction::class,
        };
    }
}
