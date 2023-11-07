<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\Factory;

use Monolog\Handler\SlackWebhookHandler;
use Monolog\Level;
use Psr\Container\ContainerInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class SlackWebhookLoggerFactory
{
    public function __invoke(ContainerInterface $container): LoggerFacade
    {
        $facade = new LoggerFacade();

        try {
            $slackHandler = new SlackWebhookHandler(
                $container->get('config')['notification']['slack']['webhook_url']
            );

            $slackHandler->setLevel(Level::Info);
            $facade->logger->pushHandler($slackHandler);
        } catch (Throwable $e) {
            throw new LoggerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $facade;
    }
}
