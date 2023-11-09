<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Processor;

use Monolog\LogRecord;

use function is_string;

class XRequestIdProcessor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $requestId = !is_string(REQUEST_ID) ? (REQUEST_ID)->toString() : REQUEST_ID;

        !empty($record['context']['request_id'])
            ? $record['extra']['request_id'] = $record['context']['request_id']
            : $record['extra']['request_id'] = $requestId;

        return $record;
    }
}
