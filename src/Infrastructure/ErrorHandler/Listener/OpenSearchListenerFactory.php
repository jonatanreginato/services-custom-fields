<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Listener;

use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerType;
use Psr\Container\ContainerInterface;
use Throwable;

class OpenSearchListenerFactory
{
    public function __invoke(ContainerInterface $container): OpenSearchListener
    {
        try {
            /** @var LoggerFacade $facade */
            $facade = $container->build(
                $container->get('config')['log']['open_search_error_listener']['logger'],
                $container->get('config')['log']['open_search_error_listener']['options']
            );

            return new OpenSearchListener($facade->logger);
        } catch (Throwable $e) {
            throw new ErrorListenerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
