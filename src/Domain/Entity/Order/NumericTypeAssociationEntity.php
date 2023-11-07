<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\NumericTypeAssociationEntity as BaseNumericTypeAssociationEntity;
use Nuvemshop\ApiTemplate\Domain\Repository\Order\NumericTypeAssociationRepository;

#[Entity(repositoryClass: NumericTypeAssociationRepository::class)]
#[Table(name: 'metafield_numeric_resource_orders')]
class NumericTypeAssociationEntity extends BaseNumericTypeAssociationEntity
{
    #[ManyToOne(targetEntity: CustomFieldEntity::class, inversedBy: 'numericAssociations')]
    #[JoinColumn(name: 'metafield_uuid', referencedColumnName: 'uuid')]
    public ?CustomFieldEntityInterface $customField = null;

    public string $ownerResource = 'order';
}
