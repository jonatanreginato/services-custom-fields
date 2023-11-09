<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

use DateTime;

interface AssociationEntityInterface extends EntityInterface
{
    public function getId(): ?int;

    public function getOwnerId(): int;

    public function getValue(): mixed;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): ?DateTime;

    public function getCustomField(): CustomFieldEntityInterface;
}
