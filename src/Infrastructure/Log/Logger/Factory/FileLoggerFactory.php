<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Processor\PsrLogMessageProcessor;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdProviderInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMiddlewareInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;
use Psr\Container\ContainerInterface;

class FileLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoggerFacade
    {
        $facade = new LoggerFacade(
            new RequestIdMonologProcessor($container->get(RequestIdProviderInterface::class)),
            new StoreIdMonologProcessor($container->get(StoreIdMiddlewareInterface::class))
        );

        $streamHandler = new StreamHandler(
            $options['path'],
            Level::Debug,
            true,
            null,
            false
        );

        $streamHandler->pushProcessor(new PsrLogMessageProcessor());

        $monologHandlerMain = new FingersCrossedHandler(
            $streamHandler,
            new ErrorLevelActivationStrategy(Level::Debug),
            0,
            true,
            true,
            null
        );

        $facade->logger->pushHandler($monologHandlerMain);

        return $facade;
    }
}
