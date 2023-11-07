<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Nuvemshop\ApiTemplate\Domain\Entity\Order\CustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Schema\AssociationSchema;

abstract class AssociationEntity implements AssociationEntityInterface
{
    #[Id]
    #[Column(name: 'id', type: Types::INTEGER)]
    #[GeneratedValue(strategy: 'AUTO')]
    public ?int $id = null;

    public ?CustomFieldEntityInterface $customField = null;

    #[Column(name: 'owner_id', type: Types::INTEGER)]
    public int $ownerId;

    public mixed $value;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    public ?DateTime $createdAt = null;

    #[Column(name: 'updated_at', type: 'datetime')]
    public ?DateTime $updatedAt = null;

    public function getSchemaClass(): string
    {
        return AssociationSchema::class;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): AssociationEntityInterface
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): AssociationEntityInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): AssociationEntityInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCustomField(): CustomFieldEntityInterface
    {
        return $this->customField;
    }

    public function setCustomField(CustomFieldEntity $customField): AssociationEntityInterface
    {
        $this->customField = $customField;

        return $this;
    }

    public function getOwnerResource(): string
    {
        return $this->ownerResource;
    }
}
