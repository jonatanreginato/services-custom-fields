<?php

declare(strict_types=1);

return [
    'mezzio' => [
        // Provide templates for the error handling middleware to use when generating responses.
        'error_handler' => [
            'template_404'   => 'error::404',
            'template_error' => 'error::error',
        ],
    ],
];
