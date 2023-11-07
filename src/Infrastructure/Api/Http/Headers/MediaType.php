<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Http\Headers;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Exceptions\ApiInvalidArgumentException;

use function trim;

class MediaType implements MediaTypeInterface
{
    private string $type;

    private string $subType;

    private ?string $mediaType = null;

    public function __construct(string $type, string $subType)
    {
        $type = trim($type);
        if (empty($type)) {
            throw new ApiInvalidArgumentException('type');
        }

        $subType = trim($subType);
        if (empty($subType)) {
            throw new ApiInvalidArgumentException('subType');
        }

        $this->type    = $type;
        $this->subType = $subType;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSubType(): string
    {
        return $this->subType;
    }

    public function getMediaType(): string
    {
        if ($this->mediaType === null) {
            $this->mediaType = $this->type . '/' . $this->subType;
        }

        return $this->mediaType;
    }
}
