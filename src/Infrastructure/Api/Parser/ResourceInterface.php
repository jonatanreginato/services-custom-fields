<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Parser;

use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\Schema\SchemaInterface;

interface ResourceInterface extends IdentifierInterface
{
    public function getEntity(): EntityInterface;

    public function getSchema(): SchemaInterface;

    public function getAttributes(): iterable;
}
