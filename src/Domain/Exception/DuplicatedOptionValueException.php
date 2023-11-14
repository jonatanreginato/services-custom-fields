<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Exception;

use Nuvemshop\CustomFields\Application\Api\Validation\Captures\Errors\ApiError;
use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiException;
use Nuvemshop\CustomFields\Application\Api\Validation\Exceptions\ApiExceptionInterface;

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
