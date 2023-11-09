<?php

declare(strict_types=1);

use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerType;

return [
    'log' => [
        'http_messages'                => [
            'logger'  => LoggerType::ELASTICSEARCH,
            'options' => [
                'index' => getenv('ELASTICSEARCH_HTTP_INDEX'),
            ],
        ],
        'elasticsearch_error_listener' => [
            'logger'  => LoggerType::ELASTICSEARCH,
            'options' => [
                'index' => getenv('ELASTICSEARCH_ERRORS_INDEX'),
            ],
        ],
        'file_error_listener'          => [
            'logger'  => LoggerType::FILE,
            'options' => [
                'path' => '/var/www/log/file_error_listener.log',
            ],
        ],
        'file_throwable_handler'          => [
            'logger'  => LoggerType::FILE,
            'options' => [
                'path' => '/var/www/log/file_throwable_handler.log',
            ],
        ],
    ],
];
