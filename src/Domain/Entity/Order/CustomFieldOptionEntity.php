<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\OptionEntity as BaseCustomFieldOptionEntity;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionRepository;
use Nuvemshop\CustomFields\Domain\ValueObject\AggregateInterface;
use Nuvemshop\CustomFields\Domain\ValueObject\Option\Option;

#[Entity(repositoryClass: OptionRepository::class)]
#[Table(name: 'metafield_option_orders')]
class CustomFieldOptionEntity extends BaseCustomFieldOptionEntity
{
    #[ManyToOne(targetEntity: CustomFieldEntity::class, cascade: ['persist'], inversedBy: 'options')]
    #[JoinColumn(name: 'metafield_uuid', referencedColumnName: 'uuid')]
    public ?CustomFieldEntityInterface $customField = null;

    public function __construct(AggregateInterface $option, CustomFieldEntity $customFieldEntity)
    {
        /** @var Option $option */

        $this->id          = $option->identifier?->getId();
        $this->value       = (string)$option->optionValue;
        $this->customField = $customFieldEntity;
    }
}
