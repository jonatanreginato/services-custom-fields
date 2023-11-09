<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

interface EntityInterface
{
    public function getSchemaClass(): string;
}
