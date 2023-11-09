<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\ProductVariant;

use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\TextTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\CustomFields\Domain\Repository\TextTypeProductVariantAssociationRepository")
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
