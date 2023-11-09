<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Representation;

use Nuvemshop\CustomFields\Infrastructure\Api\Parser\ResourceInterface;

interface DocumentWriterInterface extends BaseWriterInterface
{
    public function addResourceToData(ResourceInterface $resource): self;
}
