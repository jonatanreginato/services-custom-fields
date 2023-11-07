<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

interface EntityInterface
{
    public function getSchemaClass(): string;
}
