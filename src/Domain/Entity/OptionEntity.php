<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Nuvemshop\CustomFields\Domain\Schema\OptionSchema;

abstract class OptionEntity implements OptionEntityInterface
{
    #[Id]
    #[Column(name: 'id', type: Types::INTEGER)]
    #[GeneratedValue(strategy: 'AUTO')]
    public int|null $id = null;

    #[Column(name: 'value', type: Types::STRING)]
    public string $value;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    public ?DateTime $createdAt = null;

    #[Column(name: 'updated_at', type: Types::DATETIME_MUTABLE)]
    public ?DateTime $updatedAt = null;

    public ?CustomFieldEntityInterface $customField = null;

    public function getSchemaClass(): string
    {
        return OptionSchema::class;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): OptionEntityInterface
    {
        $this->value = $value;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): OptionEntity
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): OptionEntity
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCustomField(): CustomFieldEntityInterface
    {
        return $this->customField;
    }

    public function setCustomField(CustomFieldEntityInterface $customField): OptionEntityInterface
    {
        $this->customField = $customField;

        return $this;
    }
}
