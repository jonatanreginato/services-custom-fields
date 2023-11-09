<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\OptionTypeAssociationEntity as BaseOptionTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Repository\Order\OptionTypeAssociationRepository;

#[Entity(repositoryClass: OptionTypeAssociationRepository::class)]
#[Table(name: 'metafield_option_resource_orders')]
class OptionTypeAssociationEntity extends BaseOptionTypeAssociationEntity
{
    #[ManyToOne(targetEntity: CustomFieldOptionEntity::class, inversedBy: 'dateAssociations')]
    #[JoinColumn(name: 'metafield_value_id', referencedColumnName: 'id')]
    public mixed $value;

    #[ManyToOne(targetEntity: CustomFieldEntity::class, inversedBy: 'dateAssociations')]
    #[JoinColumn(name: 'metafield_uuid', referencedColumnName: 'uuid')]
    public ?CustomFieldEntityInterface $customField = null;

    public string $ownerResource = 'order';
}
