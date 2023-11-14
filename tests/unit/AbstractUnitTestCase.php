<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Nuvemshop\CustomFields\Infrastructure\Log\Formatter\ConsoleFormatter;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTestCase extends TestCase
{
    protected const DEFAULT_LOG_MESSAGE = "Testing the method %s with parameters: %s";

    protected Logger $logger;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configLogger();
    }

    private function configLogger(): void
    {
        $this->logger = new Logger((string)getenv('APPLICATION_NAME'));

        $handler = new StreamHandler('php://stdout', Level::Debug);
        $handler->setFormatter(new ConsoleFormatter());
        $handler->pushProcessor(new PsrLogMessageProcessor());

        $this->logger->pushHandler($handler);
        $this->logger->useMicrosecondTimestamps(true);
    }
}
