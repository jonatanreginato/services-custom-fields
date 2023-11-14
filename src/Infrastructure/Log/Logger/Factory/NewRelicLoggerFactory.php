<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Monolog\Handler\NewRelicHandler;
use Monolog\Level;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdProviderInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMiddlewareInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;
use Psr\Container\ContainerInterface;

class NewRelicLoggerFactory
{
    public function __invoke(ContainerInterface $container): LoggerFacade
    {
        $facade = new LoggerFacade(
            new RequestIdMonologProcessor($container->get(RequestIdProviderInterface::class)),
            new StoreIdMonologProcessor($container->get(StoreIdMiddlewareInterface::class))
        );

        $newrelicHandler = new NewRelicHandler(
            Level::Error,
            true,
            (string)getenv('APPLICATION_NAME')
        );

        $facade->logger->pushHandler($newrelicHandler);

        return $facade;
    }
}
