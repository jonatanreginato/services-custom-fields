<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Monolog\Handler\SlackHandler;
use Monolog\Level;
use Psr\Container\ContainerInterface;
use Nuvemshop\CustomFields\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class SlackLoggerFactory
{
    public function __invoke(ContainerInterface $container): LoggerFacade
    {
        $facade = new LoggerFacade();

        try {
            $slackHandler = new SlackHandler(
                $container->get('config')['notification']['slack']['token'],
                $container->get('config')['notification']['slack']['channel']
            );

            $slackHandler->setLevel(Level::Info);
            $facade->logger->pushHandler($slackHandler);
        } catch (Throwable $e) {
            throw new LoggerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $facade;
    }
}
