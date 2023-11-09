<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Middleware;

use Psr\Container\ContainerInterface;
use Nuvemshop\CustomFields\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class LoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): LoggerMiddleware
    {
        try {
            /** @var LoggerFacade $loggerFacade */
            $loggerFacade = $container->build(
                $container->get('config')['log']['http_messages']['logger'],
                $container->get('config')['log']['http_messages']['options']
            );
        } catch (Throwable $e) {
            throw new LoggerException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return new LoggerMiddleware($loggerFacade->logger);
    }
}
