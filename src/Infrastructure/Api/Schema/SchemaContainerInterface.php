<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Schema;

use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Schema\SchemaInterface;

interface SchemaContainerInterface
{
    public function getSchema(EntityInterface $entity): SchemaInterface;

    public function hasSchema(EntityInterface $entity): bool;
}
