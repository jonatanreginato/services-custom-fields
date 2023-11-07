<?php

declare(strict_types=1);

use Nuvemshop\ApiTemplate\Application\Api\Handler\AbstractCreateHandlerFactory;
use Nuvemshop\ApiTemplate\Application\Api\Handler\AbstractDeleteHandlerFactory;
use Nuvemshop\ApiTemplate\Application\Api\Handler\AbstractReadHandlerFactory;
use Nuvemshop\ApiTemplate\Application\Api\Handler\AbstractUpdateHandlerFactory;
use Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\ApiTemplate\Application\Api\Validation;
use Nuvemshop\ApiTemplate\Application\Web;
use Nuvemshop\ApiTemplate\Domain;
use Nuvemshop\ApiTemplate\Infrastructure;

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
            Web\HomePageHandler::class                         => Web\AbstractHtmlHandlerFactory::class,
            Web\TeamHandler::class                             => Web\AbstractHtmlHandlerFactory::class,
            Web\ResourcesHandler::class                        => Web\AbstractHtmlHandlerFactory::class,
            Web\SetupHandler::class                            => Web\AbstractHtmlHandlerFactory::class,
            Web\ContributingHandler::class                     => Web\AbstractHtmlHandlerFactory::class,
            Web\ConductCodeHandler::class                      => Web\AbstractHtmlHandlerFactory::class,
            Web\SourceCodeHandler::class                       => Web\AbstractHtmlHandlerFactory::class,
            Web\CodingStandardsHandler::class                  => Web\AbstractHtmlHandlerFactory::class,
            Web\CommitStandardsHandler::class                  => Web\AbstractHtmlHandlerFactory::class,
            Web\ContributionGuideHandler::class                => Web\AbstractHtmlHandlerFactory::class,
            Web\ContributionCheatsheetHandler::class           => Web\AbstractHtmlHandlerFactory::class,
            Web\DocumentationHandler::class                    => Web\AbstractHtmlHandlerFactory::class,
            Web\LicenseHandler::class                          => Web\AbstractHtmlHandlerFactory::class,
            Web\CoverageHandler::class                         => Web\AbstractHtmlHandlerFactory::class,

            // -- API HANDLERS --
            // custom order fields
            OrderHandler\ListFieldsHandler::class              => AbstractReadHandlerFactory::class,
            OrderHandler\ReadFieldHandler::class               => AbstractReadHandlerFactory::class,
            OrderHandler\CreateFieldHandler::class             => AbstractCreateHandlerFactory::class,
            OrderHandler\UpdateFieldHandler::class             => AbstractUpdateHandlerFactory::class,
            OrderHandler\DeleteFieldHandler::class             => AbstractDeleteHandlerFactory::class,

            // custom order fields options
            OrderHandler\ListOptionsHandler::class             => AbstractReadHandlerFactory::class,
            OrderHandler\ReadOptionHandler::class              => AbstractReadHandlerFactory::class,
            OrderHandler\CreateOptionHandler::class            => AbstractCreateHandlerFactory::class,
            OrderHandler\UpdateOptionHandler::class            => AbstractUpdateHandlerFactory::class,
            OrderHandler\DeleteOptionHandler::class            => AbstractDeleteHandlerFactory::class,

            // custom order fields associations
            OrderHandler\ListAssociationsHandler::class        => AbstractReadHandlerFactory::class,
            OrderHandler\ReadAssociationHandler::class         => AbstractReadHandlerFactory::class,
            OrderHandler\CreateAssociationHandler::class       => AbstractCreateHandlerFactory::class,
            OrderHandler\UpdateAssociationHandler::class       => AbstractUpdateHandlerFactory::class,
            OrderHandler\DeleteAssociationHandler::class       => AbstractDeleteHandlerFactory::class,

            // domain's associations
            OrderHandler\ListOrderAssociationsHandler::class   => AbstractReadHandlerFactory::class,
        ],
    ],
];
