<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Processor;

use Monolog\LogRecord;

class MetricProcessor
{
    private const LOAD_1_MINUTE = 0;

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['execution_time'] = round((microtime(true) - START_EXECUTION_TIME) * 1000);
        $record->extra['cpu_count']      = $this->getCpuCount();
        $record->extra['load_average']   = $this->getLoadAverage();
        $record->extra['ru_utime']       = $this->resourceUsageTime('utime');
        $record->extra['ru_stime']       = $this->resourceUsageTime('stime');

        return $record;
    }

    private function getCpuCount(): int
    {
        $cpuCount = 1;
        if (is_file('/proc/cpuinfo')) {
            $cpuInfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpuInfo, $matches);
            $cpuCount = count($matches[0]);
        }

        return $cpuCount;
    }

    private function getLoadAverage(): ?float
    {
        if (!function_exists('sys_getloadavg')) {
            return null;
        }

        $usage = sys_getloadavg();
        if (false === $usage) {
            return null;
        }

        return $usage[self::LOAD_1_MINUTE] / $this->getCpuCount();
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
