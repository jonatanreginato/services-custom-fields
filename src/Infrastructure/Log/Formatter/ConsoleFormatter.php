<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Formatter;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

class ConsoleFormatter implements FormatterInterface
{
    public function format(LogRecord $record): string
    {
        $message = $record['message'] ?? '';

        return "[{$record['level_name']}] $message" . PHP_EOL;
    }

    public function formatBatch(array $records): string
    {
        $message = '';
        foreach ($records as $record) {
            $message .= $this->format($record);
        }

        return $message;
    }
}
