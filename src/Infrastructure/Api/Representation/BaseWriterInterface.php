<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Representation;

interface BaseWriterInterface
{
    public function setUrlPrefix(string $prefix): self;

    public function setDataAsArray(): self;

    public function getDocument(): array;
}
