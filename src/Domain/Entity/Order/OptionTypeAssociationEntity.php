<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionTypeAssociationEntity as BaseOptionTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\OptionTypeAssociationRepository;

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
}
