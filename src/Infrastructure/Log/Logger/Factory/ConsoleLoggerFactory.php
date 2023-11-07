<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Processor\PsrLogMessageProcessor;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Formatter\ConsoleFormatter;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;

class ConsoleLoggerFactory
{
    public function __invoke(): LoggerFacade
    {
        $facade = new LoggerFacade();

        $handler = new StreamHandler('php://stdout', Level::Debug);
        $handler->setFormatter(new ConsoleFormatter());
        $handler->pushProcessor(new PsrLogMessageProcessor());

        $facade->logger->pushHandler($handler);

        return $facade;
    }
}
