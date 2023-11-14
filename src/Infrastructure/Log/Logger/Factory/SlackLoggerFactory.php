<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\SlackHandler;
use Monolog\Level;
use Nuvemshop\CustomFields\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdProviderInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMiddlewareInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;
use Psr\Container\ContainerInterface;
use Throwable;

class SlackLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoggerFacade
    {
        $facade = new LoggerFacade(
            new RequestIdMonologProcessor($container->get(RequestIdProviderInterface::class)),
            new StoreIdMonologProcessor($container->get(StoreIdMiddlewareInterface::class))
        );

        try {
            $slackHandler = new SlackHandler($options['token'], $options['channel']);

            $slackHandler->setLevel(Level::Info);
            $facade->logger->pushHandler($slackHandler);
        } catch (Throwable $e) {
            throw new LoggerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $facade;
    }
}
