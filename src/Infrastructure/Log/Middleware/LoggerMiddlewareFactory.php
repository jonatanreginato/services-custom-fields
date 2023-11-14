<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Middleware;

use Nuvemshop\CustomFields\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Throwable;

class LoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareInterface
    {
        try {
            /** @var LoggerFacade $loggerFacade */
            $loggerFacade = $container->build(
                $container->get('config')['log']['elasticsearch_logs']['logger'],
                $container->get('config')['log']['elasticsearch_logs']['options']
            );
        } catch (Throwable $e) {
            throw new LoggerException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return new LoggerMiddleware($loggerFacade->logger);
    }
}
