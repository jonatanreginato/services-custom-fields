<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Representation;

use Nuvemshop\ApiTemplate\Infrastructure\Api\Parser\ResourceInterface;

interface DocumentWriterInterface extends BaseWriterInterface
{
    public function addResourceToData(ResourceInterface $resource): self;
}
