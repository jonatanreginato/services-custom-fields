<?php

declare(strict_types=1);

use Nuvemshop\CustomFields\Application\Api\Handler\AbstractCreateHandlerFactory;
use Nuvemshop\CustomFields\Application\Api\Handler\AbstractDeleteHandlerFactory;
use Nuvemshop\CustomFields\Application\Api\Handler\AbstractReadHandlerFactory;
use Nuvemshop\CustomFields\Application\Api\Handler\AbstractUpdateHandlerFactory;
use Nuvemshop\CustomFields\Application\Api\Handler\BaseHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\CustomField\V1 as CustomFieldHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\ListDomainAssociationsHandlerFactory;
use Nuvemshop\CustomFields\Application\Api\Handler\Order\V1 as OrderHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderFieldHandler;
use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Handler\Token\V1 as Token;
use Nuvemshop\CustomFields\Application\Api\Validation;
use Nuvemshop\CustomFields\Application\Web;
use Nuvemshop\CustomFields\Domain\Action\CustomFieldsCounterAction;
use Nuvemshop\CustomFields\Infrastructure;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'invokables' => [
            // Custom fields
            Validation\Rules\CustomField\ReadRules::class,
            Validation\Rules\CustomField\CreateRules::class,
            Validation\Rules\CustomField\UpdateRules::class,

            // Options
            Validation\Rules\Option\ReadRules::class,
            Validation\Rules\Option\CreateRules::class,
            Validation\Rules\Option\UpdateRules::class,

            // Associations
            Validation\Rules\Association\ReadRules::class,
            Validation\Rules\Association\CreateRules::class,
            Validation\Rules\Association\UpdateRules::class,
        ],
        'factories'  => [
            // -- WEB HANDLERS --
            Web\HomePageHandler::class                        => Web\AbstractHtmlHandlerFactory::class,
            Web\TeamHandler::class                            => Web\AbstractHtmlHandlerFactory::class,
            Web\ResourcesHandler::class                       => Web\AbstractHtmlHandlerFactory::class,
            Web\SetupHandler::class                           => Web\AbstractHtmlHandlerFactory::class,
            Web\ContributingHandler::class                    => Web\AbstractHtmlHandlerFactory::class,
            Web\ConductCodeHandler::class                     => Web\AbstractHtmlHandlerFactory::class,
            Web\SourceCodeHandler::class                      => Web\AbstractHtmlHandlerFactory::class,
            Web\CodingStandardsHandler::class                 => Web\AbstractHtmlHandlerFactory::class,
            Web\CommitStandardsHandler::class                 => Web\AbstractHtmlHandlerFactory::class,
            Web\ContributionGuideHandler::class               => Web\AbstractHtmlHandlerFactory::class,
            Web\ContributionCheatsheetHandler::class          => Web\AbstractHtmlHandlerFactory::class,
            Web\DocumentationHandler::class                   => Web\AbstractHtmlHandlerFactory::class,
            Web\LicenseHandler::class                         => Web\AbstractHtmlHandlerFactory::class,
            Web\CoverageHandler::class                        => Web\AbstractHtmlHandlerFactory::class,

            // -- API HANDLERS --
            // custom order fields
            OrderFieldHandler\ListFieldsHandler::class        => AbstractReadHandlerFactory::class,
            OrderFieldHandler\ReadFieldHandler::class         => AbstractReadHandlerFactory::class,
            OrderFieldHandler\CreateFieldHandler::class       => AbstractCreateHandlerFactory::class,
            OrderFieldHandler\UpdateFieldHandler::class       => AbstractUpdateHandlerFactory::class,
            OrderFieldHandler\DeleteFieldHandler::class       => AbstractDeleteHandlerFactory::class,

            // custom order fields options
            OrderFieldHandler\ListOptionsHandler::class       => AbstractReadHandlerFactory::class,
            OrderFieldHandler\ReadOptionHandler::class        => AbstractReadHandlerFactory::class,
            OrderFieldHandler\CreateOptionHandler::class      => AbstractCreateHandlerFactory::class,
            OrderFieldHandler\UpdateOptionHandler::class      => AbstractUpdateHandlerFactory::class,
            OrderFieldHandler\DeleteOptionHandler::class      => AbstractDeleteHandlerFactory::class,

            // custom order fields associations
            OrderFieldHandler\ListAssociationsHandler::class  => AbstractReadHandlerFactory::class,
            OrderFieldHandler\ReadAssociationHandler::class   => AbstractReadHandlerFactory::class,
            OrderFieldHandler\CreateAssociationHandler::class => AbstractCreateHandlerFactory::class,
            OrderFieldHandler\UpdateAssociationHandler::class => AbstractUpdateHandlerFactory::class,
            OrderFieldHandler\DeleteAssociationHandler::class => AbstractDeleteHandlerFactory::class,

            // domain's associations
            OrderHandler\ListOrderAssociationsHandler::class  => ListDomainAssociationsHandlerFactory::class,

            // count custom fields
            CustomFieldHandler\CountHandler::class            =>
                static fn(ContainerInterface $container) => new BaseHandler(
                    new CustomFieldHandler\CountHandler($container->get(CustomFieldsCounterAction::class)),
                    $container->get(ThrowableHandlerInterface::class)
                ),

            // generate token
            Token\TokenHandler::class                         =>
                static fn(ContainerInterface $container) => new BaseHandler(
                    new Token\TokenHandler(),
                    $container->get(ThrowableHandlerInterface::class)
                ),
        ],
    ],
];
