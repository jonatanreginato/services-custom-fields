<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Processor\PsrLogMessageProcessor;
use Nuvemshop\CustomFields\Infrastructure\Log\Formatter\ConsoleFormatter;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdProviderInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMiddlewareInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;
use Psr\Container\ContainerInterface;

class ConsoleLoggerFactory
{
    public function __invoke(ContainerInterface $container): LoggerFacade
    {
        $facade = new LoggerFacade(
            new RequestIdMonologProcessor($container->get(RequestIdProviderInterface::class)),
            new StoreIdMonologProcessor($container->get(StoreIdMiddlewareInterface::class))
        );

        $handler = new StreamHandler('php://stdout', Level::Debug);
        $handler->setFormatter(new ConsoleFormatter());
        $handler->pushProcessor(new PsrLogMessageProcessor());

        $facade->logger->pushHandler($handler);

        return $facade;
    }
}
