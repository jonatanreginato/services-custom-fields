<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\Association;

use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;

final readonly class Association implements AggregateInterface
{
    public function __construct(
        public ?IdentifierType $identifier = null,
        public ?AssociationValue $associationValue = null,
        public ?AssociationOwner $associationOwner = null,
        public ?CustomField $customField = null
    ) {
    }

    public static function createFromArray(array $data): self
    {
        return new Association(
            isset($data['id']) ? new IdentifierType((int)$data['id']) : null,
            new AssociationValue((string)($data['value'] ?? '')),
            new AssociationOwner((int)($data['owner_id'] ?? '')),
            new CustomField(new CustomFieldUuid((string)($data['uuid'] ?? null)))
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id'       => $this->identifier?->getId(),
            'value'    => $this->associationValue ? (string)$this->associationValue : null,
            'owner_id' => $this->associationOwner?->getId(),
            'uuid'     => $this->customField
                ? json_encode($this->customField, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)
                : null
        ];
    }

    public function getId(): ?int
    {
        return $this->identifier?->getId();
    }

    public function getValue(): ?string
    {
        return $this->associationValue
            ? (string)$this->associationValue
            : null;
    }

    public function getOwnerId(): ?int
    {
        return $this->associationOwner?->getId();
    }

    public function getCustomFieldUuid(): ?CustomFieldUuid
    {
        return $this->customField?->uuid;
    }
}
