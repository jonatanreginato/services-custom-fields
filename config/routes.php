<?php

declare(strict_types=1);

use Mezzio\Application;
use Nuvemshop\CustomFields\Application\Api\Handler\CustomField\V1 as CustomField;
use Nuvemshop\CustomFields\Application\Api\Handler\Order\V1 as Order;
use Nuvemshop\CustomFields\Application\Api\Handler\OrderField\V1 as OrderField;
use Nuvemshop\CustomFields\Application\Api\Handler\Token\V1 as Token;
use Nuvemshop\CustomFields\Application\Web;

const UUID           = '/{uuid:[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}}';
const ID             = '/{id:\d+}';
const API_URI_PREFIX = '/api';
const ORDERS         = API_URI_PREFIX . '/v1/orders';
const CUSTOM_FIELDS   = API_URI_PREFIX . '/v1/custom-fields';
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

    // TOKEN
    $app->post('/api/v1/token', Token\TokenHandler::class);

    // CUSTOM FIELDS
    $app->get(CUSTOM_FIELDS . '/count', CustomField\CountHandler::class);

    // CUSTOM ORDER FIELDS
    $app->get(ORDER_FIELDS, OrderField\ListFieldsHandler::class);
    $app->post(ORDER_FIELDS, OrderField\CreateFieldHandler::class);
    $app->get(ORDER_FIELDS . UUID, OrderField\ReadFieldHandler::class);
    $app->patch(ORDER_FIELDS . UUID, OrderField\UpdateFieldHandler::class);
    $app->delete(ORDER_FIELDS . UUID, OrderField\DeleteFieldHandler::class);
    $app->get(ORDER_FIELDS . UUID . OPTIONS, OrderField\ListOptionsHandler::class);
    $app->post(ORDER_FIELDS . UUID . OPTIONS, OrderField\CreateOptionHandler::class);
    $app->get(ORDER_FIELDS . UUID . OPTIONS . ID, OrderField\ReadOptionHandler::class);
    $app->patch(ORDER_FIELDS . UUID . OPTIONS . ID, OrderField\UpdateOptionHandler::class);
    $app->delete(ORDER_FIELDS . UUID . OPTIONS . ID, OrderField\DeleteOptionHandler::class);
    $app->get(ORDER_FIELDS . UUID . ASSOCIATIONS, OrderField\ListAssociationsHandler::class);
    $app->post(ORDER_FIELDS . UUID . ASSOCIATIONS, OrderField\CreateAssociationHandler::class);
    $app->get(ORDER_FIELDS . UUID . ASSOCIATIONS . ID, OrderField\ReadAssociationHandler::class);
    $app->patch(ORDER_FIELDS . UUID . ASSOCIATIONS . ID, OrderField\UpdateAssociationHandler::class);
    $app->delete(ORDER_FIELDS . UUID . ASSOCIATIONS . ID, OrderField\DeleteAssociationHandler::class);

    // ORDERS
    $app->get(ORDERS . ID . ASSOCIATIONS, Order\ListOrderAssociationsHandler::class);
};
