<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

interface CustomFieldEntityInterface extends EntityInterface
{
    public function getUuid(): string;

    public function getNamespace(): string;

    public function getKey(): string;

    public function getStoreId(): int;

    public function getOwnerResource(): int;

    public function getValueType(): int;

    public function getSource(): int;

    public function getName(): string;

    public function getDescription(): string;

    public function getReadOnly(): bool;

    public function getApplicationId(): ?int;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): ?DateTime;

    public function getDeletedAt(): ?DateTime;

    public function getOptions(): ArrayCollection|PersistentCollection;

    public function getAssociations(): ArrayCollection|PersistentCollection;
}
