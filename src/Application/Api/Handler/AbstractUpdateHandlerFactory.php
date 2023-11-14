<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Domain\Action;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractUpdateHandlerFactory
{
    use ClassIsTrait;

    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        assert(static::classImplements($requestedName, HandlerInterface::class));

        /** @var Validation\Parser\BodyParserInterface $bodyParser */
        $bodyParser = $container->get(Validation\Parser\BodyParserInterface::class);
        $bodyParser->setBodyRules($container->get($this->selectRulesClass($requestedName)));

        /** @var Action\UpdaterActionInterface $action */
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
            OrderHandler\UpdateFieldHandler::class => Validation\Rules\CustomField\UpdateRules::class,
            OrderHandler\UpdateOptionHandler::class => Validation\Rules\Option\UpdateRules::class,
            OrderHandler\UpdateAssociationHandler::class => Validation\Rules\Association\UpdateRules::class,
        };
    }

    private function selectActionClass(string $requestedHandlerClass): string
    {
        return match ($requestedHandlerClass) {
            OrderHandler\UpdateFieldHandler::class => Action\OrderField\FieldUpdaterAction::class,
            OrderHandler\UpdateOptionHandler::class => Action\OrderField\OptionUpdaterAction::class,
            OrderHandler\UpdateAssociationHandler::class => Action\OrderField\AssociationUpdaterAction::class,
        };
    }
}
