<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\ApiRequest;

use Exception;
use Nuvemshop\CustomFields\Infrastructure\Exception\JsonProcessException;
use Throwable;

class HttpClientRequestException extends Exception
{
    private string $uri;

    private string $requestBody;

    private string $httpResponse;

    private int $httpStatusCode;

    public function __construct(
        string $message = '',
        string $uri = '',
        string $httpResponse = '',
        string $requestBody = '',
        int $httpStatusCode = 0,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->uri            = $uri;
        $this->requestBody    = $requestBody;
        $this->httpResponse   = $httpResponse;
        $this->httpStatusCode = $httpStatusCode;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function getRequestBody(): string
    {
        return $this->requestBody;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getHttpResponse(): ?string
    {
        return $this->httpResponse;
    }

    public function getHttpMessage(): ?string
    {
        try {
            $error = json_decode($this->httpResponse, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new JsonProcessException($e->getMessage());
        }

        return $error['message'];
    }
}
