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
            RequestId\RequestIdMiddleware::class               => RequestId\RequestIdMiddlewareFactory::class,
            Tuupola\Middleware\CorsMiddleware::class           => Cors\CorsMiddlewareFactory::class,
            Doctrine\ORM\EntityManager::class                  => DataStore\Doctrine\EntityManagerFactory::class,
            DataStore\Doctrine\ConnectionFacade::class         => DataStore\Doctrine\ConnectionFacadeFactory::class,
            DataStore\Elasticsearch\ElasticsearchFacade::class => DataStore\Elasticsearch\ElasticsearchFactory::class,
            Log\Logger\LoggerType::CONSOLE                     => Log\Logger\Factory\ConsoleLoggerFactory::class,
            Log\Logger\LoggerType::FILE                        => Log\Logger\Factory\FileLoggerFactory::class,
            Log\Logger\LoggerType::NEW_RELIC                   => Log\Logger\Factory\NewRelicLoggerFactory::class,
            Log\Logger\LoggerType::ELASTICSEARCH               => Log\Logger\Factory\ElasticsearchLoggerFactory::class,
            Log\Logger\LoggerType::SLACK                       => Log\Logger\Factory\SlackLoggerFactory::class,
            Log\Middleware\LoggerMiddleware::class             => Log\Middleware\LoggerMiddlewareFactory::class,
            ErrorListener\ElasticsearchListener::class         => ErrorListener\ElasticsearchListenerFactory::class,
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
