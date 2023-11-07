<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Listener;

use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerType;
use Psr\Container\ContainerInterface;
use Throwable;

class NewRelicListenerFactory
{
    public function __invoke(ContainerInterface $container): NewRelicListener
    {
        try {
            /** @var LoggerFacade $facade */
            $facade = $container->get(LoggerType::NewRelicLog->name);

            return new NewRelicListener($facade->logger);
        } catch (Throwable $e) {
            throw new ErrorListenerException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
    }
}
