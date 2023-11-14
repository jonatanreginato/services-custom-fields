<?php

declare(strict_types=1);

use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerFactory;
use Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapper;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Data\DataAggregator;
use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ErrorAggregator;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\ParserFactory;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Infrastructure\Cors;
use Nuvemshop\CustomFields\Infrastructure\DataStore;
use Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Handler;
use Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Listener as ErrorListener;
use Nuvemshop\CustomFields\Infrastructure\Jwt;
use Nuvemshop\CustomFields\Infrastructure\Log;
use Nuvemshop\CustomFields\Infrastructure\RequestId;
use Nuvemshop\CustomFields\Infrastructure\StoreId;

return [
    'dependencies' => [
        'invokables' => [
            DataAggregator::class,
            ErrorAggregator::class,
            ParametersMapper::class,
        ],
        'factories'  => [
            Tuupola\Middleware\JwtAuthentication::class        => Jwt\JwtAuthenticationFactory::class,
            RequestId\RequestIdProviderInterface::class        => RequestId\RequestIdProviderFactory::class,
            RequestId\RequestIdMiddlewareInterface::class      => RequestId\RequestIdMiddlewareFactory::class,
            StoreId\StoreIdMiddlewareInterface::class          => StoreId\StoreIdMiddlewareFactory::class,
            Tuupola\Middleware\CorsMiddleware::class           => Cors\CorsMiddlewareFactory::class,
            Doctrine\ORM\EntityManager::class                  => DataStore\Doctrine\EntityManagerFactory::class,
            DataStore\Doctrine\ConnectionFacade::class         => DataStore\Doctrine\ConnectionFacadeFactory::class,
            DataStore\Elasticsearch\ElasticsearchFacade::class => DataStore\Elasticsearch\ElasticsearchFactory::class,
            Log\Logger\LoggerType::CONSOLE                     => Log\Logger\Factory\ConsoleLoggerFactory::class,
            Log\Logger\LoggerType::FILE                        => Log\Logger\Factory\FileLoggerFactory::class,
            Log\Logger\LoggerType::NEW_RELIC                   => Log\Logger\Factory\NewRelicLoggerFactory::class,
            Log\Logger\LoggerType::ELASTICSEARCH               => Log\Logger\Factory\ElasticsearchLoggerFactory::class,
            Log\Logger\LoggerType::SLACK                       => Log\Logger\Factory\SlackLoggerFactory::class,
            Log\Middleware\LoggerMiddlewareInterface::class    => Log\Middleware\LoggerMiddlewareFactory::class,
            ErrorListener\ElasticsearchListener::class         => ErrorListener\ElasticsearchListenerFactory::class,
            ErrorListener\NewRelicListener::class              => ErrorListener\NewRelicListenerFactory::class,
            ErrorListener\FileListener::class                  => ErrorListener\FileListenerFactory::class,
            QueryParserInterface::class                        => ParserFactory::class,
            BodyParserInterface::class                         => ParserFactory::class,
            ThrowableHandlerInterface::class                   => ThrowableHandlerFactory::class,
        ],
        'delegators' => [
            Laminas\Stratigility\Middleware\ErrorHandler::class => [Handler\ErrorHandlerFactory::class],
        ],
    ],
];
