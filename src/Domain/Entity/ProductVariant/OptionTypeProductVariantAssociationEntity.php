<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Domain\Entity\ProductVariant;

use Nuvemshop\CustomFields\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\OptionEntityInterface;
use Nuvemshop\CustomFields\Domain\Entity\OptionTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\CustomFields\Domain\Repository\OptionTypeProductVariantAssociationRepository")
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
