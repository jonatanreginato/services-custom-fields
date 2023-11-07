<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

interface OptionEntityInterface extends EntityInterface
{
    public function getId(): ?int;

    public function getValue(): string;

    public function getCustomField(): CustomFieldEntityInterface;
}
