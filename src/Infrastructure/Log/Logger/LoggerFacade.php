<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Logger;

use Nuvemshop\ApiTemplate\Infrastructure\Log\Processor\MetricProcessor;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Processor\XRequestIdProcessor;
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\WebProcessor;

class LoggerFacade implements LoggerInterface
{
    public readonly Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger((string)getenv('APPLICATION_NAME'));

        $this->logger->pushProcessor(new XRequestIdProcessor());
        $this->logger->pushProcessor(new MetricProcessor());
        $this->logger->pushProcessor(new ProcessIdProcessor());
        $this->logger->pushProcessor(new MemoryUsageProcessor());
        $this->logger->pushProcessor(new MemoryPeakUsageProcessor());
        $this->logger->pushProcessor(new WebProcessor());

        $this->logger->useMicrosecondTimestamps(true);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function notice(string $message, array $context = []): void
    {
        $this->logger->notice($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }

    public function alert(string $message, array $context = []): void
    {
        $this->logger->alert($message, $context);
    }

    public function emergency(string $message, array $context = []): void
    {
        $this->logger->emergency($message, $context);
    }
}
