<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\ValueObject\Option;

use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomField;
use Nuvemshop\CustomFields\Domain\ValueObject\CustomField\CustomFieldUuid;
use Nuvemshop\CustomFields\Domain\ValueObject\IdentifierType;

final readonly class Option implements AggregateInterface
{
    public function __construct(
        public ?IdentifierType $identifier,
        public ?OptionValue $optionValue = null,
        public ?CustomField $customField = null
    ) {
    }

    public static function createFromArray(array $data): self
    {
        return new Option(
            isset($data['id']) ? new IdentifierType((int)$data['id']) : null,
            new OptionValue((string)($data['value'] ?? '')),
            new CustomField(new CustomFieldUuid((string)($data['uuid'] ?? null)))
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->identifier?->getId(),
            'value' => $this->optionValue ? (string)$this->optionValue : null,
            'uuid'  => $this->customField
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
        return $this->optionValue
            ? (string)$this->optionValue
            : null;
    }

    public function getCustomFieldUuid(): ?CustomFieldUuid
    {
        return $this->customField?->uuid;
    }
}
