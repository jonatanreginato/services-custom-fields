<?php

declare(strict_types=1);

use Mezzio\Application;
use Nuvemshop\ApiTemplate\Application\Api\Handler\OrderField\V1 as OrderHandler;
use Nuvemshop\ApiTemplate\Application\Web;

const UUID           = '/{uuid:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}';
const ID             = '/{id:\d+}';
const API_URI_PREFIX = '/api';
const ORDERS         = API_URI_PREFIX . '/v1/orders';
const ORDER_FIELDS   = API_URI_PREFIX . '/v1/order-fields';
const OPTIONS        = '/options';
const ASSOCIATIONS   = '/associations';

return static function (Application $app) {
    // WEB HTML
    $app->get('/', Web\HomePageHandler::class, 'home');
    $app->get('/team', Web\TeamHandler::class, 'team');
    $app->get('/resources', Web\ResourcesHandler::class, 'resources');
    $app->get('/setup', Web\SetupHandler::class, 'setup');
    $app->get('/contributing', Web\ContributingHandler::class, 'contributing');
    $app->get('/conduct-code', Web\ConductCodeHandler::class, 'conduct.code');
    $app->get('/source-code', Web\SourceCodeHandler::class, 'source-code');
    $app->get('/coding-standards', Web\CodingStandardsHandler::class, 'coding.standards');
    $app->get('/commit-standards', Web\CommitStandardsHandler::class, 'commit.standards');
    $app->get('/contribution-guide', Web\ContributionGuideHandler::class, 'contribution.guide');
    $app->get('/contribution-cheatsheet', Web\ContributionCheatsheetHandler::class, 'contribution.cheatsheet');
    $app->get('/documentation', Web\DocumentationHandler::class, 'documentation');
    $app->get('/license', Web\LicenseHandler::class, 'license');
    $app->get('/test-coverage/{type:\w+}', Web\CoverageHandler::class, 'coverage');

    // CUSTOM FIELD ASSOCIATIONS BY OWNER ID
    $app->get(ORDERS . ID . ASSOCIATIONS, OrderHandler\ListOrderAssociationsHandler::class);

    // CUSTOM ORDER FIELDS - CONFIG
    $app->get(ORDER_FIELDS, OrderHandler\ListFieldsHandler::class);
    $app->post(ORDER_FIELDS, OrderHandler\CreateFieldHandler::class);
    $app->get(ORDER_FIELDS . UUID, OrderHandler\ReadFieldHandler::class);
    $app->patch(ORDER_FIELDS . UUID, OrderHandler\UpdateFieldHandler::class);
    $app->delete(ORDER_FIELDS . UUID, OrderHandler\DeleteFieldHandler::class);

    // CUSTOM ORDER FIELDS - OPTIONS
    $app->get(ORDER_FIELDS . UUID . OPTIONS, OrderHandler\ListOptionsHandler::class);
    $app->post(ORDER_FIELDS . UUID . OPTIONS, OrderHandler\CreateOptionHandler::class);
    $app->get(ORDER_FIELDS . UUID . OPTIONS . ID, OrderHandler\ReadOptionHandler::class);
    $app->patch(ORDER_FIELDS . UUID . OPTIONS . ID, OrderHandler\UpdateOptionHandler::class);
    $app->delete(ORDER_FIELDS . UUID . OPTIONS . ID, OrderHandler\DeleteOptionHandler::class);

    // CUSTOM ORDER FIELDS - ASSOCIATIONS
    $app->get(ORDER_FIELDS . UUID . ASSOCIATIONS, OrderHandler\ListAssociationsHandler::class);
    $app->post(ORDER_FIELDS . UUID . ASSOCIATIONS, OrderHandler\CreateAssociationHandler::class);
    $app->get(ORDER_FIELDS . UUID . ASSOCIATIONS . ID, OrderHandler\ReadAssociationHandler::class);
    $app->patch(ORDER_FIELDS . UUID . ASSOCIATIONS . ID, OrderHandler\UpdateAssociationHandler::class);
    $app->delete(ORDER_FIELDS . UUID . ASSOCIATIONS . ID, OrderHandler\DeleteAssociationHandler::class);
};
