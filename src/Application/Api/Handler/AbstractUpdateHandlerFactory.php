<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Handler;

use Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\ApiTemplate\Application\Api\Validation;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Domain;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
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
