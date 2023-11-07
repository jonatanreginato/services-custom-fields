<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Application\Api\Exceptions;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiException;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorAggregator;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ErrorCollection;
use Nuvemshop\ApiTemplate\Infrastructure\JsonApi\Exceptions\AuthorizationException;
use Nuvemshop\ApiTemplate\Infrastructure\JsonApi\Passport\Exceptions\AuthenticationException;
use Throwable;

class ThrowableConverter implements ThrowableConverterInterface
{
    /**
     * This code provides an ability to transform various exceptions in API
     * (application specific, authorization, 3rd party, etc.) and convert it to API error.
     */
    public static function convert(Throwable $throwable): ?ApiException
    {
        $converted = null;

        if ($throwable instanceof AuthorizationException) {
            $httpCode  = 403;
            $action    = $throwable->getAction();
            $errors    = static::createErrorWith(
                'Unauthorized',
                "You are not unauthorized for action `$action`.",
                $httpCode
            );
            $converted = new ApiException($errors, $httpCode, $throwable);
        } elseif ($throwable instanceof AuthenticationException) {
            $httpCode  = 401;
            $errors    = static::createErrorWith('Authentication failed', 'Authentication failed', $httpCode);
            $converted = new ApiException($errors, $httpCode, $throwable);
        }

        return $converted;
    }

    private static function createErrorWith(string $title, string $detail, int $httpCode): ErrorCollection
    {
        return (new ErrorAggregator())->addApiError(
            $title,
            $detail,
            (string)$httpCode
        );
    }
}
