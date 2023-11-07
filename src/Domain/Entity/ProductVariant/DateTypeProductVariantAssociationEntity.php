<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Domain\Entity\ProductVariant;

use Nuvemshop\ApiTemplate\Domain\Entity\CustomFieldEntityInterface;
use Nuvemshop\ApiTemplate\Domain\Entity\DateTypeAssociationEntity;

/**
 * @ORM\Entity(repositoryClass="Nuvemshop\ApiTemplate\Domain\Repository\DateTypeProductVariantAssociationRepository")
 * @ORM\Table(name="metafield_date_resource_product_variants")
 */
class DateTypeProductVariantAssociationEntity extends DateTypeAssociationEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="ProductVariantFieldEntity", inversedBy="dateAssociations")
     * @ORM\JoinColumn(name="metafield_uuid", referencedColumnName="uuid")
     */
    public ?CustomFieldEntityInterface $customField = null;
}
