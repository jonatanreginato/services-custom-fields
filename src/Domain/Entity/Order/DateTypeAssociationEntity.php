<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\DateTypeAssociationEntity as BaseDateTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\DateTypeAssociationRepository;

#[Entity(repositoryClass: DateTypeAssociationRepository::class)]
#[Table(name: 'metafield_date_resource_orders')]
class DateTypeAssociationEntity extends BaseDateTypeAssociationEntity
{
    #[ManyToOne(targetEntity: CustomFieldEntity::class, inversedBy: 'dateAssociations')]
    #[JoinColumn(name: 'metafield_uuid', referencedColumnName: 'uuid')]
    public ?CustomFieldEntityInterface $customField = null;

    public string $ownerResource = 'order';
}
