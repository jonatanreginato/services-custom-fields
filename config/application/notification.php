<?php

declare(strict_types=1);

return [
    'notification' => [
        'slack' => [
            'token'   => getenv('SLACK_TOKEN'),
            'channel' => getenv('SLACK_CHANNEL'),
        ],
    ],
];
