<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Encoder;

use Nuvemshop\CustomFields\Infrastructure\Api\Validation\Errors\ApiErrorInterface;
use Psr\Http\Message\UriInterface;

interface EncoderInterface
{
    public function encodeData(iterable|object|null $data): string;

    public function encodeError(ApiErrorInterface $error): string;

    public function encodeErrors(iterable $errors): string;

    public function withOriginalUri(UriInterface $uri): self;

    public function withUrlPrefix(string $prefix): self;

    public function withEncodeOptions(int $options): self;

    public function withEncodeDepth(int $depth): self;
}
