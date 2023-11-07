<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Api\Schema;

use Nuvemshop\ApiTemplate\Domain\Entity\EntityInterface;
use Nuvemshop\ApiTemplate\Domain\Schema\SchemaInterface;

interface SchemaContainerInterface
{
    public function getSchema(EntityInterface $entity): SchemaInterface;

    public function hasSchema(EntityInterface $entity): bool;
}
