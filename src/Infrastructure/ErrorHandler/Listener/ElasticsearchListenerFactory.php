<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class ElasticsearchListenerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ElasticsearchListener {
        try {
            /** @var LoggerFacade $facade */
            $facade = $container->build(
                $container->get('config')['log']['elasticsearch_error_listener']['logger'],
                $container->get('config')['log']['elasticsearch_error_listener']['options']
            );

            return new ElasticsearchListener($facade->logger);
        } catch (Throwable $e) {
            throw new ErrorListenerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
