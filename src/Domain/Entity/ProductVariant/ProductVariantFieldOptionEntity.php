<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\OptionEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\ProductVariantFieldOptionRepository")
 * @ORM\Table(name="metafield_option_product_variants")
 */
class ProductVariantFieldOptionEntity extends OptionEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldEntity", inversedBy="options")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
