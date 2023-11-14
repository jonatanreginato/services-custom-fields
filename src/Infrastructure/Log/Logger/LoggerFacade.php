<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger;

use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;
use Nuvemshop\CustomFields\Infrastructure\Log\Processor\MetricProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;

// phpcs:ignoreFile -- this is a readonly class
readonly class LoggerFacade implements LoggerInterface
{
    public Logger $logger;

    public function __construct(
        RequestIdMonologProcessor $requestIdProcessor,
        StoreIdMonologProcessor $storeIdProcessor
    ) {
        $this->logger = new Logger((string)getenv('APPLICATION_NAME'));

        $this->logger->pushProcessor(new PsrLogMessageProcessor());
        $this->logger->pushProcessor(new ProcessIdProcessor());
        $this->logger->pushProcessor(new MetricProcessor());
        $this->logger->pushProcessor(new MemoryUsageProcessor());
        $this->logger->pushProcessor(new MemoryPeakUsageProcessor());
        $this->logger->pushProcessor(new WebProcessor());

        $this->logger->pushProcessor($requestIdProcessor);
        $this->logger->pushProcessor($storeIdProcessor);

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
