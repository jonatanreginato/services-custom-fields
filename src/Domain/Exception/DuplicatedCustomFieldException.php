<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Exception;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiException;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiExceptionInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ApiError;

class DuplicatedCustomFieldException extends ApiException implements ApiExceptionInterface
{
    public function __construct(string $key)
    {
        parent::__construct(
            new ApiError(
                (string)ApiException::HTTP_CODE_CONFLICT,
                '',
                sprintf('The metafield with key <%s> is duplicated', $key),
            ),
            ApiException::HTTP_CODE_CONFLICT
        );
    }
}
