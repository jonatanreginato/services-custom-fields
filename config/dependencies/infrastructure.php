<?php

declare(strict_types=1);

use Nuvemshop\CustomFields\Application\Api\Query\ParametersMapper;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\BodyParserInterface;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\ParserFactory;
use Nuvemshop\CustomFields\Application\Api\Validation\Parser\QueryParserInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Encoder\EncoderFactory;
use Nuvemshop\CustomFields\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerFactory;
use Nuvemshop\CustomFields\Infrastructure\Api\Http\ThrowableHandlers\ThrowableHandlerInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Schema\SchemaContainerFactory;
use Nuvemshop\CustomFields\Infrastructure\Api\Schema\SchemaContainerInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Captures\CaptureAggregator;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ErrorAggregator;
use Nuvemshop\CustomFields\Infrastructure\Cors;
use Nuvemshop\CustomFields\Infrastructure\DataStore;
use Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Handler;
use Nuvemshop\CustomFields\Infrastructure\ErrorHandler\Listener as ErrorListener;
use Nuvemshop\CustomFields\Infrastructure\Jwt;
use Nuvemshop\CustomFields\Infrastructure\Log;
use Nuvemshop\CustomFields\Infrastructure\RequestId;

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
