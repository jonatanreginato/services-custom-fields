<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\Product;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\TextTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\TextTypeProductAssociationRepository")
 * @ORM\Table(name="metafield_text_resource_products")
 */
class TextTypeProductAssociationEntity extends TextTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductFieldEntity", inversedBy="textAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
