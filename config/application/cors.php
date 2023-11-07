<?php

declare(strict_types=1);

return [
    'cors' => [
        'origin'         => ['*'],
        'methods'        => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
        'headers.allow'  => ['Content-Type', 'Accept'],
        'headers.expose' => [],
        'credentials'    => false,
        'cache'          => 0,
    ],
];
