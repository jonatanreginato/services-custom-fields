<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Response;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\InjectContentTypeTrait;
use Laminas\Diactoros\Stream;
use Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Headers\MediaTypeInterface;

class ApiResponse extends Response
{
    use InjectContentTypeTrait;

    public const HTTP_OK = 200;
    public const HTTP_CREATED = 201;
    public const HTTP_NO_CONTENT = 204;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_CONFLICT = 409;
    public const HTTP_UNPROCESSABLE_ENTITY = 422;

    public function __construct(string $content = null, int $status = 200, array $headers = [])
    {
        $body = new Stream('php://temp', 'wb+');

        if ($content !== null) {
            $body->write($content);
            $body->rewind();
        }

        // inject content-type even when there is no content otherwise
        // it would be set to 'text/html' by PHP/Web server/Browser
        $headers = $this->injectContentType(MediaTypeInterface::JSON_MEDIA_TYPE, $headers);

        parent::__construct($body, $status, $headers);
    }
}
