<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Level;
use Psr\Container\ContainerInterface;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore\Elasticsearch\ElasticsearchFacade;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Exception\LoggerException;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Handler\TimeOutBufferHandler;
use Nuvemshop\ApiTemplate\Infrastructure\Log\Logger\LoggerFacade;
use Throwable;

class ElasticsearchLoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoggerFacade
    {
        $facade = new LoggerFacade();

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
