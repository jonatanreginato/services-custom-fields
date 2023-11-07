<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\NumericTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\NumericTypeProductVariantAssociationRepository")
 * @ORM\Table(name="metafield_numeric_resource_product_variants")
 */
class NumericTypeProductVariantAssociationEntity extends NumericTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldEntity", inversedBy="numericAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
