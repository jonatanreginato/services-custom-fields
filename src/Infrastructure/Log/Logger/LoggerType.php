<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Logger;

enum LoggerType
{
    case ConsoleLog;
    case FileLog;
    case ElasticsearchLog;
    case OpenSearchLog;
    case NewRelicLog;
    case SlackNotification;
    case SlackWebhookNotification;
}
