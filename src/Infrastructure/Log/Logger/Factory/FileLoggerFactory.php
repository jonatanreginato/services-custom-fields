<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Container\ContainerInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;

class FileLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoggerFacade
    {
        $facade = new LoggerFacade();

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
