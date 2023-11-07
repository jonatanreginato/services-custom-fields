<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Headers;

interface MediaTypeInterface
{
    public const JSON_MEDIA_TYPE = 'application/json';
    public const TYPE = 'application';
    public const SUB_TYPE = 'json';

    public function getType(): string;

    public function getSubType(): string;

    public function getMediaType(): string;
}
