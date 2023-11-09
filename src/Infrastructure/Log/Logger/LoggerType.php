<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger;

enum LoggerType
{
    public const CONSOLE       = 'CONSOLE_LOG';
    public const FILE          = 'FILE_LOG';
    public const ELASTICSEARCH = 'ELASTICSEARCH_LOG';
    public const NEW_RELIC     = 'NEW_RELIC_LOG';
    public const SLACK         = 'SLACK_NOTIFICATION';
}
