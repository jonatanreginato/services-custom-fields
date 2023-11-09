<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\Order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\TextTypeAssociationEntity as BaseTextTypeAssociationEntity;
use Nuvemshop\CustomFields\Domain\Repository\Order\TextTypeAssociationRepository;

#[Entity(repositoryClass: TextTypeAssociationRepository::class)]
#[Table(name: 'metafield_text_resource_orders')]
class TextTypeAssociationEntity extends BaseTextTypeAssociationEntity
{
    #[ManyToOne(targetEntity: CustomFieldEntity::class, inversedBy: 'textAssociations')]
    #[JoinColumn(name: 'metafield_uuid', referencedColumnName: 'uuid')]
    public ?CustomFieldEntityInterface $customField;

    public string $ownerResource = 'order';
}
