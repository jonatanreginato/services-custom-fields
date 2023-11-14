<?php

declare(strict_types=1);

use Nuvemshop\CustomFields\Application\Api\Settings\ApiSettingsInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ThrowableConverter;

$jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT;

return [
    'api' => [
        ApiSettingsInterface::IS_LOG_ENABLED                     => filter_var(getenv('APP_ENABLE_LOGS'), 258),
        ApiSettingsInterface::IS_DEBUG                           => filter_var(getenv('APP_IS_DEBUG'), 258),
        ApiSettingsInterface::DO_NOT_LOG_EXCEPTIONS_LIST         => [],
        ApiSettingsInterface::HTTP_CODE_FOR_UNEXPECTED_THROWABLE => 500,
        ApiSettingsInterface::JSON_API_EXCEPTION_CONVERTER       => ThrowableConverter::class,
        ApiSettingsInterface::JSON_ENCODE_OPTIONS                => $jsonOptions,
        ApiSettingsInterface::JSON_ENCODE_DEPTH                  => 512,
    ]
];
