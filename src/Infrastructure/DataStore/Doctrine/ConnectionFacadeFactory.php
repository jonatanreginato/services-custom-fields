<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\DataStore\Doctrine;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Processor\MetricProcessor;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Processor\XRequestIdProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
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
                $this->configSQLLogger()
            );
        }

        $eventManager = new ContainerAwareEventManager($container);

        return new ConnectionFacade($connectionParams, $configuration, $eventManager);
    }

    private function configSQLLogger(): SQLLogger
    {
        $monologLogger = new Logger('doctrine');
        $monologLogger->pushProcessor(new XRequestIdProcessor());
        $monologLogger->pushProcessor(new MetricProcessor());

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
