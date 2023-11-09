<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Elasticsearch;

use Elastic\Elasticsearch;

class ElasticsearchFacade
{
    public readonly Elasticsearch\Client $client;

    public function __construct(array $config)
    {
        $hosts = [$config['host']];

        $builder = Elasticsearch\ClientBuilder::create()
            ->setHosts($hosts)
            ->setRetries(3);

        $client = $builder->build();

        $this->client = $client;
    }
}
