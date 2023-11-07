<?php

declare(strict_types=1);

use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerType;

return [
    'log' => [
        'http_messages'                => [
            'logger'  => LoggerType::ElasticsearchLog->name,
            'options' => [
                'index' => getenv('ELASTICSEARCH_HTTP_INDEX'),
            ],
        ],
        'elasticsearch_error_listener' => [
            'logger'  => LoggerType::ElasticsearchLog->name,
            'options' => [
                'index' => getenv('ELASTICSEARCH_ERRORS_INDEX'),
            ],
        ],
        'file_error_listener'          => [
            'logger'  => LoggerType::FileLog->name,
            'options' => [
                'path' => '/var/www/log/application.log',
            ],
        ],
    ],
];
