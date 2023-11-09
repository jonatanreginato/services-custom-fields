<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Infrastructure\Api\Parser;

use Nuvemshop\CustomFields\Domain\Entity\EntityInterface;
use Nuvemshop\CustomFields\Domain\Schema\SchemaInterface;

interface ResourceInterface extends IdentifierInterface
{
    public function getEntity(): EntityInterface;

    public function getSchema(): SchemaInterface;

    public function getAttributes(): iterable;
}
