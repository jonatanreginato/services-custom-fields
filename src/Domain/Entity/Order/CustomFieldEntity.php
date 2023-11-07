<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Order;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\PersistentCollection;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntity as BaseCustomFieldEntity;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\CustomFieldRepository;

#[Entity(repositoryClass: CustomFieldRepository::class)]
#[Table(name: 'metafield_orders')]
class CustomFieldEntity extends BaseCustomFieldEntity
{
    #[OneToMany(mappedBy: 'customField', targetEntity: CustomFieldOptionEntity::class)]
    public ArrayCollection|PersistentCollection $options;

    #[OneToMany(mappedBy: 'customField', targetEntity: OptionTypeAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $optionAssociations;

    #[OneToMany(mappedBy: 'customField', targetEntity: TextTypeAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $textAssociations;

    #[OneToMany(mappedBy: 'customField', targetEntity: NumericTypeAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $numericAssociations;

    #[OneToMany(mappedBy: 'customField', targetEntity: DateTypeAssociationEntity::class)]
    public ArrayCollection|PersistentCollection $dateAssociations;
}
