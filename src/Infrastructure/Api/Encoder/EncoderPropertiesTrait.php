<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Encoder;

use Psr\Http\Message\UriInterface;

use function assert;

trait EncoderPropertiesTrait
{
    private ?UriInterface $originalUri = null;

    private string $urlPrefix = Encoder::DEFAULT_URL_PREFIX;

    private int $encodeOptions = Encoder::DEFAULT_JSON_ENCODE_OPTIONS;

    private int $encodeDepth = Encoder::DEFAULT_JSON_ENCODE_DEPTH;

    public function withOriginalUri(UriInterface $uri): EncoderInterface
    {
        $this->originalUri = $uri;

        return $this;
    }

    public function withUrlPrefix(string $prefix): EncoderInterface
    {
        $this->urlPrefix = $prefix;

        return $this;
    }

    public function withEncodeOptions(int $options): EncoderInterface
    {
        $this->encodeOptions = $options;

        return $this;
    }

    public function withEncodeDepth(int $depth): EncoderInterface
    {
        assert($depth > 0);

        $this->encodeDepth = $depth;

        return $this;
    }
}
