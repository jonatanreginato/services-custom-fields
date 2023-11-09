<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler;

use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Domain;
use Nuvemshop\CustomFields\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbstractUpdateHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName): RequestHandlerInterface
    {
        /** @var BodyParserInterface $bodyParser */
        $bodyParser = $container->get(BodyParserInterface::class);
        $bodyParser->setBodyRules($container->get($this->selectRulesClass($requestedName)));

        return new BaseHandler(
            new $requestedName(
                $bodyParser,
                $container->get($this->selectActionClass($requestedName)),
                $container->get(EncoderInterface::class)
            ),
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
            OrderHandler\UpdateFieldHandler::class => Domain\Action\Order\FieldUpdaterAction::class,
            OrderHandler\UpdateOptionHandler::class => Domain\Action\Order\OptionUpdaterAction::class,
            OrderHandler\UpdateAssociationHandler::class => Domain\Action\Order\AssociationUpdaterAction::class,
        };
    }
}
