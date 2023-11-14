<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Settings;

interface ApiSettingsInterface
{
    public const IS_LOG_ENABLED                     = 'is_log_enabled';
    public const IS_DEBUG                           = 'is_debug';
    public const DO_NOT_LOG_EXCEPTIONS_LIST         = 'do_not_log_exceptions_list';
    public const HTTP_CODE_FOR_UNEXPECTED_THROWABLE = 'http_code_for_unexpected_throwable';
    public const JSON_API_EXCEPTION_CONVERTER       = 'throwable_to_api_exception_converter';
    public const JSON_ENCODE_OPTIONS                = 'json_encode_options';
    public const JSON_ENCODE_DEPTH                  = 'json_encode_depth';
}
