<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Log\Logger\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Level;
use Nuvemshop\CustomFields\Infrastructure\DataStore\Elasticsearch\ElasticsearchFacade;
use Nuvemshop\CustomFields\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\CustomFields\Infrastructure\Log\Handler\TimeOutBufferHandler;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerFacade;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdMonologProcessor;
use Nuvemshop\CustomFields\Infrastructure\RequestId\RequestIdProviderInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMiddlewareInterface;
use Nuvemshop\CustomFields\Infrastructure\StoreId\StoreIdMonologProcessor;
use Psr\Container\ContainerInterface;
use Throwable;

class ElasticsearchLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoggerFacade
    {
        $facade = new LoggerFacade(
            new RequestIdMonologProcessor($container->get(RequestIdProviderInterface::class)),
            new StoreIdMonologProcessor($container->get(StoreIdMiddlewareInterface::class))
        );

        try {
            $settings = [
                'index'        => $options['index'],
                'type'         => '_doc',
                'ignore_error' => false,
            ];

            $config = $container->get('config')['data_store']['elasticsearch'];
            $client = (new ElasticsearchFacade($config))->client;

            $streamHandler = new ElasticsearchHandler($client, $settings, Level::Debug);
            $bufferHandler = new TimeOutBufferHandler($streamHandler, 100, Level::Debug, true, true);

            $facade->logger->pushHandler($bufferHandler);
        } catch (Throwable $e) {
            throw new LoggerException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
        }

        return $facade;
    }
}
