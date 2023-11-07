<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\TextTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\TextTypeProductVariantAssociationRepository")
 * @ORM\Table(name="metafield_text_resource_product_variants")
 */
class TextTypeProductVariantAssociationEntity extends TextTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldEntity", inversedBy="textAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField;
}
