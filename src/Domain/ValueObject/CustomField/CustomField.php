<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\CustomField;

use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Infrastructure\Types\Uuid;

final readonly class CustomField implements AggregateInterface
{
    public function __construct(
        public CustomFieldUuid $uuid,
        public ?CustomFieldName $fieldName = null,
        public ?CustomFieldDescription $fieldDescription = null,
        public ?CustomFieldNamespace $fieldNamespace = null,
        public ?CustomFieldKey $fieldKey = null,
        public ?CustomFieldStore $fieldStore = null,
        public ?CustomFieldOwnerResource $fieldOwnerResource = null,
        public ?CustomFieldValueType $fieldValueType = null,
        public ?CustomFieldSource $fieldSource = null,
        public ?CustomFieldRestriction $fieldRestriction = null,
        public ?CustomFieldApplication $fieldApplication = null
    ) {
    }

    public static function createFromArray(array $data): self
    {
        $uuid = !empty($data['uuid'])
            ? new CustomFieldUuid((string)$data['uuid'])
            : new CustomFieldUuid((string)Uuid::new());

        return new CustomField(
            $uuid,
            isset($data['name']) ? new CustomFieldName($data['name']) : null,
            isset($data['description']) ? new CustomFieldDescription($data['description']) : null,
            isset($data['namespace']) ? new CustomFieldNamespace($data['namespace']) : null,
            isset($data['key']) || isset($data['name']) ? new CustomFieldKey($data['key'], $data['name']) : null,
            isset($data['store_id']) ? new CustomFieldStore((int)$data['store_id']) : null,
            isset($data['owner_resource']) ? new CustomFieldOwnerResource($data['owner_resource']) : null,
            isset($data['value_type']) ? new CustomFieldValueType($data['value_type']) : null,
            isset($data['source']) ? new CustomFieldSource($data['source']) : null,
            isset($data['read_only']) ? new CustomFieldRestriction((bool)$data['read_only']) : null,
            isset($data['app_id']) ? new CustomFieldApplication((int)$data['app_id']) : null,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid'           => (string)$this->uuid,
            'namespace'      => $this->fieldNamespace ? (string)$this->fieldNamespace : null,
            'key'            => $this->fieldKey ? (string)$this->fieldKey : null,
            'store_id'       => $this->fieldStore?->getId(),
            'owner_resource' => $this->fieldOwnerResource?->getId(),
            'value_type'     => $this->fieldValueType?->getId(),
            'source'         => $this->fieldSource?->getId(),
            'name'           => $this->fieldName ? (string)$this->fieldName : null,
            'description'    => $this->fieldDescription ? (string)$this->fieldDescription : null,
            'read_only'      => (bool)$this->fieldRestriction?->isReadOnly(),
            'app_id'         => $this->fieldApplication?->getId(),
        ];
    }

    public function getUuid(): ?string
    {
        return (string)$this->uuid;
    }

    public function getNamespace(): ?string
    {
        return $this->fieldNamespace
            ? (string)$this->fieldNamespace
            : null;
    }

    public function getKey(): ?string
    {
        return $this->fieldKey
            ? (string)$this->fieldKey
            : null;
    }

    public function getStoreId(): ?int
    {
        return $this->fieldStore?->getId();
    }

    public function getOwnerResourceId(): ?int
    {
        return $this->fieldOwnerResource?->getId();
    }

    public function getValueTypeId(): ?int
    {
        return $this->fieldValueType?->getId();
    }

    public function getSourceId(): ?int
    {
        return $this->fieldSource?->getId();
    }

    public function getName(): ?string
    {
        return $this->fieldName
            ? (string)$this->fieldName
            : null;
    }

    public function getDescription(): ?string
    {
        return $this->fieldDescription
            ? (string)$this->fieldDescription
            : null;
    }

    public function isReadOnly(): bool
    {
        return (bool)$this->fieldRestriction?->isReadOnly();
    }

    public function getApplicationId(): ?int
    {
        return $this->fieldApplication?->getId();
    }
}
