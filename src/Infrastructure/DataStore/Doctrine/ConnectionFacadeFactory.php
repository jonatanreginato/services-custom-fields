<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\DataStore\Doctrine;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Nuvemshop\CustomFields\Infrastructure\Log\Processor\MetricProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdProviderInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMiddlewareInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\ContainerAwareEventManager;
use Symfony\Bridge\Doctrine\Logger\DbalLogger;
use Symfony\Component\Stopwatch\Stopwatch;
use Throwable;

class ConnectionFacadeFactory
{
    public function __invoke(ContainerInterface $container): ConnectionFacade
    {
        try {
            $connectionParams = $container->get('config')['data_store']['doctrine'];
        } catch (Throwable $e) {
            throw new DoctrineException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        if (!$connectionParams) {
            throw new DoctrineException('Missing doctrine connection config');
        }

        $configuration = new Configuration();
        if (getenv('APPLICATION_ENV') === 'development') {
            $configuration->setSQLLogger(
                $this->configSQLLogger($container)
            );
        }

        $eventManager = new ContainerAwareEventManager($container);

        return new ConnectionFacade($connectionParams, $configuration, $eventManager);
    }

    private function configSQLLogger(ContainerInterface $container): SQLLogger
    {
        $monologLogger = new Logger('doctrine');
        $monologLogger->pushProcessor(new MetricProcessor());
        $monologLogger->pushProcessor(
            new RequestIdMonologProcessor($container->get(RequestIdProviderInterface::class))
        );
        $monologLogger->pushProcessor(
            new StoreIdMonologProcessor($container->get(StoreIdMiddlewareInterface::class))
        );

        $streamHandler = new StreamHandler('/var/www/log/local.log', 100, true, null, false);
        $streamHandler->pushProcessor(new PsrLogMessageProcessor());
        $monologLogger->pushHandler($streamHandler);

        $dbalLogger = new DbalLogger(
            $monologLogger,
            new Stopwatch(true)
        );

        return new LoggerChain([$dbalLogger, new DebugStack()]);
    }
}
