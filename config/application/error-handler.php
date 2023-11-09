<?php

declare(strict_types=1);

use Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Listener\ElasticsearchListener;
use Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Listener\FileListener;
use Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Listener\NewRelicListener;

return match (getenv('APPLICATION_ENV')) {
    'development' => [
        'error_handler' => [
            'listeners' => [
                ElasticsearchListener::class,
                FileListener::class,
            ],
        ],
    ],
    'staging', 'production' => [
        'error_handler' => [
            'listeners' => [
                ElasticsearchListener::class,
                NewRelicListener::class,
            ],
        ],
    ]
};
