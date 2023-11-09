<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields;

use Monolog\Level;
use Nuvemshop\CustomFields\Infrastructure\Log\Formatter\ConsoleFormatter;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTestCase extends TestCase
{
    protected const DEFAULT_LOG_MESSAGE = "Testing the method %s with parameters: %s";

    protected Logger $logger;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->configLogger();
    }

    private function configLogger(): Logger
    {
        $facade  = new LoggerFacade();
        $handler = new StreamHandler('php://stdout', Level::Debug);
        $handler->setFormatter(new ConsoleFormatter());
        $handler->pushProcessor(new PsrLogMessageProcessor());
        $facade->logger->pushHandler($handler);

        return $facade->logger;
    }
}
