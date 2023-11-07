<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder\EncoderInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Headers\MediaTypeInterface;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Validation\Errors\ApiErrorInterface;
use Psr\Http\Message\ResponseInterface;

use function assert;
use function is_iterable;

class Responses implements ResponsesInterface
{
    private const HEADER_CONTENT_TYPE = 'Content-Type';
    private const HEADER_LOCATION = 'Location';

    public function __construct(
        public readonly MediaTypeInterface $outputMediaType,
        public readonly EncoderInterface $encoder
    ) {
    }

    public function getCodeResponse(int $statusCode, array $headers = []): ResponseInterface
    {
        return $this->createApiResponse(null, $statusCode, $headers, false);
    }

    public function getContentResponse(
        object|array $data,
        int $statusCode = self::HTTP_OK,
        array $headers = []
    ): ResponseInterface {
        $content = $this->encoder->encodeData($data);

        return $this->createApiResponse($content, $statusCode, $headers);
    }

    public function getCreatedResponse(object $resource, string $url, array $headers = []): ResponseInterface
    {
        $content = $this->encoder->encodeData($resource);
        $headers[self::HEADER_LOCATION] = $url;

        return $this->createApiResponse($content, self::HTTP_CREATED, $headers);
    }

    public function getErrorResponse(
        iterable|ApiErrorInterface $errors,
        int $statusCode = self::HTTP_BAD_REQUEST,
        array $headers = []
    ): ResponseInterface {
        if (is_iterable($errors)) {
            /** @var iterable $errors */
            $content = $this->encoder->encodeErrors($errors);

            return $this->createApiResponse($content, $statusCode, $headers);
        }

        assert($errors instanceof ApiErrorInterface);
        $content = $this->encoder->encodeError($errors);

        return $this->createApiResponse($content, $statusCode, $headers);
    }

    private function createApiResponse(
        ?string $content,
        int $statusCode,
        array $headers = [],
        bool $addContentType = true
    ): ResponseInterface {
        if ($addContentType) {
            $headers[self::HEADER_CONTENT_TYPE] = $this->outputMediaType->getMediaType();
        }

        return $this->createResponse($content, $statusCode, $headers);
    }

    private function createResponse(?string $content, int $statusCode, array $headers): ResponseInterface
    {
        return new ApiResponse($content, $statusCode, $headers);
    }
}
