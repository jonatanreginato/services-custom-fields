<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\CustomFields\Domain\Enum\ValueTypeEnum;
use Nuvemshop\CustomFields\Domain\Schema\CustomFieldSchema;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;

abstract class CustomFieldEntity implements CustomFieldEntityInterface
{
    #[Id]
    #[Column(name: 'uuid', type: Types::STRING)]
    public string|null $uuid = null;

    #[Column(name: 'namespace', type: Types::STRING)]
    public string $namespace;

    #[Column(name: 'key', type: Types::STRING)]
    public string $key;

    #[Column(name: 'store_id', type: Types::INTEGER)]
    public ?int $storeId;

    #[Column(name: 'owner_resource', type: Types::INTEGER)]
    public ?int $ownerResource;

    #[Column(name: 'value_type', type: Types::INTEGER)]
    public ?int $valueType;

    #[Column(name: 'source', type: Types::INTEGER)]
    public ?int $source;

    #[Column(name: 'name', type: Types::STRING)]
    public string $name;

    #[Column(name: 'description', type: Types::STRING)]
    public string $description;

    #[Column(name: 'read_only', type: Types::BOOLEAN)]
    public ?bool $readOnly;

    #[Column(name: 'app_id', type: Types::INTEGER)]
    public ?int $applicationId = null;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    public ?DateTime $createdAt = null;

    #[Column(name: 'updated_at', type: Types::DATETIME_MUTABLE)]
    public ?DateTime $updatedAt = null;

    #[Column(name: 'deleted_at', type: Types::DATETIME_MUTABLE)]
    public ?DateTime $deletedAt = null;

    public ArrayCollection|PersistentCollection $options;

    public ArrayCollection|PersistentCollection $optionAssociations;

    public ArrayCollection|PersistentCollection $textAssociations;

    public ArrayCollection|PersistentCollection $numericAssociations;

    public ArrayCollection|PersistentCollection $dateAssociations;

    public function __construct(AggregateInterface $customField)
    {
        /** @var CustomField $customField */

        $this->uuid                = $customField->uuid ? (string)$customField->uuid : null;
        $this->namespace           = (string)$customField->fieldNamespace;
        $this->key                 = (string)$customField->fieldKey;
        $this->storeId             = $customField->fieldStore?->getId();
        $this->ownerResource       = $customField->fieldOwnerResource?->getId();
        $this->valueType           = $customField->fieldValueType?->getId();
        $this->source              = $customField->fieldSource?->getId();
        $this->name                = (string)$customField->fieldName;
        $this->description         = (string)$customField->fieldDescription;
        $this->readOnly            = $customField->fieldRestriction?->isReadOnly();
        $this->applicationId       = $customField->fieldApplication?->getId();
        $this->options             = new ArrayCollection();
        $this->optionAssociations  = new ArrayCollection();
        $this->textAssociations    = new ArrayCollection();
        $this->numericAssociations = new ArrayCollection();
        $this->dateAssociations    = new ArrayCollection();
    }

    public function getSchemaClass(): string
    {
        return CustomFieldSchema::class;
    }

    public function getUuid(): string
    {
        return (string)$this->uuid;
    }

    public function setUUid(string $uuid): CustomFieldEntityInterface
    {
        $this->namespace = $uuid;

        return $this;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): CustomFieldEntityInterface
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): CustomFieldEntityInterface
    {
        $this->key = $key;

        return $this;
    }

    public function getStoreId(): int
    {
        return $this->storeId;
    }

    public function setStoreId(int $storeId): CustomFieldEntityInterface
    {
        $this->storeId = $storeId;

        return $this;
    }

    public function getOwnerResource(): int
    {
        return $this->ownerResource;
    }

    public function setOwnerResource(int $ownerResource): CustomFieldEntityInterface
    {
        $this->ownerResource = $ownerResource;

        return $this;
    }

    public function getValueType(): int
    {
        return $this->valueType;
    }

    public function setValueType(int $valueType): CustomFieldEntityInterface
    {
        $this->valueType = $valueType;

        return $this;
    }

    public function getSource(): int
    {
        return $this->source;
    }

    public function setSource(int $source): CustomFieldEntityInterface
    {
        $this->source = $source;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CustomFieldEntityInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): CustomFieldEntityInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function setReadOnly(bool $readOnly): CustomFieldEntityInterface
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function getApplicationId(): ?int
    {
        return $this->applicationId;
    }

    public function setAppId(int $applicationId): CustomFieldEntityInterface
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): CustomFieldEntityInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): CustomFieldEntityInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): CustomFieldEntityInterface
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getOptions(): ArrayCollection|PersistentCollection
    {
        return $this->options;
    }

    public function getAssociations(): ArrayCollection|PersistentCollection
    {
        return match ($this->valueType) {
            ValueTypeEnum::text_list->value => $this->optionAssociations,
            ValueTypeEnum::text->value => $this->textAssociations,
            ValueTypeEnum::numeric->value => $this->numericAssociations,
            ValueTypeEnum::date->value => $this->dateAssociations,
        };
    }
}
