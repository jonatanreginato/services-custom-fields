<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\NumericTypeAssociationEntity as BaseNumericTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Repository\Order\NumericTypeAssociationRepository;

#[Entity(repositoryClass: NumericTypeAssociationRepository::class)]
#[Table(name: 'metafield_numeric_resource_orders')]
class NumericTypeAssociationEntity extends BaseNumericTypeAssociationEntity
{
    #[ManyToOne(targetEntity: CustomFieldEntity::class, inversedBy: 'numericAssociations')]
    #[JoinColumn(name: 'metafield_uuid', referencedColumnName: 'uuid')]
    public ?CustomFieldEntityInterface $customField = null;

    public string $ownerResource = 'order';
}
