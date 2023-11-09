<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Listener;

use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerType;
use Psr\Container\ContainerInterface;
use Throwable;

class NewRelicListenerFactory
{
    public function __invoke(ContainerInterface $container): NewRelicListener
    {
        try {
            /** @var LoggerFacade $facade */
            $facade = $container->get(LoggerType::NEW_RELIC);

            return new NewRelicListener($facade->logger);
        } catch (Throwable $e) {
            throw new ErrorListenerException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }
    }
}
