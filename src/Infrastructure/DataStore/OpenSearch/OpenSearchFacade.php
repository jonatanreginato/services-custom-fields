<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\OpenSearch;

use OpenSearch;

class OpenSearchFacade
{
    public readonly OpenSearch\Client $client;

    public function __construct(array $config)
    {
        $hosts = [
            [
                'scheme' => $config['scheme'],
                'host'   => $config['host'],
                'port'   => $config['port'],
            ],
        ];

        $builder = OpenSearch\ClientBuilder::create()
            ->setHosts($hosts)
            ->setRetries(3);

        $client = $builder->build();

        $this->client = $client;
    }
}
