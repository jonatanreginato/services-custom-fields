<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\OptionTypeProductVariantAssociationRepository")
 * @ORM\Table(name="metafield_option_resource_product_variants")
 */
class OptionTypeProductVariantAssociationEntity extends OptionTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldOptionEntity")
     * @ORM\JoinColumn(name="metafield_value_id", referencedColumnName="id")
     */
    public OptionEntityInterface $value;

    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldEntity", inversedBy="optionAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
