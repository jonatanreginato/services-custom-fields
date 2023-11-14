<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Elasticsearch;

use Elastic\Elasticsearch;

// phpcs:ignoreFile -- this is a readonly class
readonly class ElasticsearchFacade
{
    public Elasticsearch\Client $client;

    public function __construct(array $config)
    {
        $hosts = [$config['host'] . ':' . $config['port']];

        $builder = Elasticsearch\ClientBuilder::create()
            ->setHosts($hosts)
            ->setRetries(3);

        $client = $builder->build();

        $this->client = $client;
    }
}
