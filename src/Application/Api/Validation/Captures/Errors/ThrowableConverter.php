<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors;

use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiException;
use Throwable;

class ThrowableConverter implements ThrowableConverterInterface
{
    /**
     * This code provides an ability to transform various exceptions in API
     * (application specific, authorization, 3rd party, etc.) and convert it to API error.
     */
    public static function convert(Throwable $throwable): ?ApiException
    {
        $errors = static::createErrorWith(
            $throwable->getMessage(),
            $throwable->getCode() ?? 400
        );

        return new ApiException($errors, $throwable->getCode() ?? 400, $throwable);
    }

    private static function createErrorWith(string $detail, int $httpCode): ErrorCollection
    {
        return (new ErrorAggregator())->addApiError(
            'Error',
            $detail,
            (string)$httpCode
        );
    }
}
