<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\OpenSearch;

use OpenSearch\Client as OpenSearchClient;
use Psr\Container\ContainerInterface;
use Throwable;

class OpenSearchFactory
{
    public function __invoke(ContainerInterface $container): OpenSearchClient
    {
        try {
            $facade = new OpenSearchFacade($container->get('config')['data_store']['open_search']);
        } catch (Throwable $e) {
            throw new OpenSearchException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $facade->client;
    }
}
