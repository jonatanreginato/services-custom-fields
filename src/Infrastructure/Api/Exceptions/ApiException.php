<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Exceptions;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ApiErrorInterface;
use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ErrorCollection;
use Throwable;

use function is_iterable;

class ApiException extends BaseApiException
{
    public const HTTP_CODE_BAD_REQUEST = 400;
    public const HTTP_CODE_FORBIDDEN = 403;
    public const HTTP_CODE_NOT_ACCEPTABLE = 406;
    public const HTTP_CODE_CONFLICT = 409;
    public const HTTP_CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    public const DEFAULT_HTTP_CODE = self::HTTP_CODE_BAD_REQUEST;

    private ErrorCollection $errors;

    private int $httpCode;

    public function __construct(
        ApiErrorInterface|iterable $errors,
        int $httpCode = self::DEFAULT_HTTP_CODE,
        Throwable $previous = null
    ) {
        parent::__construct('API error', 0, $previous);

        if ($errors instanceof ErrorCollection) {
            $this->errors = clone $errors;
        } elseif (is_iterable($errors)) {
            $this->errors = new ErrorCollection();
            $this->addErrors($errors);
        } else {
            // should be ApiErrorInterface
            $this->errors = new ErrorCollection();
            $this->addError($errors);
        }

        $this->httpCode = $httpCode;
    }

    public function addError(ApiErrorInterface $error): void
    {
        $this->errors[] = $error;
    }

    public function addErrors(iterable $errors): void
    {
        foreach ($errors as $error) {
            $this->addError($error);
        }
    }

    public function getErrors(): ErrorCollection
    {
        return $this->errors;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
