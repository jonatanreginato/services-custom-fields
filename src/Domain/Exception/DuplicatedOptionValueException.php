<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Exception;

use Nuvemshop\CustomFields\Infrastructure\Api\Exceptions\ApiException;
use Nuvemshop\CustomFields\Infrastructure\Api\Exceptions\ApiExceptionInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ApiError;

class DuplicatedOptionValueException extends ApiException implements ApiExceptionInterface
{
    public function __construct(string $key)
    {
        parent::__construct(
            new ApiError(
                (string)ApiException::HTTP_CODE_CONFLICT,
                '',
                sprintf('The option with value <%s> is duplicated', $key),
            ),
            ApiException::HTTP_CODE_CONFLICT
        );
    }
}
