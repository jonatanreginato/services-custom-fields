<?php

declare(strict_types=1);

return [
    'jwt' => [
        'secret' => getenv('JWT_SECRET'),
        'secure' => false,
        'path'   => '/api',
        'ignore' => '/api/v1/token',
    ],
];
