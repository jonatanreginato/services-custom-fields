<?php

declare(strict_types=1);

use Nuvemshop\ApiTemplate\Application\Api\Query\ParametersMapper;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\ParserFactory;
use Nuvemshop\ApiTemplate\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderFactory;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerFactory;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\SchemaContainerFactory;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Schema\SchemaContainerInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Captures\CaptureAggregator;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorAggregator;
use Nuvemshop\ApiTemplate\Infrastructure\Cors;
use Nuvemshop\ApiTemplate\Infrastructure\DataStore;
use Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Handler;
use Nuvemshop\ApiTemplate\Infrastructure\ErrorHandler\Listener as ErrorListener;
use Nuvemshop\ApiTemplate\Infrastructure\Jwt;
use Nuvemshop\ApiTemplate\Infrastructure\Log;
use Nuvemshop\ApiTemplate\Infrastructure\RequestId;

return [
    'dependencies' => [
        'invokables' => [
            CaptureAggregator::class,
            ErrorAggregator::class,
            ParametersMapper::class
        ],
        'factories'  => [
            Tuupola\Middleware\JwtAuthentication::class        => Jwt\JwtAuthenticationFactory::class,
            PhpMiddleware\RequestId\RequestIdMiddleware::class => RequestId\RequestIdMiddlewareFactory::class,
            Tuupola\Middleware\CorsMiddleware::class           => Cors\CorsMiddlewareFactory::class,
            Doctrine\ORM\EntityManager::class                  => DataStore\Doctrine\EntityManagerFactory::class,
            DataStore\Doctrine\ConnectionFacade::class         => DataStore\Doctrine\ConnectionFacadeFactory::class,
            DataStore\Elasticsearch\ElasticsearchFacade::class => DataStore\Elasticsearch\ElasticsearchFactory::class,
            DataStore\OpenSearch\OpenSearchFacade::class       => DataStore\OpenSearch\OpenSearchFactory::class,
            Log\Logger\LoggerType::ConsoleLog->name            => Log\Logger\Factory\ConsoleLoggerFactory::class,
            Log\Logger\LoggerType::FileLog->name               => Log\Logger\Factory\FileLoggerFactory::class,
            Log\Logger\LoggerType::NewRelicLog->name           => Log\Logger\Factory\NewRelicLoggerFactory::class,
            Log\Logger\LoggerType::ElasticsearchLog->name      => Log\Logger\Factory\ElasticsearchLoggerFactory::class,
            Log\Logger\LoggerType::OpenSearchLog->name         => Log\Logger\Factory\OpenSearchLoggerFactory::class,
            Log\Logger\LoggerType::SlackNotification->name     => Log\Logger\Factory\SlackLoggerFactory::class,
            Log\Middleware\LoggerMiddleware::class             => Log\Middleware\LoggerMiddlewareFactory::class,
            ErrorListener\ElasticsearchListener::class         => ErrorListener\ElasticsearchListenerFactory::class,
            ErrorListener\OpenSearchListener::class            => ErrorListener\OpenSearchListenerFactory::class,
            ErrorListener\NewRelicListener::class              => ErrorListener\NewRelicListenerFactory::class,
            ErrorListener\FileListener::class                  => ErrorListener\FileListenerFactory::class,
            QueryParserInterface::class                        => ParserFactory::class,
            BodyParserInterface::class                         => ParserFactory::class,
            EncoderInterface::class                            => EncoderFactory::class,
            SchemaContainerInterface::class                    => SchemaContainerFactory::class,
            ThrowableHandlerInterface::class                   => ThrowableHandlerFactory::class,
        ],
        'delegators' => [
            Laminas\Stratigility\Middleware\ErrorHandler::class => [Handler\ErrorHandlerFactory::class],
        ],
    ],
];
