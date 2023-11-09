<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Http\Response;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ApiErrorInterface;
use Psr\Http\Message\ResponseInterface;

interface ResponsesInterface
{
    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_BAD_REQUEST = 400;

    public function getCodeResponse(
        int $statusCode,
        array $headers = []
    ): ResponseInterface;

    public function getContentResponse(
        object|array $data,
        int $statusCode = self::HTTP_OK,
        array $headers = []
    ): ResponseInterface;

    public function getCreatedResponse(
        object $resource,
        string $url,
        array $headers = []
    ): ResponseInterface;

    public function getErrorResponse(
        iterable|ApiErrorInterface $errors,
        int $statusCode = self::HTTP_BAD_REQUEST,
        array $headers = []
    ): ResponseInterface;
}
