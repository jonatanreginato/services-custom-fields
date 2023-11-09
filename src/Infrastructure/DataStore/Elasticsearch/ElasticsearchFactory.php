<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Elasticsearch;

use Elastic\Elasticsearch\Client as ElasticsearchClient;
use Psr\Container\ContainerInterface;
use Throwable;

class ElasticsearchFactory
{
    public function __invoke(ContainerInterface $container): ElasticsearchClient
    {
        try {
            $facade = new ElasticsearchFacade($container->get('config')['data_store']['elasticsearch']);
        } catch (Throwable $e) {
            throw new ElasticsearchException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $facade->client;
    }
}
