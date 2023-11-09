<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Monolog\Handler\NewRelicHandler;
use Monolog\Level;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;

class NewRelicLoggerFactory
{
    public function __invoke(): LoggerFacade
    {
        $facade = new LoggerFacade();

        $newrelicHandler = new NewRelicHandler(
            Level::Error,
            true,
            (string)getenv('APPLICATION_NAME')
        );

        $facade->logger->pushHandler($newrelicHandler);

        return $facade;
    }
}
