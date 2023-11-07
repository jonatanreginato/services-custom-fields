<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Processor;

use Monolog\LogRecord;

class MetricProcessor
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $loadAvg = (array)sys_getloadavg();
        $loadAvg = $loadAvg[0] ?? 0.0;

        $record['extra']['execution_time'] = round((microtime(true) - START_EXECUTION_TIME) * 1000);
        $record['extra']['load_avg']       = $loadAvg;
        $record['extra']['ru_utime']       = $this->resourceUsageTime('utime');
        $record['extra']['ru_stime']       = $this->resourceUsageTime('stime');

        return $record;
    }

    private function resourceUsageTime(string $index): float
    {
        $resourceUsage     = (array)getrusage();
        $secResourceUsage  = $resourceUsage["ru_$index.tv_sec"] ?? 0.0;
        $usecResourceUsage = $resourceUsage["ru_$index.tv_usec"] ?? 0.0;

        return (($secResourceUsage * 1000) + (int)($usecResourceUsage / 1000))
            - ((RESOURCE_USAGE["ru_$index.tv_sec"] * 1000) + (int)(RESOURCE_USAGE["ru_$index.tv_usec"] / 1000));
    }
}
